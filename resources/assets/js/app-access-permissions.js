/**
 * App Permissions List
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const dtPermissionTable = document.querySelector('.datatables-permissions');
  let dt_Permission;

  // Permissions List datatable
  if (dtPermissionTable) {
    dt_Permission = new DataTable(dtPermissionTable, {
      ajax: '/app/permissions/list', // AJAX route to fetch permission data
      columns: [
        // columns according to JSON
        { data: '' }, // For responsive control
        { data: 'id', orderable: false, render: DataTable.render.select() }, // For checkboxes
        { data: 'name' },
        { data: 'guard_name' },
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
                placeholder: 'Search Permission',
                text: '_INPUT_'
              }
            },
            {
              buttons: [
                {
                  text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Permission</span>',
                  className: 'add-new btn btn-primary',
                  attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#addPermissionModal'
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
                return col.title !== ''
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

    function deleteRecord(event) {
      let row = document.querySelector('.dtr-expanded');
      if (event) {
        row = event.target.parentElement.closest('tr');
      }
      if (row) {
        dt_Permission.row(row).remove().draw();
      }
    }

    function bindDeleteEvent() {
      const permissionTable = document.querySelector('.datatables-permissions');
      const modal = document.querySelector('.dtr-bs-modal');

      if (permissionTable && permissionTable.classList.contains('collapsed')) {
        if (modal) {
          modal.addEventListener('click', function (event) {
            if (event.target.parentElement.classList.contains('delete-record')) {
              deleteRecord();
              const closeButton = modal.querySelector('.btn-close');
              if (closeButton) closeButton.click();
            }
          });
        }
      } else {
        const tableBody = permissionTable?.querySelector('tbody');
        if (tableBody) {
          tableBody.addEventListener('click', function (event) {
            if (event.target.parentElement.classList.contains('delete-record')) {
              deleteRecord(event);
            }
          });
        }
      }
    }

    bindDeleteEvent();

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
      { selector: '.dt-layout-table', classToRemove: 'row mt-2' }
    ];

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

  var permissionEditList = document.querySelectorAll('.permission-edit-modal'),
    permissionAdd = document.querySelector('.add-new-permission'),
    permissionTitle = document.querySelector('.permission-title'),
    addPermissionForm = document.getElementById('addPermissionForm');

  if (permissionAdd) {
    permissionAdd.onclick = function () {
      permissionTitle.innerHTML = 'Add New Permission';
      addPermissionForm.reset();
      addPermissionForm.removeAttribute('data-permission-id');
    };
  }
  if (permissionEditList) {
    permissionEditList.forEach(function (permissionEditEl) {
      permissionEditEl.onclick = function () {
        permissionTitle.innerHTML = 'Edit Permission';
        const permissionId = this.closest('tr').dataset.id; // Assuming permission ID is stored in data-id of the row
        addPermissionForm.setAttribute('data-permission-id', permissionId);

        fetch(`/app/permissions/${permissionId}`)
          .then(response => response.json())
          .then(permission => {
            document.getElementById('modalPermissionName').value = permission.name;
            // Handle corePermission checkbox if applicable
            // document.getElementById('corePermission').checked = permission.is_core;
          })
          .catch(error => console.error('Error fetching permission for edit:', error));
      };
    });
  }

  // Add/Edit Permission Form Validation and Submission
  const fvPermission = FormValidation.formValidation(addPermissionForm, {
    fields: {
      permissionName: {
        validators: {
          notEmpty: {
            message: 'Please enter permission name'
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
    const form = addPermissionForm;
    const formData = new FormData(form);
    const data = {
      permissionName: formData.get('permissionName'),
      // corePermission: formData.get('corePermission') ? true : false,
    };

    const permissionId = form.dataset.permissionId;
    const method = permissionId ? 'PUT' : 'POST';
    const url = permissionId ? `/app/permissions/${permissionId}` : '/app/permissions';

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
          dt_Permission.ajax.reload();
          $('#addPermissionModal').modal('hide');
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
        alert('An error occurred while saving the permission.');
      });
  });

  // Delete permission functionality
  $(document).on('click', '.delete-record', function () {
    const permissionId = $(this).data('id');
    if (confirm('Are you sure you want to delete this permission?')) {
      fetch(`/app/permissions/${permissionId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
        .then(response => response.json())
        .then(result => {
          if (result.message) {
            alert(result.message);
            dt_Permission.ajax.reload();
          }
        })
        .catch(error => console.error('Error deleting permission:', error));
    }
  });
});
