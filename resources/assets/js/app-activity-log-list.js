/**
 * Page Activity Log List
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const dtTable = document.querySelector('.datatables-activity');
  if (!dtTable) return;

  const dt = new DataTable(dtTable, {
    ajax: '/activity-log/list',
    columns: [
      { data: 'date' },
      { data: 'date', orderable: false, render: DataTable.render.select() },
      { data: 'date' },
      { data: 'causer' },
      { data: 'event' },
      { data: 'subject' },
      { data: 'description' },
      { data: 'changes' }
    ],
    columnDefs: [
      { className: 'control', searchable: false, orderable: false, responsivePriority: 2, targets: 0, render: () => '' }
    ],
    select: { style: 'multi', selector: 'td:nth-child(2)' },
    order: [[2, 'desc']],
    layout: {
      topStart: {
        rowClass: 'row mx-3 my-0 justify-content-between',
        features: [{ pageLength: { menu: [10, 25, 50, 100], text: '_MENU_' } }]
      },
      topEnd: { features: [{ search: { placeholder: 'Search Activity', text: '_INPUT_' } }] },
      bottomStart: { rowClass: 'row mx-3 justify-content-between', features: ['info'] },
      bottomEnd: 'paging'
    },
    language: {
      sLengthMenu: '_MENU_',
      search: '',
      searchPlaceholder: 'Search Activity',
      paginate: {
        next: '<i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>',
        previous: '<i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>',
        first: '<i class="icon-base bx bx-chevrons-left scaleX-n1-rtl icon-18px"></i>',
        last: '<i class="icon-base bx bx-chevrons-right scaleX-n1-rtl icon-18px"></i>'
      }
    },
    responsive: {
      details: {
        display: DataTable.Responsive.display.modal({ header: row => 'Details of ' + row.data()['date'] }),
        type: 'column',
        renderer: function (api, rowIdx, columns) {
          const data = columns
            .map(col => (col.title !== '' ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}"><td>${col.title}:</td><td>${col.data}</td></tr>` : ''))
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

      createFilter(4, '.activity_event', 'ActivityEvent', 'Select Event');
      createFilter(3, '.activity_causer', 'ActivityCauser', 'Select Causer');
    }
  });
});

