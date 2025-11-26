/**
 * Page Backups List
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const dtTable = document.querySelector('.datatables-backups');
  if (!dtTable) return;

  const dt = new DataTable(dtTable, {
    ajax: '/backups/list',
    columns: [
      { data: 'date' },
      { data: 'date', orderable: false, render: DataTable.render.select() },
      { data: 'date' },
      { data: 'size' },
      { data: 'disk' },
      { data: 'actions' }
    ],
    columnDefs: [
      { className: 'control', searchable: false, orderable: false, responsivePriority: 2, targets: 0, render: () => '' },
      {
        targets: -1,
        title: 'Actions',
        searchable: false,
        orderable: false,
        render: (data, type, full) => {
          const diskEnc = btoa(full.disk);
          const pathEnc = btoa(full.path || '');
          return `
            <div class="d-flex align-items-center">
              <a href="/backups/download/${diskEnc}/${pathEnc}" class="btn btn-icon"><i class="icon-base bx bx-download icon-md"></i></a>
              <a href="javascript:;" class="btn btn-icon delete-backup" data-disk="${diskEnc}" data-path="${pathEnc}"><i class="icon-base bx bx-trash icon-md"></i></a>
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
      topEnd: { features: [{ search: { placeholder: 'Search Backup', text: '_INPUT_' } }] },
      bottomStart: { rowClass: 'row mx-3 justify-content-between', features: ['info'] },
      bottomEnd: 'paging'
    },
    language: {
      sLengthMenu: '_MENU_',
      search: '',
      searchPlaceholder: 'Search Backup',
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
    }
  });

  $(document).on('click', '.delete-backup', function () {
    const disk = $(this).data('disk');
    const path = $(this).data('path');
    if (!confirm('Are you sure you want to delete this backup?')) return;
    fetch(`/backups/delete/${disk}/${path}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
    })
      .then(r => r.json())
      .then(res => { if (res.message) { alert(res.message); dt.ajax.reload(); } })
      .catch(err => console.error('Error deleting backup:', err));
  });
});

