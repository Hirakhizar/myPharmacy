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
    <!-- Sidebar -->
    @include('admin.sidebar')
    <!-- End Sidebar -->

    <div class="main-panel">
      {{-- main-header --}}
      @include('admin.main_header')
      {{-- end main-header --}}
      <div class="container mt-5">
        <div class="row">
          <div class="col-12">
            <div class="p-4 ">
              <p style="color: #778edd"><b style="font-size: 30px;">Purchase</b> Report </p>

            </div>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            <button id="download-pdf" class="btn btn-info">Download PDF</button>
            <button id="export-excel" class="btn btn-success mx-4">Export to Excel</button>
        </div>
        <div class="search-container mx-4">
          <div class="row" style="color: #778edd">
            <div class="col-md-3 position-relative">
              <h4 style="color: #778edd">Search Invoice No</h4>
              <input type="text" class="form-control" id="searchOrderIdInput" placeholder="Search by invoice no">
            </div>
            <div class="col-md-3 position-relative">
              <h4 style="color: #778edd">Manufacturers</h4>
              <input type="text" class="form-control" id="searchManufacturerInput" placeholder="Search by manufacturer">
              <div id="manufacturerSuggestions" class="suggestions"></div>
            </div>
            <div class="col-md-3">
              <h4 style="color: #778edd">Start Date</h4>
              <input type="date" class="form-control" id="startDateInput">
            </div>
            <div class="col-md-3">
              <h4 style="color: #778edd">End Date</h4>
              <input type="date" class="form-control" id="endDateInput">
            </div>
          </div>
        </div>
        <div class="row mt-5 mx-2">
          <div class="col-12">
            <div class="card" style="background-color: #f1f1f1; border-radius: 8px;  border: 1px solid #ccc; ">
              <div class="card-body" id="pdf-content">
                <table class="table table-striped table-hover" id="purchaseTable">
                  <thead>
                    <tr >
                      <th style="color: #778edd">#Invoice No</th>
                      <th style="color: #778edd">Total Amount</th>
                      <th style="color: #778edd">Manufacturer</th>
                      <th style="color: #778edd">Date/Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($purchase as $manufacturer)
                    <tr>
                      <td>#{{ $manufacturer->id }}</td>
                      <td>{{ $manufacturer->total_amount }} Rs/-</td>
                      <td>{{ $manufacturer->manufacturer }}</td>
                      <td>{{ $manufacturer->created_at }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

  <script>
    // Pass manufacturer data to JavaScript
    const manufacturers = @json($purchase->pluck('manufacturer'));

    function filterSuggestions(input, suggestions, list) {
      const filter = input.value.toLowerCase();
      suggestions.innerHTML = '';
      if (!filter) {
        return;
      }
      const filtered = list.filter(item => item.toLowerCase().includes(filter));
      filtered.forEach(item => {
        const div = document.createElement('div');
        div.classList.add('suggestion-item');
        div.textContent = item;
        div.onclick = () => {
          input.value = item;
          suggestions.innerHTML = '';
          filterTable();
        };
        suggestions.appendChild(div);
      });
    }

    const searchManufacturerInput = document.getElementById('searchManufacturerInput');
    const manufacturerSuggestions = document.getElementById('manufacturerSuggestions');
    searchManufacturerInput.addEventListener('input', () => filterSuggestions(searchManufacturerInput, manufacturerSuggestions, manufacturers));

    function filterTable() {
      const orderIdFilter = document.getElementById('searchOrderIdInput').value.toLowerCase();
      const manufacturerFilter = document.getElementById('searchManufacturerInput').value.toLowerCase();
      const startDate = document.getElementById('startDateInput').value;
      const endDate = document.getElementById('endDateInput').value;
      const rows = document.querySelectorAll('#purchaseTable tbody tr');

      rows.forEach(row => {
        const orderId = row.cells[0].textContent.toLowerCase();
        const manufacturer = row.cells[2].textContent.toLowerCase();
        const date = new Date(row.cells[3].textContent);
        const startDateObj = startDate ? new Date(startDate) : null;
        const endDateObj = endDate ? new Date(endDate) : null;

        if (startDateObj) startDateObj.setHours(0, 0, 0, 0);
        if (endDateObj) endDateObj.setHours(23, 59, 59, 999);

        const showRow = (!orderIdFilter || orderId.includes(orderIdFilter))
                        && (!manufacturerFilter || manufacturer.includes(manufacturerFilter))
                        && (!startDate || date >= startDateObj)
                        && (!endDate || date <= endDateObj);
        row.style.display = showRow ? '' : 'none';
      });
    }

    document.getElementById('searchOrderIdInput').addEventListener('input', filterTable);
    document.getElementById('searchManufacturerInput').addEventListener('input', filterTable);
    document.getElementById('startDateInput').addEventListener('input', filterTable);
    document.getElementById('endDateInput').addEventListener('input', filterTable);

    // PDF and Excel export functionalities
    function downloadPDF() {
      const element = document.getElementById('pdf-content');
      const opt = {
        margin: 1,
        filename: 'purchase_report.pdf',
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
      XLSX.writeFile(workbook, 'purchase_report.xlsx');
    }

    document.getElementById('export-excel').addEventListener('click', exportExcel);
  </script>
</body>
</html>
