/**
 * App user list
 */

'use strict';

// Datatable (js)
document.addEventListener('DOMContentLoaded', function (e) {
  const dtRoleTable = document.querySelector('.datatables-roles');
  let dt_Role;

  // Roles List datatable
  if (dtRoleTable) {
    dt_Role = new DataTable(dtRoleTable, {
      ajax: '/app/roles/list', // AJAX route to fetch role data
      columns: [
        // columns according to JSON
        { data: '' }, // For responsive control
        { data: 'id', orderable: false, render: DataTable.render.select() }, // For checkboxes
        { data: 'name' },
        { data: 'guard_name' },
        { data: 'users_count' },
        { data: 'actions' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          searchable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          searchable: false,
          responsivePriority: 4,
          checkboxes: true,
          render: function () {
            return '<input type="checkbox" class="dt-checkboxes form-check-input">';
          },
          checkboxes: {
            selectAllRender: '<input type="checkbox" class="form-check-input">'
          }
        },
        {
          targets: 2,
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['name']}</span>`;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['guard_name']}</span>`;
          }
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['users_count']}</span>`;
          }
        },
        {
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return `
              <div class="d-flex align-items-center">
                <a href="javascript:;" class="btn btn-icon delete-record"><i class="icon-base bx bx-trash icon-md"></i></a>
                <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md"></i></a>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  <a href="javascript:;" class="dropdown-item">Edit</a>
                  <a href="javascript:;" class="dropdown-item">Suspend</a>
                </div>
              </div>
            `;
          }
        }
      ],
      select: {
        style: 'multi',
        selector: 'td:nth-child(2)'
      },
      order: [[2, 'desc']],
      layout: {
        topStart: {
          rowClass: 'row me-3 ms-2 justify-content-between',
          features: [
            {
              pageLength: {
                menu: [10, 25, 50, 100],
                text: '_MENU_'
              }
            }
          ]
        },
        topEnd: {
          features: [
            {
              search: {
                placeholder: 'Search Role',
                text: '_INPUT_'
              }
            },
            {
              buttons: [
                {
                  text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Role</span>',
                  className: 'add-new btn btn-primary',
                  attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#offcanvasAddRole'
                  }
                }
              ]
            }
          ]
        },
        bottomStart: {
          rowClass: 'row mx-3 justify-content-between',
          features: ['info']
        },
        bottomEnd: 'paging'
      },
      language: {
        paginate: {
          next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>',
          previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>',
          first: '<i class="icon-base bx bx-chevrons-left scaleX-n1-rtl icon-18px"></i>',
          last: '<i class="icon-base bx bx-chevrons-right scaleX-n1-rtl icon-18px"></i>'
        }
      },
      // For responsive popup
      responsive: {
        details: {
          display: DataTable.Responsive.display.modal({
            header: function (row) {
              const data = row.data();
              return 'Details of ' + data['name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            const data = columns
              .map(function (col) {
                return col.title !== '' // Do not show row in modal popup if title is blank (for check box)
                  ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                      <td>${col.title}:</td>
                      <td>${col.data}</td>
                    </tr>`
                  : '';
              })
              .join('');

            if (data) {
              const div = document.createElement('div');
              div.classList.add('table-responsive');
              const table = document.createElement('table');
              div.appendChild(table);
              table.classList.add('table');
              const tbody = document.createElement('tbody');
              tbody.innerHTML = data;
              table.appendChild(tbody);
              return div;
            }
            return false;
          }
        }
      },
      initComplete: function () {
        // Add any custom filters here if needed
      }
    });

    //? The 'delete-record' class is necessary for the functionality of the following code.
    function deleteRecord(event) {
      let row = document.querySelector('.dtr-expanded');
      if (event) {
        row = event.target.parentElement.closest('tr');
      }
      if (row) {
        dt_Role.row(row).remove().draw();
      }
    }

    function bindDeleteEvent() {
      const roleTable = document.querySelector('.datatables-roles');
      const modal = document.querySelector('.dtr-bs-modal');

      if (roleTable && roleTable.classList.contains('collapsed')) {
        if (modal) {
          modal.addEventListener('click', function (event) {
            if (event.target.parentElement.classList.contains('delete-record')) {
              deleteRecord();
              const closeButton = modal.querySelector('.btn-close');
              if (closeButton) closeButton.click(); // Simulates a click on the close button
            }
          });
        }
      } else {
        const tableBody = roleTable?.querySelector('tbody');
        if (tableBody) {
          tableBody.addEventListener('click', function (event) {
            if (event.target.parentElement.classList.contains('delete-record')) {
              deleteRecord(event);
            }
          });
        }
      }
    }

    // Initial event binding
    bindDeleteEvent();

    // Re-bind events when modal is shown or hidden
    document.addEventListener('show.bs.modal', function (event) {
      if (event.target.classList.contains('dtr-bs-modal')) {
        bindDeleteEvent();
      }
    });

    document.addEventListener('hide.bs.modal', function (event) {
      if (event.target.classList.contains('dtr-bs-modal')) {
        bindDeleteEvent();
      }
    });
  }

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    const elementsToModify = [
      { selector: '.dt-search .form-control', classToRemove: 'form-control-sm' },
      { selector: '.dt-search', classToAdd: 'mb-md-6 mb-2' },
      { selector: '.dt-length .form-select', classToRemove: 'form-select-sm' },
      { selector: '.dt-length', classToAdd: 'mb-md-6 mb-0' },
      { selector: '.dt-layout-start', classToAdd: 'ps-2 mt-0' },
      {
        selector: '.dt-layout-end',
        classToRemove: 'justify-content-between',
        classToAdd: 'justify-content-md-between justify-content-center d-flex flex-wrap gap-4 mb-sm-0 mb-4 mt-0'
      },
      { selector: '.dt-layout-table', classToRemove: 'row mt-2' },
      { selector: '.user_role', classToAdd: 'w-px-200 my-md-0 mt-6 mb-2' },
      { selector: '.user_plan', classToAdd: 'w-px-200 mb-6 mb-md-0' }
    ];

    // Delete record
    elementsToModify.forEach(({ selector, classToRemove, classToAdd }) => {
      document.querySelectorAll(selector).forEach(element => {
        if (classToRemove) {
          classToRemove.split(' ').forEach(className => element.classList.remove(className));
        }
        if (classToAdd) {
          classToAdd.split(' ').forEach(className => element.classList.add(className));
        }
      });
    });
  }, 100);

  // On edit role click, update text
  var roleEditList = document.querySelectorAll('.role-edit-modal'),
    roleAdd = document.querySelector('.add-new-role'),
    roleTitle = document.querySelector('.role-title'),
    addRoleForm = document.getElementById('addRoleForm');

  if (roleAdd) {
    roleAdd.onclick = function () {
      roleTitle.innerHTML = 'Add New Role'; // reset text
      addRoleForm.reset(); // Clear form fields
      addRoleForm.removeAttribute('data-role-id'); // Remove role ID for add operation
      // Uncheck all permission checkboxes
      addRoleForm.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
        checkbox.checked = false;
      });
      document.getElementById('selectAll').checked = false; // Uncheck select all
    };
  }

  if (roleEditList) {
    roleEditList.forEach(function (roleEditEl) {
      roleEditEl.onclick = function () {
        roleTitle.innerHTML = 'Edit Role'; // set text to Edit Role
        const roleId = this.closest('.card').dataset.roleId; // Assuming role ID is stored in data-role-id of the card
        addRoleForm.setAttribute('data-role-id', roleId);

        // Fetch role data for editing
        fetch(`/app/roles/${roleId}`)
          .then(response => response.json())
          .then(role => {
            document.getElementById('modalRoleName').value = role.name;
            // Uncheck all permission checkboxes first
            addRoleForm.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
              checkbox.checked = false;
            });
            // Check permissions associated with the role
            role.permissions.forEach(permission => {
              const checkbox = document.querySelector(`input[name="permissions[]"][value="${permission.name}"]`);
              if (checkbox) {
                checkbox.checked = true;
              }
            });
            // Update select all checkbox based on current selections
            updateSelectAllCheckbox();
          })
          .catch(error => console.error('Error fetching role for edit:', error));
      };
    });
  }

  // Select All checkbox functionality
  const selectAllCheckbox = document.getElementById('selectAll');
  const permissionCheckboxes = addRoleForm.querySelectorAll('input[name="permissions[]"]');

  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function () {
      permissionCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
      });
    });
  }

  if (permissionCheckboxes) {
    permissionCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateSelectAllCheckbox);
    });
  }

  function updateSelectAllCheckbox() {
    if (selectAllCheckbox) {
      const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
      selectAllCheckbox.checked = allChecked;
    }
  }

  // Add/Edit Role Form Validation and Submission
  const fvRole = FormValidation.formValidation(addRoleForm, {
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
    const form = addRoleForm;
    const formData = new FormData(form);
    const data = {
      roleName: formData.get('roleName'),
      permissions: []
    };

    form.querySelectorAll('input[name="permissions[]"]:checked').forEach(checkbox => {
      data.permissions.push(checkbox.value);
    });

    const roleId = form.dataset.roleId;
    const method = roleId ? 'PUT' : 'POST';
    const url = roleId ? `/app/roles/${roleId}` : '/app/roles';

    fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(data)
    })
      .then(response => response.json())
      .then(result => {
        if (result.message) {
          alert(result.message);
          dt_Role.ajax.reload(); // Reload the datatable
          $('#addRoleModal').modal('hide'); // Hide the modal
        } else if (result.errors) {
          for (const field in result.errors) {
            if (result.errors.hasOwnProperty(field)) {
              alert(result.errors[field][0]);
            }
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the role.');
      });
  });

  // Delete role functionality
  $(document).on('click', '.delete-record', function () {
    const roleId = $(this).data('id'); // Assuming role ID is passed via data-id attribute
    if (confirm('Are you sure you want to delete this role?')) {
      fetch(`/app/roles/${roleId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
        .then(response => response.json())
        .then(result => {
          if (result.message) {
            alert(result.message);
            dt_Role.ajax.reload();
          }
        })
        .catch(error => console.error('Error deleting role:', error));
    }
  });
});
