'use strict';

const form = document.getElementsByTagName('form')[0];
const emailInput = mdc.textField.MDCTextField.attachTo(document.getElementById('email'));
const progressBar = mdc.linearProgress.MDCLinearProgress.attachTo(document.getElementById('progress-bar'));
const submitButton = mdc.ripple.MDCRipple.attachTo(document.getElementById('submit-button'));

if (submitButton) {
    submitButton.root.addEventListener('click', () => {
        if (emailInput.valid === false) {
            emailInput.valid = false;
            emailInput.focus();
            return false
        }
        progressBar.className = progressBar.foundation.open();
        form.submit();
        return true;
    });
}