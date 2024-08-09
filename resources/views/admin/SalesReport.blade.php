<!DOCTYPE html>
<html lang="en">
{{-- head --}}
@include('admin.head')

<style>
body {
        background-color: #f7f9fc;
        font-family: Arial, sans-serif;
    }
    .wrapper {
        background-color: #ffffff;
    }
    .main-panel {
        background-color: #f7f9fc;
    }
    .search-container {
        background-color: #f1f1f1;
        border-radius: 8px;
        padding: 20px;
        margin: 20px;
        border: 1px solid #ccc;
    }
    .search-container h4 {
        margin-bottom: 15px;
    }
    .table-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .table th {
        color: #7172b9;
        border: 1px solid #dee2e6;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .text-primary {
        color: #2A2F5B;
    }
    .text-muted {
        color: #6c757d;
    }

.icon-button {
  background: none;
  border: none;
  font-size: 1.5rem;
  color: #000;
  cursor: pointer;
  margin-right: 10px;
}

.hidden-list {
  display: none;
  position: absolute;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px; /* Rounded corners */
  padding: 10px;
  max-height: 200px; /* Set maximum height */
  overflow-y: auto; /* Add scrollbar for long lists */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  z-index: 1000;
  /* Match the width of the input field */
  width: calc(100% - 20px); /* Adjust to account for padding */
}

.hidden-list li {
  padding: 8px;
  border-radius: 4px; /* Rounded corners for list items */
  cursor: pointer; /* Change cursor on hover */
}

.hidden-list li:hover {
  background-color: #f0f0f0; /* Subtle hover effect */
}

</style>

