/**
 * Page Backup List
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {
  let borderColor, bodyBg, headingColor;

  borderColor = config.colors.borderColor;
  bodyBg = config.colors.bodyBg;
  headingColor = config.colors.headingColor;

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Variable declaration for table
  const dtBackupTable = document.querySelector('.datatables-backups');
  let dt_backup = null; // Declare dt_backup in a broader scope

  // Backups datatable
  if (dtBackupTable) {
    dt_backup = new DataTable(dtBackupTable, {
      ajax: {
        url: '/backups/list',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        dataSrc: 'data'
      },
      columns: [
        // columns according to JSON
        { data: 'date' },
        { data: 'date' },
        { data: 'size' },
        { data: 'disk' },
        { data: 'actions' }
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
          // Backup Date
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['date']}</span>`;
          }
        },
        {
          // Backup Size
          targets: 2,
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['size']}</span>`;
          }
        },
        {
          // Backup Disk
          targets: 3,
          render: function (data, type, full, meta) {
            return `<span class="text-heading">${full['disk']}</span>`;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: (data, type, full, meta) => {
            const encodedDisk = btoa(full.disk);
            const encodedPath = btoa(full.path);
            return `
              <div class="d-flex align-items-center">
                <a href="/backups/download/${encodedDisk}/${encodedPath}" class="btn btn-icon" title="Download">
                  <i class="icon-base bx bx-download icon-md"></i>
                </a>
                <button class="btn btn-icon delete-record" data-disk="${encodedDisk}" data-path="${encodedPath}" title="Delete">
                  <i class="icon-base bx bx-trash icon-md"></i>
                </button>
              </div>
            `;
          }
        }
      ],
      order: [[1, 'desc']], // Order by date descending
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
                placeholder: 'Search Backups',
                text: '_INPUT_'
              }
            },
            {
              buttons: [
                {
                  text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Create New Backup</span>',
                  className: 'create-backup btn btn-primary',
                  action: function (e, dt, node, config) {
                    Swal.fire({
                      title: 'Create Backup?',
                      text: "This will create a new backup of your application.",
                      icon: 'info',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, create it!',
                      customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                      },
                      buttonsStyling: false
                    }).then(function (result) {
                      if (result.value) {
                        fetch('/backups/create', {
                          method: 'POST',
                          headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                          }
                        })
                          .then(response => response.json())
                          .then(data => {
                            if (data.message) {
                              Swal.fire({
                                icon: 'success',
                                title: 'Created!',
                                text: data.message,
                                customClass: {
                                  confirmButton: 'btn btn-success'
                                }
                              });
                              dt_backup.ajax.reload();
                            } else if (data.error) {
                              Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.error,
                                customClass: {
                                  confirmButton: 'btn btn-success'
                                }
                              });
                            }
                          })
                          .catch(error => {
                            console.error('Error creating backup:', error);
                            Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: 'Failed to create backup.',
                              customClass: {
                                confirmButton: 'btn btn-success'
                              }
                            });
                          });
                      }
                    });
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
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search Backups',
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
              return 'Details of Backup on ' + data['date'];
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
        // Remove btn-secondary from export buttons
        document.querySelectorAll('.dt-buttons .btn').forEach(btn => {
          btn.classList.remove('btn-secondary');
        });

        const api = this.api();

        // Disk filter
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

          $(select).wrap('<div class="position-relative"></div>').select2({
            placeholder: defaultOptionText,
            dropdownParent: $(select).parent()
          });

          $(select).on('change', () => {
            const val = $(select).val() ? `^${$(select).val()}$` : '';
            column.search(val, true, false).draw();
          });

          const uniqueData = Array.from(new Set(column.data().toArray())).sort();
          uniqueData.forEach(d => {
            const option = new Option(d, d, false, false);
            $(select).append(option);
          });
          $(select).trigger('change');
        };

        createFilter(3, '.backup_disk', 'FilterBackupDisk', 'Select Disk');
      }
    });

    // Delete Record
    document.addEventListener('click', function (e) {
      if (e.target.closest('.delete-record')) {
        const deleteBtn = e.target.closest('.delete-record');
        const disk = deleteBtn.dataset.disk;
        const path = deleteBtn.dataset.path;

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
            fetch(`/backups/delete/${disk}/${path}`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
              }
            })
              .then(response => response.json())
              .then(data => {
                if (data.message) {
                  dt_backup.draw();
                  Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: data.message,
                    customClass: {
                      confirmButton: 'btn btn-success'
                    }
                  });
                } else if (data.error) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.error,
                    customClass: {
                      confirmButton: 'btn btn-success'
                    }
                  });
                }
              })
              .catch(error => {
                console.error('Error deleting backup:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Failed to delete backup.',
                  customClass: {
                    confirmButton: 'btn btn-success'
                  }
                });
              });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'The backup is not deleted!',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        });
      }
    });
  }

  // Filter form control to default size
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
});
