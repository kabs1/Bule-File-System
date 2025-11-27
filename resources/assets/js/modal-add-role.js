/**
 * Add new role Modal JS
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // add role form validation & submission
    const addRoleForm = document.getElementById('addRoleForm');
    const fv = FormValidation.formValidation(addRoleForm, {
      fields: {
        roleName: {
          validators: {
            notEmpty: {
              message: 'Please enter role name'
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
    }).on('core.form.valid', function () {
      const formData = new FormData(addRoleForm);
      const roleName = formData.get('roleName');
      const permissions = [];
      addRoleForm.querySelectorAll('input[name="permissions[]"]:checked').forEach(function (el) {
        permissions.push(el.value);
      });

      fetch('/app/roles', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ roleName: roleName, permissions: permissions })
      })
        .then(async response => {
          const text = await response.text();
          let json = null;
          try {
            json = text ? JSON.parse(text) : null;
          } catch (e) {}
          if (!response.ok) {
            if (json && json.errors) {
              return json;
            }
            throw new Error(text || 'Request failed with status ' + response.status);
          }
          if (json) {
            return json;
          }
          throw new Error('Unexpected non-JSON response');
        })
        .then(result => {
          if (result.message) {
            alert(result.message);
            const modalEl = document.getElementById('addRoleModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
              const instance = bootstrap.Modal.getOrCreateInstance(modalEl);
              instance.hide();
            }
            document.dispatchEvent(new CustomEvent('roles:reload'));
            addRoleForm.reset();
            const roleInput = document.getElementById('modalRoleName');
            const roleFeedback = document.getElementById('modalRoleNameFeedback');
            if (roleInput) roleInput.classList.remove('is-invalid');
            if (roleFeedback) roleFeedback.textContent = '';
          } else if (result.errors) {
            const roleErr = result.errors.roleName && result.errors.roleName[0];
            const roleInput = document.getElementById('modalRoleName');
            const roleFeedback = document.getElementById('modalRoleNameFeedback');
            if (roleErr && roleInput && roleFeedback) {
              roleInput.classList.add('is-invalid');
              roleFeedback.textContent = roleErr;
            }
            const permErr = result.errors.permissions && result.errors.permissions[0];
            if (permErr) {
              alert(permErr);
            }
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Unable to save role: ' + (error.message || 'Unknown error'));
        });
    });

    // Select All checkbox click
    const selectAll = document.querySelector('#selectAll'),
      checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener('change', t => {
      checkboxList.forEach(e => {
        e.checked = t.target.checked;
      });
    });
  })();
});