{{-- end head --}}
<body>
  <div class="wrapper">
    @include('admin.sidebar')
    <div class="main-panel">
      @include('admin.main_header')
      <div class="container mt-5">
        <div class="row">
          <div class="col-11 container mt-3">
            <div class="p-4 ">
              <p style="color: #778edd"><b style="font-size: 30px;">Sales</b> Report </p>
            </div>
            <div class="d-flex justify-content-end">
                <button id="download-pdf" class="btn btn-info">
                   Download PDF </button>
                <button id="export-excel" class="btn btn-success mx-2">
               Exprt to Excel </button>
            </div>
          </div>
        </div>
        <form method="GET" action="{{ url('reports/salesreport') }}">
          <div class="search-container">
            <div class="row " style="color: #778edd">
              <div class="col-md-3">
                <p><b>Search OrderId</b></p>
                <input type="text" class="form-control" id="searchOrderIdInput" name="orderId" placeholder="Search by id" value="{{ request('orderId') }}">
                <ul id="searchOrderIdList" class="hidden-list w-25">
                  @foreach($orders as $order)
                    <li data-value="{{ $order->id }}">{{ $order->id }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="col-md-3">
                <p><b>Customer</b></p>
                <input type="text" class="form-control" id="searchCustomerInput" name="customer" placeholder="Search by customer" value="{{ request('customer') }}">
                <ul id="searchCustomerList" class="hidden-list  w-25">
                  @foreach($orders as $order)
                    <li data-value="{{ $order->customer }}">{{ $order->customer }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="col-md-3">
                <p><b>Start Date</b></p>
                <input type="date" class="form-control" id="startDateInput" name="startDate" value="{{ request('startDate') }}" placeholder="Enter start date">
              </div>
              <div class="col-md-3">
                <p><b>End Date</b></p>
                <input type="date" class="form-control" id="endDateInput" name="endDate" value="{{ request('endDate') }}" placeholder="Enter end date">
              </div>


            </div>
          </div>
        </form>
        <!-- Content to be exported starts here -->

        <div class="container">
            <div class="card my-5 w-100">
                <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px;  border: 1px solid #ccc; ">
                    <div class="table-container" id="pdf-content">

                 <table class="table table-striped table-hover mb-3" id="purchaseTable" style="background: #FAFDFD">
                  <thead >
                    <tr>
                      <th style="color: #778edd">No.</th>
                      <th style="color: #778edd">Invoice_No</th>
                      <th style="color: #778edd">Date</th>
                      <th style="color: #778edd">Customer</th>
                      <th style="color: #778edd">Total Amount</th>
                      <th style="color: #778edd">Payment Status</th>
                    </tr>
                  </thead>
                  @php
                      $count = 0;
                  @endphp
                  <tbody>
                    @foreach($orders as $order)
                    <tr>
                      <td>{{ ++$count }}</td>
                      <td style="color: #778edd">#{{ $order->invoice }}</td>
                      <td>{{ $order->date }}</td>
                      <td>{{ $order->customer }}</td>
                      <td>{{ number_format($order->total) }} Rs/-</td>
                      <td>{{ $order->payment_status }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="pagination mt-3 d-flex justify-content-center">
          {{ $orders->links('pagination::bootstrap-5') }}
        </div>
        <!-- Content to be exported ends here -->
      </div>
      {{-- footer --}}
      @include('admin.footer')
      {{-- end footer --}}
    </div>

    <!-- Custom template | don't include it in your project! -->
    @include('admin.custom')
    <!-- End Custom template -->
  </div>

  <!-- Core JS Files -->
  @include('admin.scripts')

  <!-- Additional Scripts for PDF and Excel Export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome Kit -->

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const searchOrderIdInput = document.getElementById('searchOrderIdInput');
      const searchOrderIdList = document.getElementById('searchOrderIdList');
      const searchCustomerInput = document.getElementById('searchCustomerInput');
      const searchCustomerList = document.getElementById('searchCustomerList');

      function updateListVisibility(input, list) {
        const inputValue = input.value.toLowerCase();
        const listItems = list.children;
        let hasVisibleItem = false;

        for (const item of listItems) {
          const text = item.textContent.toLowerCase();
          if (text.includes(inputValue)) {
            item.style.display = '';
            hasVisibleItem = true;
          } else {
            item.style.display = 'none';
          }
        }
        list.style.display = hasVisibleItem ? 'block' : 'none';
      }

      function handleListItemClick(input, list) {
        list.addEventListener('click', (e) => {
          if (e.target.tagName === 'LI') {
            input.value = e.target.getAttribute('data-value');
            list.style.display = 'none';
            filterTable(); // Apply the filter when an item is selected
          }
        });
      }

      searchOrderIdInput.addEventListener('input', () => updateListVisibility(searchOrderIdInput, searchOrderIdList));
      searchCustomerInput.addEventListener('input', () => updateListVisibility(searchCustomerInput, searchCustomerList));

      handleListItemClick(searchOrderIdInput, searchOrderIdList);
      handleListItemClick(searchCustomerInput, searchCustomerList);

      document.addEventListener('click', (e) => {
        if (e.target !== searchOrderIdInput && e.target !== searchCustomerInput) {
          searchOrderIdList.style.display = 'none';
          searchCustomerList.style.display = 'none';
        }
      });

      function filterTable() {
        const orderIdFilter = document.getElementById('searchOrderIdInput').value.toLowerCase();
        const customerFilter = document.getElementById('searchCustomerInput').value.toLowerCase();
        const startDateInput = document.getElementById('startDateInput').value;
        const endDateInput = document.getElementById('endDateInput').value;

        const startDateObj = startDateInput ? new Date(startDateInput) : null;
        const endDateObj = endDateInput ? new Date(endDateInput) : null;

        if (startDateObj) startDateObj.setHours(0, 0, 0, 0);
        if (endDateObj) endDateObj.setHours(23, 59, 59, 999);

        const rows = document.querySelectorAll('#purchaseTable tbody tr');

        rows.forEach(row => {
          const orderId = row.cells[1].textContent.toLowerCase(); // Fixed to correct cell index
          const customer = row.cells[3].textContent.toLowerCase();
          const dateText = row.cells[2].textContent;
          const date = new Date(dateText);

          if (isNaN(date.getTime())) {
            row.style.display = 'none';
            return;
          }

          const showRow = (!orderIdFilter || orderId.includes(orderIdFilter))
                          && (!customerFilter || customer.includes(customerFilter))
                          && (!startDateObj || date >= startDateObj)
                          && (!endDateObj || date <= endDateObj);

          row.style.display = showRow ? '' : 'none';
        });
      }

      document.getElementById('searchOrderIdInput').addEventListener('input', filterTable);
      document.getElementById('searchCustomerInput').addEventListener('input', filterTable);
      document.getElementById('startDateInput').addEventListener('input', filterTable);
      document.getElementById('endDateInput').addEventListener('input', filterTable);

      function downloadPDF() {
        const element = document.getElementById('pdf-content');
        const opt = {
          margin: 1,
          filename: 'Sales_report.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save();
      }

      document.getElementById('download-pdf').addEventListener('click', downloadPDF);

      function exportExcel() {
        const table = document.getElementById('purchaseTable');
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet JS" });
        XLSX.writeFile(workbook, 'Sales_report.xlsx');
      }

      document.getElementById('export-excel').addEventListener('click', exportExcel);
    });
  </script>

</body>
</html>
