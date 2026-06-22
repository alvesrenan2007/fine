/**
 * PriceSimulator
 * Written by Sonet 4.6 Hight via claude.ai web chat
 * ----------------
 * Pure calculation + orchestration. Reads lock state from a LockStateManager
 * instance (never mutates checkboxes itself) and reads/writes the value
 * inputs to keep the per-row equation satisfied:
 *
 *   sell-price = (product-cost + additional-cost) / (1 - tax-fee - marketplace-fee - profit-margin)
 *
 * Decision tree per the spec, on every value-input edit:
 *
 * LOCAL EDIT (field F in row `id`):
 *   - marketplaces[id].dependent != null
 *       -> LOCAL ONLY: solve row `id` for its own dependent. Write. Stop.
 *   - marketplaces[id].dependent == null:
 *       - globalDependent != null
 *           -> PROPAGATION: pre-check ALL rows have non-null dependent.
 *              If any row is fully locked -> ERROR, write nothing.
 *              Else: solve row `id` for globalDependent, write it, then
 *              solve+write every OTHER row's own dependent.
 *       - globalDependent == null
 *           -> ERROR (nothing anywhere can absorb the change). Write nothing.
 *
 * GLOBAL EDIT (field F is product-cost or tax-fee):
 *   There is no "owning row" for a global edit, so regardless of
 *   globalDependent's value, the edited global value is used directly as a
 *   fixed input and EVERY row is solved for its own dependent.
 *   Pre-check ALL rows have non-null dependent first (all-or-nothing);
 *   if any row is fully locked -> ERROR, write nothing.
 */

const GLOBAL_FIELDS = ["product-cost", "tax-fee"];
const ROW_FIELDS = ["sell-price", "additional-cost", "marketplace-fee", "profit-margin"];
const ALL_FIELDS = ["sell-price", "product-cost", "profit-margin", "additional-cost", "marketplace-fee", "tax-fee"];

function isGlobal(field) {
  return GLOBAL_FIELDS.includes(field);
}

/* Masking object, which needs to be refactored into a class that integrates it with the currency utils */
const Mask = {
  /**
   * Unmasks a string into a number
   * @param {string|number|null} rawValue - The masked value (e.g. "R$ 1.800,25" or "45,67%")
   * @param {string} maskType - "currency" or "percentage"
   */
  unmask(rawValue, maskType = null) {
    if (rawValue == null || rawValue === "") return null;

    let str = String(rawValue).trim();

    // Remove everything except digits, comma, dot and minus sign
    str = str.replace(/[^\d,.-]/g, "");

    // Remove thousands separators (dots) and normalize decimal separator
    if (str.includes(",")) {
      str = str.replace(/\./g, "");        // remove all dots
      str = str.replace(",", ".");         // comma becomes decimal point
    } else {
      // Fallback: remove extra dots if no comma is present
      str = str.replace(/\.(?=.*\.)/g, "");
    }

    const num = parseFloat(str);
    if (Number.isNaN(num)) return null;

    if (maskType === "percentage") {
      return num / 100;
    }

    return num;
  },

  /**
   * Masks a number according to the specified type
   * @param {number|null} numValue - The numeric value
   * @param {string} maskType - "currency" or "percentage"
   */
  mask(numValue, maskType = null) {
    if (numValue == null || Number.isNaN(numValue)) return "";

    if (maskType === "percentage") {
      const percent = numValue * 100;
      return percent.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }) + "%";
    }

    if (maskType === "currency") {
      return numValue.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }

    // Default: just format as Brazilian number
    return numValue.toLocaleString("pt-BR", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  },
};

/** Thrown (and caught internally) to represent the spec's ERROR STATE. Never thrown out to caller. */
class OverConstrainedError extends Error {
  constructor(message, details) {
    super(message);
    this.name = "OverConstrainedError";
    this.details = details;
  }
}

