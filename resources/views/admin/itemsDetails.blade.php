<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
    <!-- Add jsPDF, html2canvas, and html2pdf libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        .hidden {
            display: none;
        }
        .search-container {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <!-- Main Header -->
            @include('admin.main_header')
            <!-- End Main Header -->

            <div class="container mt-5 p-5">
                <div class="d-flex mt-5 justify-content-end">
                    <a href="{{ url('order/showOrders') }}" class="btn btn-secondary mt-5 mx-5">Back</a>
                </div>
               
                <!-- Receipt Section -->
                <div class="card mt-5 mx-5" id="receipt">
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3 text-center">
                            <h2 class="text-secondary">Order Details</h2>
                            <p class="text-muted">Customer's Items List.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md- text-secondary">
                            <h5>Order #: <strong>{{ $order->id }}</strong></h5>
                            <h5>Customer Name: <strong>{{ $order->customer }}</strong></h5>
                            <h5>Phone Number: <strong>{{ $order->phone }}</strong></h5>
                            <h5>Total Amount: <strong>${{ number_format($order->total, 2) }}</strong></h5>
                            <h5>Paid Amount: <strong>${{ number_format($order->paid, 2) }}</strong></h5>
                            <h5>Remaining Amount: <strong>${{ number_format($order->remaining, 2) }}</strong></h5>
                        </div>
                        <div class="table-responsive p-3">
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
                                    <tr>
                                        <td>{{ $item->medicineItems->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>${{ number_format($item->medicineItems->price, 2) }}</td>
                                        <td>${{ number_format($item->qty * $item->medicineItems->price, 2) }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Section -->
                <div class="px-5">
                    <div class="card my-5 w-100 px-5">
                        <div class="row mt-3 px-5">
                            <div class="col-md-12 mb-3 text-center px-5">
                                <h2 class="text-secondary">Payment Details</h2>
                                <p class="text-muted">Customer Payments List.</p>
                            </div>
                        </div>
                        <div class="card-body">
                         
                            <div class="table-container">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Paid Installments</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderTableBody">
                                        @foreach ($info as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>{{ $payment->payment_status }}</td>
                                            <td>{{ $payment->date }}</td>
                                            <td><a href="{{ url('order/payment/edit', ['id' => $payment->id]) }}" class="btn btn-secondary"><b>Edit</b></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination mt-3 d-flex justify-content-center">
                                    {{ $info->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('admin.footer')
            <!-- End Footer -->
        </div>

        <!-- Custom template | don't include it in your project! -->
        @include('admin.custom')
        <!-- End Custom template -->
    </div>

    <!-- Core JS Files -->
    @include('admin.scripts')

    <!-- JavaScript for PDF generation -->
    <script>
        function formatDateString(dateString) {
            const date = new Date(dateString);
            return isNaN(date.getTime()) ? '' : date.toISOString().split('T')[0]; // Convert date to YYYY-MM-DD format
        }

        document.getElementById('searchDateInput').addEventListener('input', function() {
            const filterDate = new Date(this.value);
            const rows = document.querySelectorAll('#orderTableBody tr');
    
            rows.forEach(row => {
                const dateText = row.cells[4].textContent; // Adjust the index to match the date column
                const rowDate = new Date(dateText);
    
                row.style.display = (isNaN(filterDate.getTime()) || rowDate.toDateString() === filterDate.toDateString()) ? '' : 'none';
            });
        });
    
        document.getElementById('searchCustomerInput').addEventListener('input', function() {
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
