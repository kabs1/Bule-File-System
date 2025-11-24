/**
 * Add Branch Modal JS
 */

'use strict';

// Add branch form validation
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    FormValidation.formValidation(document.getElementById('addBranchForm'), {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter branch name'
            }
          }
        },
        location: {
          validators: {
            notEmpty: {
              message: 'Please enter branch location'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.form-control-validation'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    });
  })();
});
