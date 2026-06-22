import IMask from 'imask';
import * as currencyUtils from './utils/currency.js';
import { PriceSimulator } from './utils/PriceSimulator.js';
import { LockStateManager } from './utils/LockStateManager.js';
import { MaskInitializer } from './utils/MaskInitializer.js';

window.AppUtils = {
    currency: currencyUtils
};

window.PriceSimulator = PriceSimulator;
window.LockStateManager = LockStateManager;
window.MaskInitializer = MaskInitializer;

// 1. Core functions to apply the mask to a single element
/*
function applyMask(element) {
    if (element.dataset.maskInitialized) return;

    const scale = parseInt(element.dataset.maskScale) || 2;
    const min = parseFloat(element.dataset.maskMin) || 0;
    const max = parseFloat(element.dataset.maskMax) || 1000000000;

    console.log("IMask received ", element.value);
    // IMask automatically listens to 'input' events under the hood
    // to format the text in real-time as the user types.
    const mask = IMask(element, {
        mask: 'R$ num',
        blocks:{
            num: {
                mask: Number,
                scale: scale,
                signed: false,
                thousandsSeparator: '',
                padFractionalZeros: true,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: min,
                max: max

            }
        }
    });
    mask.unmaskedValue = element.value;
    console.log("IMask outputed ", mask);

    element.dataset.maskInitialized = "true";
}

function applyPercentageMask(element){
    if (element.dataset.maskInitialized) return;

    // 1. Capture the raw value BEFORE IMask touches it
    let rawValue = element.value.trim();

    const mask = IMask(element, {
        mask: '{num} %',
        lazy: false,           // recommended for better UX
        blocks: {
            num: {
                mask: Number,
                min: 0,
                max: 50,
                scale: 2,
                signed: false,
                thousandsSeparator: '',
                radix: ',',
                mapToRadix: ['.'],
                padFractionalZeros: true,
                normalizeZeros: true,
            }
        }
    });

    // 2. Now safely set the correct value
    if (rawValue) {
        // Convert dot to number safely
        const num = parseFloat(rawValue.replace(',', '.')) * 100;
        if (!isNaN(num)) {
            mask.typedValue = num;        // Best option for Number mask
            // OR: mask.unmaskedValue = String(num);
        }
    }

    element.dataset.maskInitialized = 'true';
}
*/
// 2. Automatically find and mask elements already on the page
function initExistingMasks() {
    window.MaskInitializer.formatInputsOnLoad();
//    document.querySelectorAll('[data-mask-type="currency"]').forEach(applyMask);
//    document.querySelectorAll('[data-mask-type="percentage"]').forEach(applyPercentageMask);
}
/*
// 3. Watch the DOM for ANY new elements added in real-time
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            // Ensure it's an HTML element
            if (node.nodeType === Node.ELEMENT_NODE) {
                // If the node itself is a masked input
                if (node.matches && node.matches('[data-mask-type="number"]')) {
                    applyMask(node);
                }
                // If the node contains masked inputs inside it
                const nested = node.querySelectorAll?.('[data-mask-type="number"]');
                if (nested) nested.forEach(applyMask);
            }
        });
    });
});
*/
// Start everything up safely
document.addEventListener('DOMContentLoaded', () => {
    initExistingMasks();
    //observer.observe(document.body, { childList: true, subtree: true });
});
window.dispatchEvent(new Event('app:ready'));
