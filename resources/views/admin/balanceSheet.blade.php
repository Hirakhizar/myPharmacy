<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        body {
            background-color: #f7f9fc;
            font-family: Arial, sans-serif;
        }
        .wrapper, .main-panel {
            background-color: #ffffff;
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
            padding: 25px;
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
</head>
<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container table-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 text-center">
                        <h2 class="text-secondary">Balance Sheet</h2>
                        <p class="text-muted"></p>
                        <div class="text-end mb-3 mx-4">
                            <button id="exportButton" class="btn btn-success">Export to Excel</button>
                        </div>
                    </div>
                </div>
                <div class="search-container">
                    <form method="GET" action="{{ url('balanceSheet') }}" class="row">
                        <div class="col-md-6 mb-3">
                            <h4 class='text-secondary'>Start Date</h4>
                            <input type="date" id="startDateInput" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4 class='text-secondary'>End Date</h4>
                            <input type="date" id="endDateInput" class="form-control" value="{{ request('end_date') }}">
                        </div>
                    </form>
                </div>
               
                <div class="card my-5 w-100">
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                @php
                                $currentBalance = 0;
                                $count = 0;
                                @endphp
                                <tbody id="ledgerTableBody">
                                    @foreach($ledger as $entry)
                                        <tr>
                                            <td>{{ ++$count }}</td>
                                            <td>{{ $entry['date'] }}</td>
                                            <td>{{ $entry['description'] }}</td>
                                            <td>{{ $entry['debit'] ? number_format($entry['debit']).' Rs/-' : '-' }}</td>
                                            <td>{{ $entry['credit'] ? number_format($entry['credit']).' Rs/-' : '-' }}</td>
                                            <td>
                                                @php
                                                    $currentBalance = $entry['balance'];
                                                @endphp
                                                {{ number_format($currentBalance) }} Rs/-
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Totals</th>
                                        <th>{{ number_format($ledger->sum('debit')) }} Rs/-</th>
                                        <th>{{ number_format($ledger->sum('credit')) }} Rs/-</th>
                                        <th>{{ number_format($currentBalance) }} Rs/-</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
        @include('admin.custom')
    </div>
    @include('admin.scripts')
    <script>
        function filterTable() {
            const startDate = new Date(document.getElementById('startDateInput').value);
            const endDate = new Date(document.getElementById('endDateInput').value);
            const rows = document.querySelectorAll('#ledgerTableBody tr');

            rows.forEach(row => {
                const rowDateText = row.cells[1].textContent; // Adjust the index to match the date column
                const rowDate = new Date(rowDateText);

                // Check if the row date is within the range or if no date is selected
                if (
                    (isNaN(startDate.getTime()) || rowDate >= startDate) &&
                    (isNaN(endDate.getTime()) || rowDate <= endDate)
                ) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        document.getElementById('startDateInput').addEventListener('change', filterTable);
        document.getElementById('endDateInput').addEventListener('change', filterTable);

        // Initial filter on page load in case of pre-set dates
        document.addEventListener('DOMContentLoaded', filterTable);

        function exportTableToExcel() {
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.table_to_sheet(document.querySelector('table'));

            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            XLSX.writeFile(wb, "balance_sheet.xlsx");
        }

        document.getElementById('exportButton').addEventListener('click', exportTableToExcel);
    </script>
</body>
</html>
