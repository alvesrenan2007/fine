import IMask from 'imask';
import * as currencyUtils from './utils/currency.js';

window.AppUtils = {
    currency: currencyUtils
};

// 1. Core function to apply the mask to a single element
function applyMask(element) {
    if (element.dataset.maskInitialized) return;

    const scale = parseInt(element.dataset.maskScale) || 2;
    const min = parseFloat(element.dataset.maskMin) || 0;
    const max = parseFloat(element.dataset.maskMax) || 1000000000;

    // IMask automatically listens to 'input' events under the hood
    // to format the text in real-time as the user types.
    IMask(element, {
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
                min: min,
                max: max

            }
        }
    });

    element.dataset.maskInitialized = "true";
}

// 2. Automatically find and mask elements already on the page
function initExistingMasks() {
    document.querySelectorAll('[data-mask-type="currency"]').forEach(applyMask);
}

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

// Start everything up safely
document.addEventListener('DOMContentLoaded', () => {
    initExistingMasks();
    observer.observe(document.body, { childList: true, subtree: true });
});
