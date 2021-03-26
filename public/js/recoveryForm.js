'use strict';

const form = document.getElementsByTagName('form')[0];
const newPasswordInput = mdc.textField.MDCTextField.attachTo(document.getElementById('new-password'));
const reNewPasswordInput = mdc.textField.MDCTextField.attachTo(document.getElementById('re-new-password'));
const progressBar = mdc.linearProgress.MDCLinearProgress.attachTo(document.getElementById('progress-bar'));
const submitButton = mdc.ripple.MDCRipple.attachTo(document.getElementById('submit-button'));

function validationNewPassword() {
    const password = newPasswordInput.value;
    let errorText = 'Votre nouveau mot de passe doit contenir au moins ';
    if ((/.{12,}/).test(password) === false) {
        errorText += '12 caractères avec ';
    } else {
        errorText += '<span class="success strong">12 caractères avec </span>';
    }
    if ((/[A-Z]{1,}/).test(password) === false) {
        errorText += '1 majuscule, ';
    } else {
        errorText += '<span class="success strong">1 majuscule, </span>';
    }
    if ((/[a-z]{1,}/).test(password) === false) {
        errorText += '1 minuscule, ';
    } else {
        errorText += '<span class="success strong">1 minuscule, </span>';
    }
    if ((/[0-9]{1,}/).test(password) === false) {
        errorText += '1 chiffre ';
    } else {
        errorText += '<span class="success strong">1 chiffre </span>';
    }
    if ((/[^a-zA-Z0-9 ]{1,}/).test(password) === false) {
        errorText += 'et 1 caractère spécial';
    } else {
        errorText += '<span class="success strong">et 1 caractère spécial</span>';
    }
    newPasswordInput.helperText_.root.innerHTML = errorText;
}

if (newPasswordInput) {
    newPasswordInput.input_.addEventListener('keyup', () => {
        validationNewPassword();
        reNewPasswordInput.pattern = '^' + newPasswordInput.value + '$';
    });
    newPasswordInput.trailingIcon_.root.addEventListener('click', () => {
        const iconText = newPasswordInput.trailingIcon_.root.textContent;
        if (iconText === 'visibility') {
            newPasswordInput.input_.type = 'text';
            newPasswordInput.trailingIcon_.root.textContent = 'visibility_off';
        }
        if (iconText === 'visibility_off') {
            newPasswordInput.input_.type = 'password';
            newPasswordInput.trailingIcon_.root.textContent = 'visibility';
        }
    });
}

if (reNewPasswordInput) {
    reNewPasswordInput.trailingIcon_.root.addEventListener('click', () => {
        const iconText = reNewPasswordInput.trailingIcon_.root.textContent;
        if (iconText === 'visibility') {
            reNewPasswordInput.input_.type = 'text';
            reNewPasswordInput.trailingIcon_.root.textContent = 'visibility_off';
        }
        if (iconText === 'visibility_off') {
            reNewPasswordInput.input_.type = 'password';
            reNewPasswordInput.trailingIcon_.root.textContent = 'visibility';
        }
    });
}

if (submitButton) {
    submitButton.root.addEventListener('click', () => {
        let error = false;
        if (reNewPasswordInput.valid === false) {
            reNewPasswordInput.focus();
            error = true
        }
        validationNewPassword();
        if (newPasswordInput.valid === false) {
            newPasswordInput.valid = false;
            newPasswordInput.focus();
            error = true
        }
        if (error === true) {
            return false
        }
        progressBar.className = progressBar.foundation.open();
        form.submit();
        return true;
    });
}