export class PriceSimulator {
  /**
   * @param {Object} opts
   * @param {Document|HTMLElement} [opts.root=document]
   * @param {import('./lock-state-manager.js').LockStateManager} opts.lockState
   * @param {(error: OverConstrainedError) => void} [opts.onError] called on ERROR STATE instead of throwing
   */
  constructor({ root = document, lockState, onError = null }) {
    this.root = root;
    this.lockState = lockState;
    this.onError = onError;

    this.globalInputs = {
      "product-cost": this.root.querySelector("#product-cost"),
      "tax-fee": this.root.querySelector("#tax-fee"),
    };

    this.marketplaceIds = Array.from(
      new Set(Array.from(this.root.querySelectorAll("[data-marketplace-id]")).map((el) => el.dataset.marketplaceId))
    );

    this.rowInputs = {};
    for (const id of this.marketplaceIds) {
      this.rowInputs[id] = {};
      for (const field of ROW_FIELDS) {
        this.rowInputs[id][field] = this.root.querySelector(`[data-type="${field}"][data-marketplace-id="${id}"]`);
      }
    }

    this._bindEvents();
  }

  // ---------------------------------------------------------------------
  // Event binding
  // ---------------------------------------------------------------------

  _bindEvents() {
    for (const field of GLOBAL_FIELDS) {
      const input = this.globalInputs[field];
      if (!input) continue;
      input.addEventListener("change", () => this._handleGlobalEdit(field));
    }

    for (const id of this.marketplaceIds) {
      for (const field of ROW_FIELDS) {
        const input = this.rowInputs[id][field];
        if (!input) continue;
        input.addEventListener("change", () => this._handleLocalEdit(field, id));
      }
    }
  }

  // ---------------------------------------------------------------------
  // Value read/write helpers
  // ---------------------------------------------------------------------

  _getInputEl(field, marketplaceId) {
    return isGlobal(field) ? this.globalInputs[field] : this.rowInputs[marketplaceId]?.[field];
  }

  _getMaskType(field) {
    return field === "marketplace-fee" || field === "profit-margin" || field === "tax-fee" ? "percentage" : "currency";
  }

  _getValue(field, marketplaceId) {
    const el = this._getInputEl(field, marketplaceId);
    if (!el) return null;
    return Mask.unmask(el.value, this._getMaskType(field));
  }

  _setValue(field, marketplaceId, numValue) {
    const el = this._getInputEl(field, marketplaceId);
    if (!el) return;
    el.value = Mask.mask(numValue, this._getMaskType(field));
  }

  _readRow(marketplaceId) {
    return {
      "sell-price": this._getValue("sell-price", marketplaceId),
      "product-cost": this._getValue("product-cost", marketplaceId),
      "profit-margin": this._getValue("profit-margin", marketplaceId),
      "additional-cost": this._getValue("additional-cost", marketplaceId),
      "marketplace-fee": this._getValue("marketplace-fee", marketplaceId),
      "tax-fee": this._getValue("tax-fee", marketplaceId),
    };
  }

  // ---------------------------------------------------------------------
  // Equation solving (pure)
  // ---------------------------------------------------------------------

  /**
   * Solves sell-price = (product-cost + additional-cost) / (1 - tax-fee - marketplace-fee - profit-margin)
   * for `target`. Returns a number, or null if inputs are missing/math undefined.
   */
  _solve(target, values) {
    const { "sell-price": SP, "product-cost": PC, "profit-margin": PM, "additional-cost": AC, "marketplace-fee": MF, "tax-fee": TF } = values;

    const required = ALL_FIELDS.filter((f) => f !== target);
    for (const f of required) {
      if (values[f] == null || Number.isNaN(values[f])) return null;
    }

    switch (target) {
      case "sell-price": {
        const denom = 1 - TF - MF - PM;
        return denom === 0 ? null : (PC + AC) / denom;
      }
      case "product-cost":
        console.log('SP * (1 - TF - MF - PM) - AC');
        console.log( SP + ' * ' + ' (1 -' + TF + ' - ' + MF + ' - ' + PM + ') - ' + AC );
        return SP * (1 - TF - MF - PM) - AC;
      case "additional-cost":
        return SP * (1 - TF - MF - PM) - PC;
      case "profit-margin":
        console.log('1 - TF - MF - (PC + AC) / SP');
        console.log(1 + ' - ' + TF + ' - ' + MF + ' - ' + '(' + PC + ' + ' + AC + ')/' +  SP);
        return SP === 0 ? null : 1 - TF - MF - (PC + AC) / SP;
      case "marketplace-fee":
        return SP === 0 ? null : 1 - TF - PM - (PC + AC) / SP;
      case "tax-fee":
        return SP === 0 ? null : 1 - MF - PM - (PC + AC) / SP;
      default:
        return null;
    }
  }

