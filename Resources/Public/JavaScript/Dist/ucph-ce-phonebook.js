/**
 * Handle KU phonebook events
 */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const input = document.getElementById('kuPhonebook');
    const reset = document.getElementById('reset');
    const results = document.getElementById('ucph-ce-phonebook-results');

    reset.addEventListener('click', () => {
        results.textContent = '';
        input.value = '';
        input.focus();
    });

});