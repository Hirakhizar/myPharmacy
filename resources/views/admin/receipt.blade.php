<!DOCTYPE html>
<html lang="en">
@include('admin.head')

<body>
<div class="wrapper">
    @include('admin.sidebar')

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container">
            <div class="row mt-5">
                <div class="card my-5 w-100">
                    <div class="card-body">
                        <h2>Order Receipt</h2>
                        @if (isset($orderDetails))
                        <p><strong>Order ID:</strong> {{ $orderDetails['id'] }}</p>
                        <p><strong>Name:</strong> {{ $orderDetails['purchaser_name'] }}</p>
                        <p><strong>Phone Number:</strong> {{ $orderDetails['purchaser_phone'] }}</p>
                        <p><strong>Total Amount:</strong>{{ $orderDetails['total_amount']}} Rs/-</p>

                        <h3>Order Details</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($orderDetails['items']))
                                    @foreach ($orderDetails['items'] as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td>{{number_format($item['price'])}} Rs/-</td>
                                        <td>{{ number_format($item['total_price'])}} Rs/-</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">No items found in the order.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @else
                        <p>No order details available.</p>
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
