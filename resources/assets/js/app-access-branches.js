/**
 * App Branches List
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const dtBranchTable = document.querySelector('.datatables-branches');
  let dt_Branch;
  const isRtl = $('html').attr('dir') === 'rtl';

  // Branches List datatable
  if (dtBranchTable) {
    dt_Branch = new DataTable(dtBranchTable, {
      ajax: {
        url: '/app/branches',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        dataSrc: 'data'
      },
      columns: [
        // columns according to JSON
        { data: '' }, // For responsive control
        { data: 'id', orderable: false, render: DataTable.render.select() }, // For checkboxes
        { data: 'name' },
        { data: 'location' },
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
            return `<span class="text-heading">${full['location']}</span>`;
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
                <a href="javascript:;" class="btn btn-icon delete-record" data-id="${full.id}"><i class="icon-base bx bx-trash icon-md"></i></a>
                <a href="javascript:;" class="btn btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md"></i></a>
                <div class="dropdown-menu dropdown-menu-end m-0">
                  <a href="javascript:;" class="dropdown-item edit-record" data-id="${full.id}">Edit</a>
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
                placeholder: 'Search Branch',
                text: '_INPUT_'
              }
            },
            {
              buttons: [
                {
                  text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Branch</span>',
                  className: 'add-new btn btn-primary',
                  action: function () {
                    const el = document.getElementById('offcanvasAddBranch');
                    const form = document.getElementById('addBranchForm');
                    if (form) {
                      form.reset();
                      form.removeAttribute('data-branch-id');
                    }
                    const label = document.getElementById('offcanvasAddBranchLabel');
                    if (label) label.textContent = 'Add Branch';
                    if (el && typeof bootstrap !== 'undefined') {
                      const instance = bootstrap.Offcanvas.getOrCreateInstance(el);
                      instance.show();
                    }
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
        dt_Branch.row(row).remove().draw();
      }
    }

    function bindDeleteEvent() {
      const branchTable = document.querySelector('.datatables-branches');
      const modal = document.querySelector('.dtr-bs-modal');

      if (branchTable && branchTable.classList.contains('collapsed')) {
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
        const tableBody = branchTable?.querySelector('tbody');
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

  var addBranchForm = document.getElementById('addBranchForm');

  // Add/Edit Branch Form Validation and Submission
  addBranchForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const nameVal = document.getElementById('modalBranchName').value;
    const descVal = document.getElementById('modalBranchLocation').value;
    const data = { name: nameVal, location: descVal };
    const branchId = addBranchForm.dataset.branchId;
    const method = branchId ? 'PUT' : 'POST';
    const url = branchId ? `/app/branches/${branchId}` : '/app/branches';
    fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(data)
    })
      .then(async r => {
        const text = await r.text();
        try {
          return JSON.parse(text);
        } catch (e) {
          throw new Error(text);
        }
      })
      .then(res => {
        if (res.message) {
          dt_Branch.ajax.reload();
          const el = document.getElementById('offcanvasAddBranch');
          if (el && typeof bootstrap !== 'undefined') {
            bootstrap.Offcanvas.getOrCreateInstance(el).hide();
          }
          addBranchForm.reset();
          addBranchForm.removeAttribute('data-branch-id');
          toastr.success(res.message, 'Success!', {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl
          });
        } else if (res.errors) {
          for (const [key, value] of Object.entries(res.errors)) {
            toastr.error(value, 'Error!', {
              closeButton: true,
              tapToDismiss: false,
              rtl: isRtl
            });
          }
        }
      })
      .catch(async err => {
        console.error('Branch save failed:', err);
        try {
          const errorResponse = JSON.parse(err.message);
          if (errorResponse.errors) {
            for (const [key, value] of Object.entries(errorResponse.errors)) {
              toastr.error(value, 'Error!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
              });
            }
          } else {
            toastr.error('Failed to save branch. Please check inputs and try again.', 'Error!', {
              closeButton: true,
              tapToDismiss: false,
              rtl: isRtl
            });
          }
        } catch (e) {
          toastr.error('An unexpected error occurred. Please try again.', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl
          });
        }
      });
  });

  // Delete branch functionality
  $(document).on('click', '.delete-record', function () {
    const branchId = $(this).data('id');
    if (confirm('Are you sure you want to delete this branch?')) {
      fetch(`/app/branches/${branchId}`, {
        method: 'DELETE',
        headers: {
          Accept: 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
        .then(response => response.json())
        .then(result => {
          if (result.message) {
            alert(result.message);
            dt_Branch.ajax.reload();
          }
        })
        .catch(error => console.error('Error deleting branch:', error));
    }
  });

  $(document).on('click', '.edit-record', function () {
    const branchId = $(this).data('id');
    fetch(`/app/branches/${branchId}`, {
      headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(response => response.json())
      .then(branch => {
        document.getElementById('modalBranchName').value = branch.name || '';
        document.getElementById('modalBranchLocation').value = branch.location || '';
        const form = document.getElementById('addBranchForm');
        form.setAttribute('data-branch-id', branch.id);
        const el = document.getElementById('offcanvasAddBranch');
        const label = document.getElementById('offcanvasAddBranchLabel');
        if (label) label.textContent = 'Edit Branch';
        if (el && typeof bootstrap !== 'undefined') {
          const instance = bootstrap.Offcanvas.getOrCreateInstance(el);
          instance.show();
        }
      })
      .catch(error => console.error('Error fetching branch:', error));
  });
});
