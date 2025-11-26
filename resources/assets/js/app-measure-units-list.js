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
              <a href="/measure-units/${full.id}/edit" class="btn btn-icon"><i class="icon-base bx bx-edit icon-md"></i></a>
              <a href="/measure-units/${full.id}" class="btn btn-icon"><i class="icon-base bx bx-show icon-md"></i></a>
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
    addMeasureForm.addEventListener('submit', function () {
      const data = {
        name: addMeasureForm.name.value,
        short_name: addMeasureForm.short_name.value
      };
      fetch('/measure-units', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
      })
        .then(r => r.json())
        .then(res => {
          if (res.message) {
            const el = document.getElementById('offcanvasAddMeasureUnit');
            if (el && typeof bootstrap !== 'undefined') {
              bootstrap.Offcanvas.getOrCreateInstance(el).hide();
            }
            dt.ajax.reload();
          }
        });
    });
  }
});
