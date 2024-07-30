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
                      
                        <p><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p><strong>Name:</strong> {{$order->customer }}</p>
                        <p><strong>Phone Number:</strong> {{$order->phone}}</p>
                        <p><strong>Total Amount:</strong></p>

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
                                
                                    @foreach ($orderitem as $item)
                                    <tr>
                                        <td>{{ $item->medicine->name }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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