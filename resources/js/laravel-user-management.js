/**
 * Page User management
 */

'use strict';

// Datatable (js)
document.addEventListener('DOMContentLoaded', function (e) {
  let borderColor, bodyBg, headingColor;

  borderColor = config.colors.borderColor;
  bodyBg = config.colors.bodyBg;
  headingColor = config.colors.headingColor;

  // Variable declaration for table
  const dt_user_table = document.querySelector('.datatables-users'),
    // userView is now dynamically generated
    offCanvasForm = document.getElementById('offcanvasAddUser');

  // Select2 initialization
  var select2 = $('.select2');
  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Users datatable
  if (dt_user_table) {
    const dt_user = new DataTable(dt_user_table, {
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'user-list',
        dataSrc: function (json) {
          // Ensure recordsTotal and recordsFiltered are numeric and not undefined/null
          if (typeof json.recordsTotal !== 'number') {
            json.recordsTotal = 0;
          }
          if (typeof json.recordsFiltered !== 'number') {
            json.recordsFiltered = 0;
          }

          // Fallback for empty data to avoid pagination NaN issue
          json.data = Array.isArray(json.data) ? json.data : [];

          return json.data;
        }
      },
      columns: [
        // columns according to JSON
        { data: 'user_id' },
        { data: 'user_id' },
        { data: 'first_name' },
        { data: 'email' },
        { data: 'email_verified_at' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          // User full name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            const first_name = full.first_name || '';
            const last_name = full.last_name || '';
            const avatar = full.avatar;
            const fullName = `${first_name} ${last_name}`.trim();

            // For Avatar badge
            const states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            // Use user_id to generate a consistent color, preventing it from changing on redraw
            const state = states[full.user_id % states.length];

            // Extract initials from the name, ensuring fullName is not empty
            let initials = '';
            if (fullName) {
              const nameParts = fullName.match(/\b\w/g) || [];
              if (nameParts.length > 0) {
                initials = nameParts.shift() + (nameParts.length > 0 ? nameParts.pop() : '');
              }
            }
            const initialsUpper = initials.toUpperCase();

            // Create avatar badge using template literals
            const userAvatar = avatar ? `<img src="${avatar}" alt="Avatar" class="rounded-circle">` : `<span class="avatar-initial rounded-circle bg-label-${state}">${initialsUpper}</span>`;

            // Create full output for row using template literals
            const rowOutput = `
              <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                  <div class="avatar avatar-sm me-4">
                    ${userAvatar}
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <a href="${baseUrl}app/users/${full.user_id}" class="text-truncate text-heading">
                    <span class="fw-medium">${fullName}</span>
                  </a>
                </div>
              </div>
            `;

            // Return the final output as HTML string
            return rowOutput;
          }
        },
        {
          // User email
          targets: 3,
          render: function (data, type, full, meta) {
            const email = full['email'];

            return '<span class="user-email">' + email + '</span>';
          }
        },
        {
          // email verify
          targets: 4,
          className: 'text-center',
          render: function (data, type, full, meta) {
            const verified = full['email_verified_at'];
            return `${
              verified
                ? '<i class="icon-base bx fs-4 bx-check-shield text-success"></i>'
                : '<i class="icon-base bx fs-4 bx-shield-x text-danger" ></i>'
            }`;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-4">' +
              `<button class="btn btn-sm btn-icon edit-record" data-id="${full['user_id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="icon-base bx bx-edit icon-22px"></i></button>` +
              `<button class="btn btn-sm btn-icon delete-record" data-id="${full['user_id']}"><i class="icon-base bx bx-trash icon-22px"></i></button>` +
              '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-22px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="${baseUrl}app/users/${full['user_id']}" class="dropdown-item">View</a>` + // Dynamically generate view link
              `<a href="javascript:;" class="dropdown-item suspend-record" data-id="${full['user_id']}">Suspend</a>` + // Add suspend action
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'desc']],
      // Refactored export format function to avoid repetition
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle',
          text: '<i class="icon-base bx bx-export me-2 bx-sm"></i>Export',
          buttons: [
            { extend: 'print', text: '<i class="icon-base bx bx-printer me-2" ></i>Print' },
            { extend: 'csv', text: '<i class="icon-base bx bx-file me-2" ></i>Csv' },
            { extend: 'excel', text: '<i class="icon-base bx bxs-file-export me-2"></i>Excel' },
            { extend: 'pdf', text: '<i class="icon-base bxs-file-pdf me-2"></i>Pdf' },
            { extend: 'copy', text: '<i class="icon-base bx bx-copy me-2" ></i>Copy' }
          ].map(btn => {
            btn.title = 'Users';
            btn.className = 'dropdown-item';
            btn.exportOptions = {
              columns: [1, 2, 3, 4], // Column 5 is email verification icon, not useful text
              format: {
                body: function (inner, coldex, rowdex) {
                  if (!inner) return inner;
                  // Use the full name from the data object for the user column
                  if (coldex === 1) { // Corresponds to the 'User' column (index 2 in original `columns` array)
                    const rowData = dt_user.row(rowdex).data();
                    return `${rowData.first_name || ''} ${rowData.last_name || ''}`.trim();
                  }
                  return inner;
                }
              }
            };
            return btn;
          })
        },
        {
          text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New User</span>',
          className: 'add-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
        }
      ],
      layout: {
        topStart: {
          rowClass: 'row m-3 my-0 justify-content-between',
          features: [
            {
              pageLength: {
                menu: [7, 10, 20, 50, 70, 100],
                text: '_MENU_'
              }
            }
          ]
        },
        topEnd: {
          features: [
            'search',
            'buttons'
          ]
        },
        bottomStart: {
          rowClass: 'row mx-3 justify-content-between',
          features: [
            {
              info: {
                text: 'Showing _START_ to _END_ of _TOTAL_ entries'
              }
            }
          ]
        },
        bottomEnd: 'paging'
      },
      displayLength: 7,
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
              return 'Details of ' + data['first_name'] + ' ' + data['last_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            const data = columns
              .map(function (col) {
                // Check if the column title is 'User ID' or 'ID' and use the correct data field
                let displayData = col.data;
                if (col.title === 'User ID' || col.title === 'ID') {
                  displayData = col.data.user_id || col.data.id; // Assuming 'user_id' or 'id' is the correct field
                } else if (col.title === 'First Name') {
                  displayData = col.data.first_name;
                } else if (col.title === 'Email') {
                  displayData = col.data.email;
                } else if (col.title === 'Email Verified At') {
                  displayData = col.data.email_verified_at;
                } else if (col.title === 'Actions') {
                  displayData = ''; // Actions are buttons, not plain text
                }

                return col.title !== '' // Do not show row in modal popup if title is blank (for check box)
                  ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                      <td>${col.title}:</td>
                      <td>${displayData}</td>
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
        // Remove btn-secondary from export buttons
        document.querySelectorAll('.dt-buttons .btn').forEach(btn => {
          btn.classList.remove('btn-secondary');
        });
      }
    });

    // Delete Record
    document.addEventListener('click', function (e) {
      if (e.target.closest('.delete-record')) {
        const deleteBtn = e.target.closest('.delete-record');
        const user_id = deleteBtn.dataset.id;
        const dtrModal = document.querySelector('.dtr-bs-modal.show');

        // hide responsive modal in small screen
        if (dtrModal) {
          const bsModal = bootstrap.Modal.getInstance(dtrModal);
          bsModal.hide();
        }

        // sweetalert for confirmation of delete
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
          },
          buttonsStyling: false
        }).then(function (result) {
          if (result.value) {
            // delete the data
            fetch(`${baseUrl}user-list/${user_id}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
              }
            })
              .then(response => {
                if (response.ok) {
                  dt_user.draw();

                  // success sweetalert
                  Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'The user has been deleted!',
                    customClass: {
                      confirmButton: 'btn btn-success'
                    }
                  });
                } else {
                  throw new Error('Delete failed');
                }
              })
              .catch(error => {
                console.log(error);
              });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'The User is not deleted!',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        });
      }
    });

        // edit record
        document.addEventListener('click', function (e) {
            if (e.target.closest('.edit-record')) {
                const editBtn = e.target.closest('.edit-record');
                const user_id = editBtn.dataset.id;
                const dtrModal = document.querySelector('.dtr-bs-modal.show');

                // hide responsive modal in small screen
                if (dtrModal) {
                    const bsModal = bootstrap.Modal.getInstance(dtrModal);
                    bsModal.hide();
                }

                // changing the title of offcanvas
                document.getElementById('offcanvasAddUserLabel').innerHTML = 'Edit User';

                // get data
                fetch(`${baseUrl}user-list/${user_id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('user_id').value = data.user_id;
                        document.getElementById('add-user-first-name').value = data.first_name;
                        document.getElementById('add-user-last-name').value = data.last_name;
                        document.getElementById('add-user-email').value = data.email;
                        document.getElementById('add-user-contact').value = data.contact;
                        document.getElementById('add-user-username').value = data.username;
                        document.getElementById('add-user-user-type').value = data.user_type;
                        document.getElementById('add-user-role').value = data.role_id;
                        document.getElementById('add-user-status').value = data.status;
                        document.getElementById('add-user-branch').value = data.branch_id;
                        // Handle profile_picture and all_branch_access if needed
                    });
            }
        });

    // changing the title
    const addNewBtn = document.querySelector('.add-new');
    if (addNewBtn) {
      addNewBtn.addEventListener('click', function () {
        document.getElementById('user_id').value = ''; //resetting input field
        document.getElementById('offcanvasAddUserLabel').innerHTML = 'Add User';
      });
    }

  }

  // validating form and updating user's data
  const addNewUserForm = document.getElementById('addNewUserForm');

  // user form validation
  if (addNewUserForm) {
    const fv = FormValidation.formValidation(addNewUserForm, {
      fields: {
        'first_name': {
          validators: {
            notEmpty: {
              message: 'Please enter first name'
            }
          }
        },
        'last_name': {
          validators: {
            notEmpty: {
              message: 'Please enter last name'
            }
          }
        },
        'email': {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        },
        'contact': {
          validators: {
            notEmpty: {
              message: 'Please enter your contact'
            }
          }
        },
        'username': {
          validators: {
            notEmpty: {
              message: 'Please enter username'
            }
          }
        },
        'password': {
          validators: {
            notEmpty: {
              message: 'Please enter password'
            }
          }
        },
        'role_id': {
          validators: {
            notEmpty: {
              message: 'Please select a role'
            }
          }
        },
        'status': {
          validators: {
            notEmpty: {
              message: 'Please select a status'
            }
          }
        },
        'branch_id': {
          validators: {
            notEmpty: {
              message: 'Please select a branch'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            return '.mb-6';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // adding or updating user when form successfully validate
      const formData = new FormData(addNewUserForm);
      const formDataObj = {};

      // Convert FormData to URL-encoded string
      formData.forEach((value, key) => {
        formDataObj[key] = value;
      });

      const url = formDataObj.user_id ? `${baseUrl}user-list/${formDataObj.user_id}` : `${baseUrl}user-list`;
      const method = formDataObj.user_id ? 'PUT' : 'POST';

      fetch(url, {
        method: method,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(formDataObj).toString()
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          // Refresh DataTable
          dt_user && dt_user.draw();

          // Hide offcanvas
          const offcanvasInstance = bootstrap.Offcanvas.getInstance(offCanvasForm);
          offcanvasInstance && offcanvasInstance.hide();

          // sweetalert
          Swal.fire({
            icon: 'success',
            title: `Successfully ${data.message}!`,
            text: `User ${data.message} Successfully.`,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        })
        .catch(err => {
          // Hide offcanvas
          const offcanvasInstance = bootstrap.Offcanvas.getInstance(offCanvasForm);
          offcanvasInstance && offcanvasInstance.hide();

          Swal.fire({
            title: 'Error!',
            text: err.message,
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        });
    });

    // clearing form data when offcanvas hidden
    offCanvasForm.addEventListener('hidden.bs.offcanvas', function () {
      fv.resetForm(true);
    });
  }

  // Phone mask initialization
  const phoneMaskList = document.querySelectorAll('.phone-mask');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      phoneMask.addEventListener('input', event => {
        const cleanValue = event.target.value.replace(/\D/g, '');
        phoneMask.value = formatGeneral(cleanValue, {
          blocks: [3, 3, 4],
          delimiters: [' ', ' ']
        });
      });
      registerCursorTracker({
        input: phoneMask,
        delimiter: ' '
      });
    });
  }
});
