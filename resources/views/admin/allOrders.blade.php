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
                        <h2 class="text-secondary">Your Orders</h2>
                        <p class="text-muted">List of all your orders.</p>
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
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>Payment Status</th>
                                        <th>Payment</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="orderTableBody">
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td><a href="{{ url('sales/payment/show', ['id' => $order->id]) }}" class='btn btn-secondary'><b>Pay</b></a></td>
                                   
                                        <td><a href="{{ url('sales/itemsDetails', ['id' => $order->id]) }}" class='btn btn-sm btn-secondary'><b>Detail</b></a>
                                        
                                            <div class="text-right mt-3 px-3 pb-5">
                                                <a href="{{ url('order/recipte',['id'=>$order->id]) }}" class="btn btn-sm btn-secondary">Generate Receipt</a>
                                             
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($orders->isEmpty())
                                <p class="text-muted text-center">No orders found for the selected filters.</p>
                            @endif
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
