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
                                        <th>View Detail</th>
                                        <th>Invoice_no</th>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total Amount</th>
                                        <th>Date</th>
                                        <th>Payment Status</th>
                                        <th>Payment</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody id="orderTableBody">
                                    @foreach ($orders as $order)
                                    <tr >
                                        <td style="color: #7172b9" class="order-row" data-order-id="{{ $order->id }}"><i class="fas fa-chevron-down toggle-icon h-4" ></i></td>
                                        <td style="color: #7172b9"> #{{ $order->invoice}}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer }}</td>
                                        <td>{{ $order->total}} Rs/-</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td><a href="{{ url('sales/payment/show', ['id' => $order->id]) }}" class='btn btn-secondary '><b>Pay</b></a></td>
                                        <td>
                                           
                                        
                                                <a href="{{ url('order/recipte',['id'=>$order->id]) }}" class="btn btn-secondary ">Receipt</a>
                                        
                                        </td>
                                    </tr>
                                    <tr class="details-row" id="details-{{ $order->id }}" style="display: none;">
                                        <td colspan="7">
                                            <div class="p-3">
                                                <!-- Include additional details here -->
                                               
                                                    <div class="card-body">
                                                        <div class="col-md-4 text-secondary">
                                                            
                                                          </div>
                                                        <div class="table-responsive ">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Medicine Name</th>
                                                                        <th>Quantity</th>
                                                                        <th>Price</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($orderitems as $item)
                                                                    @if($item->refund_status == 'noRequest')
                                                                    @if ($item->order_id==$order->id)
                                                                        
                                                                   
                                                                    <tr>
                                                                        <td>{{ $item->medicineItems->name }}</td>
                                                                        <td>{{ $item->qty }}</td>
                                                                        <td>{{ $item->medicineItems->price }} Rs/-</td>
                                                                        <td>{{$item->qty * $item->medicineItems->price}} Rs/-</td>
                                                                    </tr>
                                                                   
                                                                    @endif
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                
                                    
                                                        <div class="row  px-5">
                                                            <div class="col-md-12 mb-3 text-center px-5">
                                                                <h2 class="text-secondary">Payment Details</h2>
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                         
                                                            <div class="table-container">
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sr.No</th>
                                                                            <th>Paid Installments</th>
                                                                            <th>Payment Method</th>
                                                                            <th>Status</th>
                                                                            <th>Date</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="orderTableBody">
                                                                        @php
                                                                            $count=0;
                                                                        @endphp
                                                                        @foreach ($info as $payment)
                                                                        @if ($payment->order_id==$order->id)
                                                                        <tr>
                                                                            <td>{{ ++$count }}</td>
                                                                            <td>{{$payment->amount}} Rs/-</td>
                                                                            <td>{{ $payment->payment_method }}</td>
                                                                            <td>{{ $payment->payment_status }}</td>
                                                                            <td>{{ $payment->date }}</td>
                                                                            <td><a href="{{ url('order/payment/edit', ['id' => $payment->id]) }}" class="btn btn-secondary"><b>Edit</b></a></td>
                                                                        </tr>
                                                                        @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                              
                                                            </div>
                                                        </div>
                                           
                                                
                                                <!-- Add more details as needed -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination mt-3 d-flex justify-content-center">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
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

    <script>
        document.querySelectorAll('.order-row').forEach(row => {
            row.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const detailsRow = document.getElementById(`details-${orderId}`);

                // Toggle visibility
                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });

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
</body>
</html>
