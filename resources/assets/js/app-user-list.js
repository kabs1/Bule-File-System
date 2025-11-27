/**
 * Page User List
 */

'use strict';

// Datatable (js)
document.addEventListener('DOMContentLoaded', function (e) {
  let borderColor, bodyBg, headingColor;

  borderColor = config.colors.borderColor;
  bodyBg = config.colors.bodyBg;
  headingColor = config.colors.headingColor;

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Variable declaration for table
  const dt_user_table = document.querySelector('.datatables-users'),
    userView = baseUrl + 'app/user/view/account',
    statusObj = {
      1: { title: 'Pending', class: 'bg-label-warning' },
      2: { title: 'Active', class: 'bg-label-success' },
      3: { title: 'Inactive', class: 'bg-label-secondary' }
    };
  var select2 = $('.select2');
  let offcanvasAddUser = null; // Declare offcanvasAddUser in a broader scope
  let dt_user = null; // Declare dt_user in a broader scope

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  // Users datatable
  if (dt_user_table) {
    const offcanvasAddUserEl = document.getElementById('offcanvasAddUser');
    offcanvasAddUser = offcanvasAddUserEl ? new window.bootstrap.Offcanvas(offcanvasAddUserEl) : null; // Initialize here

    dt_user = new DataTable(dt_user_table, {
      ajax: '/app/users/list',
      columns: [
        // columns according to JSON
        { data: 'id' },
        { data: 'id', orderable: false, render: DataTable.render.select() },
        { data: 'full_name' },
        { data: 'role' },
        { data: 'status' },
        { data: 'created_by' },
        { data: 'branch' },
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
          responsivePriority: 3,
          render: function (data, type, full, meta) {
            var name = full['full_name'] || '';
            var email = full['email'] || '';
            var image = full['avatar'];
            var output;

            if (image) {
              // For Avatar image
              output = '<img src="' + assetsPath + 'img/avatars/' + image + '" alt="Avatar" class="rounded-circle">';
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var state = states[stateNum];
              var source = name || email || 'U';
              var letters = (source.match(/\b\w/g) || []).map(function (c) {
                return c.toUpperCase();
              });
              var initials = ((letters.shift() || '') + (letters.pop() || '')).toUpperCase();
              output = '<span class="avatar-initial rounded-circle bg-label-' + state + '">' + initials + '</span>';
            }

            // Creates full output for row
            var row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-4">' +
              output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<a href="' +
              userView +
              '" class="text-heading text-truncate"><span class="fw-medium">' +
              name +
              '</span></a>' +
              '<small>' +
              email +
              '</small>' +
              '</div>' +
              '</div>';
            return row_output;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            var role = full['role'];
            var roleBadgeObj = {
              Subscriber: '<i class="icon-base bx bx-crown text-primary me-2"></i>',
              Author: '<i class="icon-base bx bx-edit text-warning me-2"></i>',
              Maintainer: '<i class="icon-base bx bx-user text-success me-2"></i>',
              Editor: '<i class="icon-base bx bx-pie-chart-alt text-info me-2"></i>',
              Admin: '<i class="icon-base bx bx-desktop text-danger me-2"></i>'
            };
            return (
              "<span class='text-truncate d-flex align-items-center text-heading'>" +
              (roleBadgeObj[role] || '') + // Ensures badge exists for the role
              role +
              '</span>'
            );
          }
        },
        {
          // User Status
          targets: 4,
          render: function (data, type, full, meta) {
            const status = full['status'];

            return (
              '<span class="badge ' +
              statusObj[status].class +
              '" text-capitalized>' +
              statusObj[status].title +
              '</span>'
            );
          }
        },
        {
          targets: 5, // New column for 'Created By'
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['created_by']}</span>`;
          }
        },
        {
          targets: 6, // New column for 'Branch'
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['branch']}</span>`;
          }
        },
        {
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: (data, type, full, meta) => {
            return `
              <div class="d-flex align-items-center">
                <a href="javascript:;" class="btn btn-icon delete-record" data-id="${full.id}">
                  <i class="icon-base bx bx-trash icon-md"></i>
                </a>
                <a href="${userView}" class="btn btn-icon">
                  <i class="icon-base bx bx-show icon-md"></i>
                </a>
                <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="icon-base bx bx-dots-vertical-rounded icon-md"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  <a href="javascript:;" class="dropdown-item edit-record" data-id="${full.id}">Edit</a>
                  ${
                    full.status === 2
                      ? '<a href="javascript:;" class="dropdown-item suspend-record" data-id="' +
                        full.id +
                        '">Suspend</a>'
                      : '<a href="javascript:;" class="dropdown-item activate-record" data-id="' +
                        full.id +
                        '">Activate</a>'
                  }
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
          rowClass: 'row mx-3 my-0 justify-content-between',
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
                placeholder: 'Search User',
                text: '_INPUT_'
              }
            },
            {
              buttons: [
                {
                  extend: 'collection',
                  className: 'btn btn-label-secondary dropdown-toggle',
                  text: '<span class="d-flex align-items-center gap-2"><i class="icon-base bx bx-export icon-sm"></i> <span class="d-none d-sm-inline-block">Export</span></span>',
                  buttons: [
                    {
                      extend: 'print',
                      text: `<span class="d-flex align-items-center"><i class="icon-base bx bx-printer me-2"></i>Print</span>`,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [3, 4, 5, 6],
                        format: {
                          body: function (inner, coldex, rowdex) {
                            if (inner.length <= 0) return inner;
                            const el = new DOMParser().parseFromString(inner, 'text/html').body.childNodes;
                            let result = '';
                            el.forEach(item => {
                              if (item.classList && item.classList.contains('user-name')) {
                                result += item.lastChild.firstChild.textContent;
                              } else {
                                result += item.textContent || item.innerText || '';
                              }
                            });
                            return result;
                          }
                        }
                      },
                      customize: function (win) {
                        win.document.body.style.color = config.colors.headingColor;
                        win.document.body.style.borderColor = config.colors.borderColor;
                        win.document.body.style.backgroundColor = config.colors.bodyBg;
                        const table = win.document.body.querySelector('table');
                        table.classList.add('compact');
                        table.style.color = 'inherit';
                        table.style.borderColor = 'inherit';
                        table.style.backgroundColor = 'inherit';
                      }
                    },
                    {
                      extend: 'csv',
                      text: `<span class="d-flex align-items-center"><i class="icon-base bx bx-file me-2"></i>Csv</span>`,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [3, 4, 5, 6],
                        format: {
                          body: function (inner, coldex, rowdex) {
                            if (inner.length <= 0) return inner;
                            const el = new DOMParser().parseFromString(inner, 'text/html').body.childNodes;
                            let result = '';
                            el.forEach(item => {
                              if (item.classList && item.classList.contains('user-name')) {
                                result += item.lastChild.firstChild.textContent;
                              } else {
                                result += item.textContent || item.innerText || '';
                              }
                            });
                            return result;
                          }
                        }
                      }
                    },
                    {
                      extend: 'excel',
                      text: `<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-export me-2"></i>Excel</span>`,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [3, 4, 5, 6],
                        format: {
                          body: function (inner, coldex, rowdex) {
                            if (inner.length <= 0) return inner;
                            const el = new DOMParser().parseFromString(inner, 'text/html').body.childNodes;
                            let result = '';
                            el.forEach(item => {
                              if (item.classList && item.classList.contains('user-name')) {
                                result += item.lastChild.firstChild.textContent;
                              } else {
                                result += item.textContent || item.innerText || '';
                              }
                            });
                            return result;
                          }
                        }
                      }
                    },
                    {
                      extend: 'pdf',
                      text: `<span class="d-flex align-items-center"><i class="icon-base bx bxs-file-pdf me-2"></i>Pdf</span>`,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [3, 4, 5, 6],
                        format: {
                          body: function (inner, coldex, rowdex) {
                            if (inner.length <= 0) return inner;
                            const el = new DOMParser().parseFromString(inner, 'text/html').body.childNodes;
                            let result = '';
                            el.forEach(item => {
                              if (item.classList && item.classList.contains('user-name')) {
                                result += item.lastChild.firstChild.textContent;
                              } else {
                                result += item.textContent || item.innerText || '';
                              }
                            });
                            return result;
                          }
                        }
                      }
                    },
                    {
                      extend: 'copy',
                      text: `<i class="icon-base bx bx-copy me-1"></i>Copy`,
                      className: 'dropdown-item',
                      exportOptions: {
                        columns: [3, 4, 5, 6],
                        format: {
                          body: function (inner, coldex, rowdex) {
                            if (inner.length <= 0) return inner;
                            const el = new DOMParser().parseFromString(inner, 'text/html').body.childNodes;
                            let result = '';
                            el.forEach(item => {
                              if (item.classList && item.classList.contains('user-name')) {
                                result += item.lastChild.firstChild.textContent;
                              } else {
                                result += item.textContent || item.innerText || '';
                              }
                            });
                            return result;
                          }
                        }
                      }
                    }
                  ]
                },
                {
                  text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New User</span>',
                  className: 'add-new btn btn-primary',
                  attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#offcanvasAddUser'
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
      // Add event listener for the "Add New User" button to reset the form
      initComplete: function () {
        const addNewButton = document.querySelector('.add-new');
        if (addNewButton) {
          addNewButton.addEventListener('click', () => {
            $('#offcanvasAddUserLabel').text('Add User'); // Reset title
            $('#addNewUserForm').removeAttr('data-user-id'); // Clear user ID
            $('#addNewUserForm')[0].reset(); // Reset form fields
            $('#user-role').val('').trigger('change'); // Reset role select2
            $('#user-branch').val('').trigger('change'); // Reset branch select2
            fv.resetForm(true); // Reset form validation
          });
        }
        const api = this.api();

        // Helper function to create a select dropdown and append options
        const createFilter = (columnIndex, containerClass, selectId, defaultOptionText) => {
          const column = api.column(columnIndex);
          const container = document.querySelector(containerClass);
          if (!container) {
            console.error(`Filter container ${containerClass} not found.`);
            return;
          }
          const select = document.createElement('select');
          select.id = selectId;
          select.className = 'form-select text-capitalize';
          select.innerHTML = `<option value="">${defaultOptionText}</option>`;
          container.appendChild(select);

          // Initialize select2 for the dynamically created filter
          $(select).wrap('<div class="position-relative"></div>').select2({
            placeholder: defaultOptionText,
            dropdownParent: $(select).parent()
          });

          // Add event listener for filtering
          $(select).on('change', () => { // Use jQuery for consistency with select2
            const val = $(select).val() ? `^${$(select).val()}$` : '';
            column.search(val, true, false).draw();
          });

          // Populate options based on unique column data
          const uniqueData = Array.from(new Set(column.data().toArray())).sort();
          uniqueData.forEach(d => {
            const option = new Option(d, d, false, false); // Create option for select2
            $(select).append(option);
          });
          $(select).trigger('change'); // Trigger change to update select2 display
        };

        // Role filter
        createFilter(3, '.user_role', 'UserRole', 'Select Role');

        // Status filter
        const statusFilter = document.createElement('select');
        statusFilter.id = 'FilterTransaction';
        statusFilter.className = 'form-select text-capitalize';
        statusFilter.innerHTML = '<option value="">Select Status</option>';
        const userStatusContainer = document.querySelector('.user_status');
        if (userStatusContainer) {
          userStatusContainer.appendChild(statusFilter);
          $(statusFilter).wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Status',
            dropdownParent: $(statusFilter).parent()
          });
          $(statusFilter).on('change', () => {
            const val = $(statusFilter).val() ? `^${$(statusFilter).val()}$` : '';
            api.column(4).search(val, true, false).draw();
          });
        } else {
          console.error('Filter container .user_status not found.');
        }

        const statusColumn = api.column(4);
        const uniqueStatusData = Array.from(new Set(statusColumn.data().toArray())).sort();
        uniqueStatusData.forEach(d => {
          const option = new Option(statusObj[d]?.title || d, statusObj[d]?.title || d, false, false);
          $(statusFilter).append(option);
        });
        $(statusFilter).trigger('change');

        // Created By filter
        createFilter(5, '.user_created_by', 'UserCreatedBy', 'Select Creator');

        // Branch filter
        createFilter(6, '.user_branch', 'UserBranch', 'Select Branch');
      },
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search User',
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
              return 'Details of ' + data['full_name'];
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
      }
    });

    //? The 'delete-record' class is necessary for the functionality of the following code.
    function deleteRecord(event) {
      let row = document.querySelector('.dtr-expanded');
      if (event) {
        row = event.target.parentElement.closest('tr');
      }
      if (row) {
        dt_user.row(row).remove().draw();
      }
    }

    function bindDeleteEvent() {
      const userListTable = document.querySelector('.datatables-users');
      const modal = document.querySelector('.dtr-bs-modal');

      if (userListTable && userListTable.classList.contains('collapsed')) {
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
        const tableBody = userListTable?.querySelector('tbody');
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
    // To remove default btn-secondary in export buttons
    $('.dt-buttons > .btn-group > button').removeClass('btn-secondary');
  }

  // Filter form control to default size
  // ? setTimeout used for user-list table initialization
  setTimeout(() => {
    const elementsToModify = [
      { selector: '.dt-buttons .btn', classToRemove: 'btn-secondary' },
      { selector: '.dt-search .form-control', classToRemove: 'form-control-sm' },
      { selector: '.dt-length .form-select', classToRemove: 'form-select-sm', classToAdd: 'ms-0' },
      { selector: '.dt-length', classToAdd: 'mb-md-6 mb-0' },
      { selector: '.dt-search', classToAdd: 'mb-md-6 mb-2' },
      {
        selector: '.dt-layout-end',
        classToRemove: 'justify-content-between',
        classToAdd: 'd-flex gap-md-4 justify-content-md-between justify-content-center gap-4 flex-wrap mt-0'
      },
      { selector: '.dt-layout-start', classToAdd: 'mt-0' },
      { selector: '.dt-buttons', classToAdd: 'd-flex gap-4 mb-md-0 mb-6' },
      { selector: '.dt-layout-table', classToRemove: 'row mt-2' },
      { selector: '.dt-layout-full', classToRemove: 'col-md col-12', classToAdd: 'table-responsive' }
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

  // Validation & Phone mask
  const phoneMaskList = document.querySelectorAll('.phone-mask'),
    addNewUserForm = document.getElementById('addNewUserForm');

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
  // Add New User Form Validation
  const fv = FormValidation.formValidation(addNewUserForm, {
    fields: {
      userFirstName: {
        validators: {
          notEmpty: {
            message: 'Please enter first name'
          }
        }
      },
      userLastName: {
        validators: {
          notEmpty: {
            message: 'Please enter last name'
          }
        }
      },
      userEmail: {
        validators: {
          notEmpty: {
            message: 'Please enter your email'
          },
          emailAddress: {
            message: 'The value is not a valid email address'
          }
        }
      },
      password: {
        validators: {
          notEmpty: {
            message: 'Please enter password'
          },
          stringLength: {
            min: 8,
            message: 'The password must be at least 8 characters long'
          }
        }
      },
      userRole: {
        validators: {
          notEmpty: {
            message: 'Please select a role'
          }
        }
      },
      branchId: {
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
          return '.form-control-validation';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // When the form is submitted and all fields are valid
    const form = addNewUserForm;
    const formData = new FormData(form);
    const data = {
      first_name: formData.get('userFirstName'),
      last_name: formData.get('userLastName'),
      email: formData.get('userEmail'),
      role: formData.get('userRole'),
      branch_id: formData.get('branchId'),
    };

    const userId = form.dataset.userId;
    const method = userId ? 'PUT' : 'POST';
    const url = userId ? `/app/users/${userId}` : '/app/users';

    // Only include password if it's a new user or password field is not empty
    if (!userId || formData.get('password')) {
      data.password = formData.get('password');
    }

    fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(data)
    })
      .then(response => {
        if (!response.ok) {
          // If response is not OK (e.g., 401, 403, 500), try to parse as JSON first
          // If that fails, it's likely HTML (e.g., login redirect)
          return response.json().catch(() => {
            throw new Error('Received non-JSON response for non-OK status. Possible redirection or server error.');
          });
        }
        return response.json();
      })
      .then(result => {
        if (result.message) {
          alert(result.message);
          dt_user.ajax.reload();
          if (offcanvasAddUser) offcanvasAddUser.hide();
        } else if (result.errors) {
          for (const field in result.errors) {
            if (result.errors.hasOwnProperty(field)) {
              alert(result.errors[field][0]);
            }
          }
        }
      })
      .catch(error => {
        console.error('Fetch Error:', error);
        if (error.message.includes('Unexpected token') || error.message.includes('non-JSON response')) {
          alert(
            'An unexpected server response occurred. This might be due to an expired session. Please log in again.'
          );
        } else {
          alert('An error occurred while saving the user. Check console for details.');
        }
      });
  });

  // Edit user functionality
  $(document).on('click', '.edit-record', function () {
    const userId = $(this).data('id');
    fetch(`/app/users/${userId}`) // Corrected URL to use the show method
      .then(response => response.json())
      .then(user => {
        $('#offcanvasAddUserLabel').text('Edit User');
        $('#addNewUserForm').attr('data-user-id', user.id);
        $('#add-user-firstname').val(user.first_name || ''); // Assuming input field for first name
        $('#add-user-lastname').val(user.last_name || ''); // Assuming input field for last name
        $('#add-user-email').val(user.email || '');
        if (user.role) $('#user-role').val(user.role).trigger('change'); // Directly use user.role
        if (user.branch_id) $('#user-branch').val(user.branch_id).trigger('change');
        // Populate other fields as needed

        if (offcanvasAddUser) offcanvasAddUser.show(); // Use the initialized instance
        else console.error('Bootstrap Offcanvas not available or element not found.');
      })
      .catch(error => console.error('Error fetching user for edit:', error));
  });

  // Suspend user
  $(document).on('click', '.suspend-record', function () {
    const userId = $(this).data('id');
    fetch(`/app/users/${userId}/suspend`, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    })
      .then(response => response.json())
      .then(result => {
        if (result.message) {
          alert(result.message);
          dt_user.ajax.reload();
        }
      })
      .catch(error => console.error('Error suspending user:', error));
  });

  // Activate user
  $(document).on('click', '.activate-record', function () {
    const userId = $(this).data('id');
    fetch(`/app/users/${userId}/activate`, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    })
      .then(response => response.json())
      .then(result => {
        if (result.message) {
          alert(result.message);
          dt_user.ajax.reload();
        }
      })
      .catch(error => console.error('Error activating user:', error));
  });

  // Delete user functionality
  $(document).on('click', '.delete-record', function () {
    const userId = $(this).data('id');
    if (confirm('Are you sure you want to delete this user?')) {
      fetch(`/app/users/${userId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        }
      })
        .then(response => response.json())
        .then(result => {
          if (result.message) {
            alert(result.message);
            dt_user.ajax.reload();
          }
        })
        .catch(error => console.error('Error deleting user:', error));
    }
  });
});
