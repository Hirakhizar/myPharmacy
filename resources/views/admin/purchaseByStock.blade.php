<!DOCTYPE html>
<html lang="en">
{{-- head --}}
@include('admin.head')

<style>
  .search-container {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    margin: 40px;
  }
  .search-container h4 {
    margin-bottom: 15px;
  }
  .suggestions {
    border: 1px solid #ddd;
    border-top: none;
    max-height: 150px;
    overflow-y: auto;
    position: absolute;
    z-index: 1000;
    background-color: white;
    width: 100%;
  }
  .suggestion-item {
    padding: 10px;
    cursor: pointer;
  }
  .suggestion-item:hover {
    background-color: #f0f0f0;
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
          <div class="col-11 container mt-3">
            <div class="p-4  text-center">
              <h2  class="text-secondary mt-3">Purchase By Stock Report</h2>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end mx-5">
            <button id="download-pdf" class="btn btn-warning mx-3">Download PDF</button>
            <button id="export-excel" class="btn btn-success">Export to Excel</button>
        </div>
        <div class="search-container">
          <div class="row" >
            <div class="col-md-3 position-relative">
              <h4 class="text-secondary">Search Medicine</h4>
              <input type="text" class="form-control" id="searchMedicineInput" placeholder="Search by medicine">
              <div id="medicineSuggestions" class="suggestions"></div>
            </div>
            <div class="col-md-3 position-relative">
              <h4 class="text-secondary">Manufacturer</h4>
              <input type="text" class="form-control" id="searchManufacturerInput" placeholder="Search by manufacturer">
              <div id="manufacturerSuggestions" class="suggestions"></div>
            </div>
            <div class="col-md-3">
              <h4 class="text-secondary">Start Date</h4>
              <input type="date" class="form-control" id="startDateInput">
            </div>
            <div class="col-md-3">
              <h4 class="text-secondary">End Date</h4>
              <input type="date" class="form-control" id="endDateInput">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-11 container">
            <div class='card container' id="pdf-content">
              <table class="table table-striped table-hover" id="purchaseTable">
                <thead>
                  <tr>
                    <th class="text-secondary">#Invoice no</th>
                    <th class="text-secondary">Medicine</th>
                    <th class="text-secondary">Manufacturer</th>
                    <th class="text-secondary">Quantity</th>
                    <th class="text-secondary">Status</th>
                    <th class="text-secondary">Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($medicine as $manufacturer)
                  <tr>
                    <td>{{ $manufacturer->order_id }}</td>
                    <td>{{ $manufacturer->medicine->name }}</td>
                    <td>{{ $manufacturer->medicine->manufacturer->company_name }}</td>
                    <td>{{ $manufacturer->quantity }}</td>
                    <td>{{ $manufacturer->status }}</td>
                    <td>{{ $manufacturer->created_at }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
      {{-- footer --}}
      @include('admin.footer')
    </div>
    @include('admin.custom')
    <!-- End Custom template -->
  </div>
  <!-- Core JS Files -->
  @include('admin.scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script>
    const medicines = @json($medicine->pluck('medicine.name'));
    const manufacturers = @json($medicine->pluck('medicine.manufacturer.company_name'));

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

    const searchMedicineInput = document.getElementById('searchMedicineInput');
    const medicineSuggestions = document.getElementById('medicineSuggestions');
    searchMedicineInput.addEventListener('input', () => filterSuggestions(searchMedicineInput, medicineSuggestions, medicines));

    const searchManufacturerInput = document.getElementById('searchManufacturerInput');
    const manufacturerSuggestions = document.getElementById('manufacturerSuggestions');
    searchManufacturerInput.addEventListener('input', () => filterSuggestions(searchManufacturerInput, manufacturerSuggestions, manufacturers));

    function filterTable() {
      const medicineFilter = searchMedicineInput.value.toLowerCase();
      const manufacturerFilter = searchManufacturerInput.value.toLowerCase();
      const startDate = document.getElementById('startDateInput').value;
      const endDate = document.getElementById('endDateInput').value;
      const rows = document.querySelectorAll('#purchaseTable tbody tr');

      rows.forEach(row => {
        const medicine = row.cells[1].textContent.toLowerCase();
        const manufacturer = row.cells[2].textContent.toLowerCase();
        const date = new Date(row.cells[5].textContent);
        const startDateObj = startDate ? new Date(startDate) : null;
        const endDateObj = endDate ? new Date(endDate) : null;

        if (startDateObj) startDateObj.setHours(0, 0, 0, 0);
        if (endDateObj) endDateObj.setHours(23, 59, 59, 999);

        const showRow = (!medicineFilter || medicine.includes(medicineFilter))
                        && (!manufacturerFilter || manufacturer.includes(manufacturerFilter))
                        && (!startDate || date >= startDateObj)
                        && (!endDate || date <= endDateObj);
        row.style.display = showRow ? '' : 'none';
      });
    }

    document.getElementById('startDateInput').addEventListener('input', filterTable);
    document.getElementById('endDateInput').addEventListener('input', filterTable);

    // PDF and Excel export functionalities
    function downloadPDF() {
      const element = document.getElementById('pdf-content');
      const opt = {
        margin: 1,
        filename: 'stock_report.pdf',
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
      XLSX.writeFile(workbook, 'stock_report.xlsx');
    }

    document.getElementById('export-excel').addEventListener('click', exportExcel);
  </script>
</body>
</html>
