/**
 * LockStateManager
 * Written by Sonet 4.6 Hight via claude.ai web chat
 * ----------------
 * Owns all lock checkboxes. Enforces the invariant:
 *   - At most ONE unlocked field per marketplace row.
 *   - At most ONE unlocked global field (product-cost / tax-fee).
 *
 * Whenever a checkbox change would violate this (e.g. user unlocks a 2nd field
 * in the same row, or unlocks a 2nd global field), the manager "aggressively
 * fixes" it by re-locking the conflicting field(s), keeping a single winner
 * chosen via PRIORITY (winner = whichever of the conflicting unlocked fields
 * is highest priority; on a fresh "user just unlocked X" action, X wins
 * outright since it's the most recent explicit user intent).
 *
 * Exposes a read-only `state` snapshot:
 *   {
 *     globalDependent: 'product-cost' | 'tax-fee' | null,
 *     marketplaces: { [id]: { dependent: <field>|null } }
 *   }
 *
 * PriceSimulator should treat `state` as read-only and never touch checkboxes
 * directly - all lock/unlock mutations go through this class.
 */

const PRIORITY = ["sell-price", "product-cost", "profit-margin", "additional-cost", "marketplace-fee", "tax-fee"];
const GLOBAL_FIELDS = ["product-cost", "tax-fee"];
const ROW_FIELDS = ["sell-price", "additional-cost", "marketplace-fee", "profit-margin"];

export class LockStateManager {
  /**
   * @param {Object} opts
   * @param {Document|HTMLElement} [opts.root=document]
   * @param {string[]} opts.marketplaceIds
   * @param {(state: object) => void} [opts.onChange] called after state is recomputed
   */
  constructor({ root = document, marketplaceIds, onChange = null }) {
    this.root = root;
    this.marketplaceIds = marketplaceIds;
    this.onChange = onChange;

    this.globalLockEls = {
      "product-cost": this.root.querySelector("#product-cost-lock"),
      "tax-fee": this.root.querySelector("#tax-fee-lock"),
    };

    this.rowLockEls = {};
    for (const id of this.marketplaceIds) {
      this.rowLockEls[id] = {};
      for (const field of ROW_FIELDS) {
        this.rowLockEls[id][field] = this.root.querySelector(
          `[data-type="input-lock"][data-target-type="${field}"][data-target-id="${id}"]`
        );
      }
    }

    this.state = { globalDependent: null, marketplaces: {} };

    this._bindEvents();
    this._recompute(/* justChanged */ null);
  }

  // ---------------------------------------------------------------------

  _bindEvents() {
    for (const field of GLOBAL_FIELDS) {
      const el = this.globalLockEls[field];
      if (!el) continue;
      el.addEventListener("change", () => this._recompute({ scope: "global", field }));
    }

    for (const id of this.marketplaceIds) {
      for (const field of ROW_FIELDS) {
        const el = this.rowLockEls[id][field];
        if (!el) continue;
        el.addEventListener("change", () => this._recompute({ scope: "row", id, field }));
      }
    }
  }

  /** True = locked (checked). */
  _isChecked(el) {
    return !!el?.checked;
  }

  _setChecked(el, value) {
    if (el) el.checked = value;
  }

  // ---------------------------------------------------------------------

  /**
   * Recomputes the whole state from scratch by reading every checkbox,
   * resolving conflicts (more than one unlocked in a scope), and writing
   * the corrected checked-state back to the DOM where needed.
   *
   * @param {{scope: 'global'|'row', field: string, id?: string}|null} justChanged
   *   Info about which checkbox the user just toggled, used as a tie-breaker:
   *   if the just-changed checkbox was just UNLOCKED and that creates a
   *   conflict, it wins over the others (most recent explicit intent).
   */
  _recompute(justChanged) {
    // --- Global scope ---
    const unlockedGlobals = GLOBAL_FIELDS.filter((f) => !this._isChecked(this.globalLockEls[f]));
    let globalDependent = null;

    if (unlockedGlobals.length === 1) {
      globalDependent = unlockedGlobals[0];
    } else if (unlockedGlobals.length > 1) {
      // Conflict: pick a winner.
      const justChangedField =
        justChanged?.scope === "global" && !this._isChecked(this.globalLockEls[justChanged.field])
          ? justChanged.field
          : null;
      globalDependent = justChangedField ?? PRIORITY.find((f) => unlockedGlobals.includes(f));
      // Re-lock everyone else in this scope.
      for (const f of unlockedGlobals) {
        if (f !== globalDependent) this._setChecked(this.globalLockEls[f], true);
      }
    }
    // unlockedGlobals.length === 0 -> globalDependent stays null, nothing to fix.

    // --- Per-row scope ---
    const marketplaces = {};
    for (const id of this.marketplaceIds) {
      const unlockedInRow = ROW_FIELDS.filter((f) => !this._isChecked(this.rowLockEls[id][f]));
      let dependent = null;

      if (unlockedInRow.length === 1) {
        dependent = unlockedInRow[0];
      } else if (unlockedInRow.length > 1) {
        const justChangedField =
          justChanged?.scope === "row" && justChanged.id === id && !this._isChecked(this.rowLockEls[id][justChanged.field])
            ? justChanged.field
            : null;
        dependent = justChangedField ?? PRIORITY.find((f) => unlockedInRow.includes(f));
        for (const f of unlockedInRow) {
          if (f !== dependent) this._setChecked(this.rowLockEls[id][f], true);
        }
      }
      // unlockedInRow.length === 0 -> dependent stays null (row fully locked).

      marketplaces[id] = { dependent };
    }

    this.state = { globalDependent, marketplaces };
    if (this.onChange) this.onChange(this.state);
  }

  // ---------------------------------------------------------------------
  // Public helpers for PriceSimulator to request a lock-state change
  // programmatically (e.g. after solving, if you want to move the
  // dependent - NOT required by current spec, but exposed for completeness).
  // ---------------------------------------------------------------------

  /** Returns a deep-enough read-only snapshot of current state. */
  getState() {
    return {
      globalDependent: this.state.globalDependent,
      marketplaces: { ...Object.fromEntries(Object.entries(this.state.marketplaces).map(([k, v]) => [k, { ...v }])) },
    };
  }
}