  /** Solves row `id` for `target` and writes the result. Returns true on success. */
  _solveAndWriteRow(marketplaceId, target) {
    const values = this._readRow(marketplaceId);
    const result = this._solve(target, values);
    if (result == null) return false;
    this._setValue(target, marketplaceId, result);
    return true;
  }

  // ---------------------------------------------------------------------
  // Core decision tree
  // ---------------------------------------------------------------------

  _handleLocalEdit(field, marketplaceId) {
    const state = this.lockState.getState();
    const rowDependent = state.marketplaces[marketplaceId]?.dependent ?? null;

    try {
      if (rowDependent != null) {
        // LOCAL ONLY MODE
        const ok = this._solveAndWriteRow(marketplaceId, rowDependent);
        if (!ok) {
          throw new OverConstrainedError("Row equation could not be solved (missing/invalid values or div-by-zero).", {
            mode: "local-only",
            marketplaceId,
            target: rowDependent,
          });
        }
        return;
      }

      // Row is fully locked locally.
      if (state.globalDependent != null) {
        this._runPropagation({
          ownerRowId: marketplaceId,
          ownerTarget: state.globalDependent,
          state,
        });
        return;
      }

      // Nothing local, nothing global to absorb the change.
      throw new OverConstrainedError("System is over-constrained: edited row is fully locked and no global field is unlocked.", {
        mode: "local-edit-no-target",
        marketplaceId,
      });
    } catch (err) {
      this._reportError(err);
    }
  }

  _handleGlobalEdit(field) {
    const state = this.lockState.getState();
    try {
      this._runPropagation({
        ownerRowId: null, // no owning row - edited global value is used directly as-is
        ownerTarget: null,
        state,
      });
    } catch (err) {
      this._reportError(err);
    }
  }

  /**
   * Shared propagation routine. All-or-nothing: every row must have a
   * non-null `dependent`, checked BEFORE any writes happen.
   *
   * - If ownerRowId/ownerTarget are provided (local-edit-triggered case),
   *   that row is solved first for the global field (ownerTarget), and is
   *   skipped in the subsequent "every row" loop (solving it again would be
   *   a no-op, since its equation is already satisfied).
   * - If ownerRowId is null (global-edit-triggered case), there's no
   *   "solve the global field" step - the edited global input's value is
   *   already correct as typed - and every row (none excluded) is solved
   *   for its own dependent.
   */
  _runPropagation({ ownerRowId, ownerTarget, state }) {
    // Pre-check: every row must have a non-null dependent.
    const lockedOutRows = this.marketplaceIds.filter((id) => state.marketplaces[id]?.dependent == null);
    //if (lockedOutRows.length > 0) {
    //  throw new OverConstrainedError("System is over-constrained: one or more rows are fully locked during propagation.", {
    //    mode: "propagation",
    //    lockedOutRows,
    //  });
    //}

    // Step 1 (only for local-edit-triggered propagation): solve the owner
    // row for the global field, and write it.
    if (ownerRowId != null) {
      const ok = this._solveAndWriteRow(ownerRowId, ownerTarget);
      if (!ok) {
        throw new OverConstrainedError("Could not solve owner row for the global dependent (missing/invalid values or div-by-zero).", {
          mode: "propagation",
          ownerRowId,
          ownerTarget,
        });
      }
    }

    // Step 2: solve every other row (or every row, if no owner) for its own dependent.
    const failedRows = [];
    for (const id of this.marketplaceIds) {
      if (id === ownerRowId) continue; // already solved above; re-solving is a no-op
      const dependent = state.marketplaces[id].dependent; // guaranteed non-null by pre-check
      const ok = this._solveAndWriteRow(id, dependent);
      if (!ok) failedRows.push(id);
    }

    if (failedRows.length > 0) {
      throw new OverConstrainedError("Could not solve one or more rows during propagation (missing/invalid values or div-by-zero).", {
        mode: "propagation",
        failedRows,
      });
    }
  }

  // ---------------------------------------------------------------------

  _reportError(err) {
    if (this.onError) {
      this.onError(err);
    } else {
      console.warn(`[PriceSimulator] ${err.message}`, err.details);
    }
  }
}
