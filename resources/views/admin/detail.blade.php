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
                    <div class="col-md-12 mb-3" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;">Your Order Detail</h2>
                        <p class="text-muted">List of all your order detail.</p>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Category</th>
                                        <th>Manufacturer</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->medicine->name }}</td>
                                            <td>{{ $item->medicine->category->name ?? 'Unknown' }}</td>
                                            <td>{{ $item->medicine->manufacturer->company_name ?? 'Unknown' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{$item->medicine->price}} Rs/-</td>
                                            <td>{{ $item->quantity * $item->medicine->price}} Rs/-</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- ..................................payment info............................ --}}
                <div class="row mt-3">
                    <div class="col-md-12 mb-3" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;">Your Payment Detail</h2>
                        <p class="text-muted">List of all your Payments detail.</p>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>

                                            <td>{{ $payment->order_id }}</td>
                                            <td>{{ $payment->method }}</td>
                                            <td>{{ number_format($payment->amount) }} Rs/-</td>
                                            <td>{{ $payment->date }}</td>


                                            </tr>
                                            @endforeach

                                </tbody>
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
