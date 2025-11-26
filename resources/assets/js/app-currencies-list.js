/**
 * Page Currencies List
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {
  const dtTable = document.querySelector('.datatables-currencies');
  if (!dtTable) return;

  const dt = new DataTable(dtTable, {
    ajax: '/app/currencies/list',
    columns: [
      { data: 'id' },
      { data: 'id', orderable: false, render: DataTable.render.select() },
      { data: 'name' },
      { data: 'code' },
      { data: 'symbol' },
      // { data: 'is_default' },
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
          { search: { placeholder: 'Search Currency', text: '_INPUT_' } },
          {
            buttons: [
              {
                text: '<i class="icon-base bx bx-plus icon-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Currency</span>',
                className: 'add-new btn btn-primary',
                action: function () {
                  const el = document.getElementById('offcanvasAddCurrency');
                  const form = document.getElementById('addCurrencyForm');
                  if (form) {
                    form.reset();
                    form.removeAttribute('data-id');
                  }
                  const label = document.getElementById('offcanvasAddCurrencyLabel');
                  if (label) label.textContent = 'Add Currency';
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
      searchPlaceholder: 'Search Currency',
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

      createFilter(3, '.currency_code', 'CurrencyCode', 'Select Code');
      createFilter(6, '.currency_default', 'CurrencyDefault', 'Select Default');
    }
  });

  const addCurrencyForm = document.getElementById('addCurrencyForm');
  if (addCurrencyForm) {
    addCurrencyForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const data = {
        name: document.getElementById('currency-name').value,
        code: document.getElementById('currency-code').value,
        symbol: document.getElementById('currency-symbol').value
        // is_default: document.getElementById('currency-default').checked ? 1 : 0
      };
      const id = addCurrencyForm.getAttribute('data-id');
      const method = id ? 'PUT' : 'POST';
      const url = id ? `/currencies/${id}` : '/currencies';
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
            const el = document.getElementById('offcanvasAddCurrency');
            if (el && typeof bootstrap !== 'undefined') {
              bootstrap.Offcanvas.getOrCreateInstance(el).hide();
            }
            dt.ajax.reload();
            addCurrencyForm.reset();
            addCurrencyForm.removeAttribute('data-id');
          }
        })
        .catch(err => {
          console.error('Currency save failed:', err);
          alert('Failed to save currency. Please check inputs and try again.');
        });
    });
  }

  $(document).on('click', '.edit-record', function () {
    const id = $(this).data('id');
    fetch(`/currencies/${id}/edit`, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
      .then(async r => {
        const text = await r.text();
        try {
          return JSON.parse(text);
        } catch (e) {
          throw new Error(text);
        }
      })
      .then(c => {
        document.getElementById('offcanvasAddCurrencyLabel').textContent = 'Edit Currency';
        addCurrencyForm.setAttribute('data-id', c.id);
        document.getElementById('currency-name').value = c.name || '';
        document.getElementById('currency-code').value = c.code || '';
        document.getElementById('currency-symbol').value = c.symbol || '';
        // document.getElementById('currency-default').checked = !!c.is_default;
        const el = document.getElementById('offcanvasAddCurrency');
        if (el && typeof bootstrap !== 'undefined') {
          bootstrap.Offcanvas.getOrCreateInstance(el).show();
        }
      })
      .catch(err => {
        console.error('Currency edit fetch failed:', err);
        alert('Failed to load currency for edit.');
      });
  });

  $(document).on('click', '.delete-record', function () {
    const id = $(this).data('id');
    if (!confirm('Delete this currency?')) return;
    fetch(`/currencies/${id}`, {
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
        console.error('Currency delete failed:', err);
        alert('Failed to delete currency.');
      });
  });
});
