<!DOCTYPE html>
<html lang="en">
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
</style>

<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container table-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;">Manufacturer Ledger</h2>
                        <p class="text-muted">List of all your payments.</p>
                    </div>
                </div>
                <div class="search-container">
                    <div class="row" style="color: #7172b9">
                        <div class="col-md-6">
                            <h4>Search order</h4>
                            <input type="date" class="form-control" id="searchDateInput" placeholder="Search by Date and Time">
                        </div>
                        <div class="col-md-6">
                            <h4>Search Manufacturers</h4>
                            <input type="text" class="form-control" id="searchManufacturerInput" placeholder="Search by manufacturer">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="card my-5 w-100">
                        <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px;  border: 1px solid #ccc; ">
                            <div class="d-flex justify-content-end mb-3">
                                <form method="GET" action="{{ url()->current() }}">
                                    <select id="entriesPerPage" name="per_page" class="form-select" style="width: auto;" onchange="this.form.submit()">
                                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    </select>
                                </form>
                            </div>
                            <div class="table-container" id="pdf-content">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Manufacturer</th>
                                            <th>Date</th>
                                            <th>Debit ($)</th>
                                            <th>Credit ($)</th>
                                            <th>Balance ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="medicineTableBody">
                                        @php
                                            $balances = [];
                                        @endphp
                                        @foreach ($transactions as $transaction)
                                            @php
                                                $manufacturerId = $transaction['manufacturer_id'];
                                                if (!isset($balances[$manufacturerId])) {
                                                    $balances[$manufacturerId] = 0;
                                                }

                                                if ($transaction['type'] == 'debit') {
                                                    $balances[$manufacturerId] += $transaction['amount'];
                                                    $debitAmount = number_format($transaction['amount'], 2);
                                                    $creditAmount = '-';
                                                } else {
                                                    $balances[$manufacturerId] -= $transaction['amount'];
                                                    $debitAmount = '-';
                                                    $creditAmount = number_format($transaction['amount'], 2);
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $transaction['order_id'] }}</td>
                                                <td>{{ $transaction['manufacturer'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaction['date'])->format('Y-m-d') }}</td>
                                                <td>{{ $debitAmount }}</td>
                                                <td>{{ $creditAmount }}</td>
                                                <td>{{ number_format($balances[$manufacturerId], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>




                            </div>

                            <button id="download-pdf" class="btn btn-warning">Download PDF</button>
                            <button id="export-excel" class="btn btn-success">Export to Excel</button>
                            <div class="d-flex justify-content-center" style="height: 50px">
                                {!! $transactions->appends(['per_page' => $perPage])->links() !!}
                            </div>
                        </div>
                    </div>
            </div>
            @include('admin.footer')
        </div>
        @include('admin.custom')
    </div>
    @include('admin.scripts')
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    document.getElementById('searchDateInput').addEventListener('input', function() {
        const filterDate = new Date(this.value);
        const rows = document.querySelectorAll('#medicineTableBody tr');

        rows.forEach(row => {
            const dateText = row.cells[2].textContent.trim();
            const rowDate = new Date(dateText);

            row.style.display = (isNaN(filterDate.getTime()) || rowDate.toDateString() === filterDate.toDateString()) ? '' : 'none';
        });
    });

    document.getElementById('searchManufacturerInput').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#medicineTableBody tr');

        rows.forEach(row => {
            const manufacturerText = row.cells[1].textContent.toLowerCase();
            row.style.display = manufacturerText.includes(filter) ? '' : 'none';
        });
    });

    document.getElementById('entriesPerPage').addEventListener('change', function() {
        const perPage = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });

    function downloadPDF() {
        const element = document.getElementById('pdf-content');
        const opt = {
            margin:       1,
            filename:     'manufacturer_ledger.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf().from(element).set(opt).save();
    }

    document.getElementById('download-pdf').addEventListener('click', downloadPDF);

    function exportExcel() {
        const table = document.getElementById('pdf-content');
        const workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
        XLSX.writeFile(workbook, 'manufacturer_ledger.xlsx');
    }

    document.getElementById('export-excel').addEventListener('click', exportExcel);
</script>
