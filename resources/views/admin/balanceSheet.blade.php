<!DOCTYPE html>
<html lang="en">
@include('admin.head')

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

<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container table-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 text-center">
                        <h2 class="text-secondary">Balance Sheet</h2></h2>
                        <p class="text-muted"></p>
                    </div>
                </div>
                <div class="search-container">
                    <form method="GET" action="{{ url('order/showOrders') }}" class="row">
                        <div class="col-md-6 mb-3">
                            <h4 class='text-secondary'>Search Customer</h4>
                            <input type="text" name="customer" class="form-control" placeholder="Search by Customer" value="{{ request('customer') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4 class='text-secondary'>Search Date</h4>
                            <input type="date" name="order_date" class="form-control" value="{{ request('order_date') }}">
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </form>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Description</th>                                     
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                       
                                    </tr>
                                </thead>
                                @php
                                $currentBalance = 0;
                                $count=0;
                            @endphp
                            @foreach($ledger as $entry)
                                <tr>
                                    <td>{{ ++$count }}</td>
                                    <td>{{ $entry['date'] }}</td>
                                    <td>{{ $entry['description'] }}</td>
                                    <td>{{ $entry['debit'] ? number_format($entry['debit'], 2) : '-' }}</td>
                                    <td>{{ $entry['credit'] ? number_format($entry['credit'], 2) : '-' }}</td>
                                    <td>
                                        @php
                                            $currentBalance = $entry['balance'];
                                        @endphp
                                        {{ number_format($currentBalance, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Totals</th>
                                <th>${{ number_format($ledger->sum('debit'), 2) }}</th>
                                <th>${{ number_format($ledger->sum('credit'), 2) }}</th>
                                <th>${{ number_format($currentBalance, 2) }}</th>
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
</body>
</html>

<script>
    document.getElementById('searchDateInput').addEventListener('input', function() {
        const filterDate = new Date(this.value);
        const rows = document.querySelectorAll('#orderTableBody tr');

        rows.forEach(row => {
            const dateText = row.cells[3].textContent; // Adjust the index to match the date column
            const rowDate = new Date(dateText);

            row.style.display = (isNaN(filterDate.getTime()) || rowDate.toDateString() === filterDate.toDateString()) ? '' : 'none';
        });
    });

    document.getElementById('searchManufacturerInput').addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#orderTableBody tr');

        rows.forEach(row => {
            const customerText = row.cells[1].textContent.toLowerCase();
            row.style.display = customerText.includes(filter) ? '' : 'none';
        });
    });
</script>
