/**
 * Page Measure Units List
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const dtTable = document.querySelector('.datatables-measure-units');
  if (!dtTable) return;

  const dt = new DataTable(dtTable, {
    ajax: '/app/measure-units/list',
    columns: [
      { data: 'id' },
      { data: 'id', orderable: false, render: DataTable.render.select() },
      { data: 'name' },
      { data: 'short_name' },
      { data: 'actions' }
    ],
    columnDefs: [
      {
        className: 'control',
        searchable: false,
        orderable: false,
        responsivePriority: 2,
        targets: 0,
        render: () => ''
      },
      {
        targets: -1,
        title: 'Actions',
        searchable: false,
        orderable: false,
        render: (data, type, full) => {
          return `
            <div class="d-flex align-items-center">
              <a href="javascript:;" class="btn btn-icon edit-record" data-id="${full.id}"><i class="icon-base bx bx-edit icon-md"></i></a>
              <a href="javascript:;" class="btn btn-icon delete-record" data-id="${full.id}"><i class="icon-base bx bx-trash icon-md"></i></a>
            </div>
          `;
        }
      }
    ],
    select: { style: 'multi', selector: 'td:nth-child(2)' },
    order: [[2, 'desc']],
    layout: {
      topStart: {
        rowClass: 'row mx-3 my-0 justify-content-between',
        features: [{ pageLength: { menu: [10, 25, 50, 100], text: '_MENU_' } }]
      },
      topEnd: {
        features: [
          { search: { placeholder: 'Search Measure Unit', text: '_INPUT_' } },
          {
            buttons: [
              {
                text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Measure Unit</span>',
                className: 'add-new btn btn-primary',
                action: function () {
                  const el = document.getElementById('offcanvasAddMeasureUnit');
                  const form = document.getElementById('addMeasureUnitForm');
                  if (form) {
                    form.reset();
                    form.removeAttribute('data-id');
                  }
                  const label = document.getElementById('offcanvasAddMeasureUnitLabel');
                  if (label) label.textContent = 'Add Measure Unit';
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
      bottomStart: { rowClass: 'row mx-3 justify-content-between', features: ['info'] },
      bottomEnd: 'paging'
    },
    language: {
      sLengthMenu: '_MENU_',
      search: '',
      searchPlaceholder: 'Search Measure Unit',
      paginate: {
        next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>',
        previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>',
        first: '<i class="icon-base bx bx-chevrons-left scaleX-n1-rtl icon-18px"></i>',
        last: '<i class="icon-base bx bx-chevrons-right scaleX-n1-rtl icon-18px"></i>'
      }
    },
    responsive: {
      details: {
        display: DataTable.Responsive.display.modal({ header: row => 'Details of ' + row.data()['name'] }),
        type: 'column',
        renderer: function (api, rowIdx, columns) {
          const data = columns
            .map(col =>
              col.title !== ''
                ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>`
                : ''
            )
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
      const api = this.api();
      const createFilter = (columnIndex, containerClass, selectId, defaultOptionText) => {
        const column = api.column(columnIndex);
        const select = document.createElement('select');
        select.id = selectId;
        select.className = 'form-select text-capitalize';
        select.innerHTML = `<option value="">${defaultOptionText}</option>`;
        const container = document.querySelector(containerClass);
        if (!container) return;
        container.appendChild(select);
        select.addEventListener('change', () => {
          const val = select.value ? `^${select.value}$` : '';
          column.search(val, true, false).draw();
        });
        const uniqueData = Array.from(new Set(column.data().toArray())).sort();
        uniqueData.forEach(d => {
          const option = document.createElement('option');
          option.value = d;
          option.textContent = d;
          select.appendChild(option);
        });
      };

      createFilter(3, '.measure_short', 'MeasureShort', 'Select Short Name');
    }
  });

  const addMeasureForm = document.getElementById('addMeasureUnitForm');
  if (addMeasureForm) {
    // Add/Edit Measure Unit Form Validation
    const fv = FormValidation.formValidation(addMeasureForm, {
      fields: {
        measureName: {
          validators: {
            notEmpty: {
              message: 'Please enter measure unit name'
            }
          }
        },
        measureShort: {
          validators: {
            notEmpty: {
              message: 'Please enter measure unit short name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.form-control-validation';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // When the form is submitted and all fields are valid
      const form = addMeasureForm;
      const formData = new FormData(form);
      const data = {
        name: formData.get('measureName'),
        short_name: formData.get('measureShort')
      };
      const id = form.getAttribute('data-id');
      const method = id ? 'PUT' : 'POST';
      const url = id ? `/measure-units/${id}` : '/measure-units';
      fetch(url, {
        method: method,
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
            const el = document.getElementById('offcanvasAddMeasureUnit');
            if (el && typeof bootstrap !== 'undefined') {
              bootstrap.Offcanvas.getOrCreateInstance(el).hide();
            }
            dt.ajax.reload();
            addMeasureForm.reset();
            addMeasureForm.removeAttribute('data-id');
            fv.resetForm(true); // Reset form validation
            if (window.toastr) {
              toastr.success(res.message, 'Success!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
              });
            } else {
              alert('Success: ' + res.message);
            }
          } else if (res.errors) {
            for (const [key, value] of Object.entries(res.errors)) {
              if (window.toastr) {
                toastr.error(value, 'Error!', {
                  closeButton: true,
                  tapToDismiss: false,
                  rtl: isRtl
                });
              } else {
                alert('Error: ' + value);
              }
            }
          }
        })
        .catch(async err => {
          console.error('Measure Unit save failed:', err);
          let errorResponse = null;
          try {
            errorResponse = JSON.parse(err.message);
          } catch (e) {
            // If parsing fails, it's not a JSON error response, so we'll treat it as a generic error
          }

          if (errorResponse && typeof errorResponse === 'object' && errorResponse.errors) {
            for (const [key, value] of Object.entries(errorResponse.errors)) {
              if (window.toastr) {
                toastr.error(value, 'Error!', {
                  closeButton: true,
                  tapToDismiss: false,
                  rtl: isRtl
                });
              } else {
                alert('Error: ' + value);
              }
            }
          } else {
            if (window.toastr) {
              toastr.error('An unexpected error occurred. Please try again.', 'Error!', {
                closeButton: true,
                tapToDismiss: false,
                rtl: isRtl
              });
            } else {
              alert('Error: An unexpected error occurred. Please try again.');
            }
          }
        });
    });
  }

  $(document).on('click', '.edit-record', function () {
    const id = $(this).data('id');
    fetch(`/measure-units/${id}/edit`, {
      headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(async r => {
        const text = await r.text();
        try {
          return JSON.parse(text);
        } catch (e) {
          throw new Error(text);
        }
      })
      .then(m => {
        document.getElementById('offcanvasAddMeasureUnitLabel').textContent = 'Edit Measure Unit';
        addMeasureForm.setAttribute('data-id', m.id);
        document.getElementById('measure-name').value = m.name || '';
        document.getElementById('measure-short').value = m.short_name || '';
        const el = document.getElementById('offcanvasAddMeasureUnit');
        if (el && typeof bootstrap !== 'undefined') {
          bootstrap.Offcanvas.getOrCreateInstance(el).show();
        }
      })
      .catch(err => {
        console.error('Measure Unit edit fetch failed:', err);
        alert('Failed to load measure unit for edit.');
      });
  });

  $(document).on('click', '.delete-record', function () {
    const id = $(this).data('id');
    if (!confirm('Delete this measure unit?')) return;
    fetch(`/measure-units/${id}`, {
      method: 'DELETE',
      headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
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
        if (res.message) dt.ajax.reload();
      })
      .catch(err => {
        console.error('Measure Unit delete failed:', err);
        alert('Failed to delete measure unit.');
      });
  });
});
