export class MaskInitializer {
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
      str = str.replace(/\./g, "");   // remove all dots
      str = str.replace(",", ".");    // comma becomes decimal point
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
  }

  /**
   * Masks a number according to the specified type
   * @param {number|null} numValue - The numeric value
   * @param {string} maskType - "currency" or "percentage"
   */
  mask(numValue, maskType = null) {
    if (numValue == null || Number.isNaN(numValue)) return "";

    if (maskType === "percentage") {
      const percent = numValue * 100;
      return (
        percent.toLocaleString("pt-BR", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2,
        }) + "%"
      );
    }

    if (maskType === "currency") {
      return numValue.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      });
    }

    // Default: just format as Brazilian number
    return numValue.toLocaleString("pt-BR", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  }

  /**
   * Applies mask on inputs after page load and attaches real-time listeners.
   */
    formatInputsOnLoad() {
    document
        .querySelectorAll(
        '[data-mask-type="currency"], [data-mask-type="percentage"]'
        )
        .forEach((element) => {
        // Prevent double-binding if formatInputsOnLoad() is called more than once
        if (element.dataset.maskInitialized) return;
        element.dataset.maskInitialized = "true";

        const maskType = element.dataset.maskType;

        // Format any pre-filled value on load
        if (element.value) {
            const raw = parseFloat(element.value);
            if (!isNaN(raw)) {
            element.value = this.mask(raw, maskType);
            }
        }

        element.addEventListener("input", (e) => {
            this._handleInput(e.target, maskType);
        });

        element.addEventListener("blur", (e) => {
            this._handleBlur(e.target, maskType);
        });
        });
    }

    /**
    * Handles live formatting while the user types.
    * @param {HTMLInputElement} input
    * @param {string} maskType
    */
    _handleInput(input, maskType) {
        if(maskType == "currency"){
            // Strip everything except digits from the current visible value
            const raw = input.value.replace(/[^\d]/g, "");

            if (!raw) {
                input.value = "";
                input.dataset.rawDigits = "";
                return;
            }

            // Treat the raw digits as cents (last two digits = decimals)
            const numericValue = parseInt(raw, 10) / 100;

            input.value = this.mask(numericValue, maskType);
            input.dataset.rawDigits = raw;

            // Place caret at the end
            const len = input.value.length;
            input.setSelectionRange(len, len);
        }
    }

  /**
   * Handles cleanup when the field loses focus.
   * If the value is already a valid masked string, re-masks it cleanly.
   * @param {HTMLInputElement} input
   * @param {string} maskType
   */
  _handleBlur(input, maskType) {
    const numericValue = this.unmask(input.value, maskType);

    if (numericValue == null) {
      input.value = "";
      return;
    }

    input.value = this.mask(numericValue, maskType);
  }
} // end of class
