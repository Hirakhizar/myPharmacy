<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<body>
<div class="wrapper">
    @include('admin.sidebar')

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container form-container ">
            <div class="row mt-5 w-100 d-flex justify-content-center px-5">
                <div class="card my-5 w-100">
                    <h3 style="color: #7172b9; text-align: center; margin: 20px">Your Cart</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="color: #7172b9">Medicine Name</th>
                                <th style="color: #7172b9">Category</th>
                                <th style="color: #7172b9">Price</th>
                                <th style="color: #7172b9">Quantity</th>
                                <th style="color: #7172b9">SubTotal</th>
                                <th style="color: #7172b9">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php
                                $total = 0;
                            @endphp
                            @foreach($carts as $cart)
                                <tr>
                                    <td>{{ $cart->medicine->name }}</td>
                                    <td>{{ $cart->medicine->category->name }}</td>
                                    <td>{{ $cart->medicine->price }}</td>
                                    <td>{{ $cart->qty }}</td>
                                    <td>{{ $cart->total }}</td>
                                    <td>
                                        <form action="{{ url('cart/remove', $cart->id) }}" method="POST" onsubmit="return confirm('Are you sure to remove this medicine?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $total += $cart->total;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Customer Information Form -->
                    <div class="card-body w-50">
                        <form action="{{ url('order/confirm') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label style="color: #7172b9">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" name="customer" required>
                            </div>
                            <div class="form-group">
                                <label style="color: #7172b9">Phone Number</label>
                                <input type="text" class="form-control" id="customerPhone" name="phone" required>
                            </div>
                            <h4><b style="color: #7172b9">Total Price: {{ $total . ' $' }}</b></h4>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-5 ml-5 form-group">
                                    <input type="submit" class="btn" value="Confirm Order" style="background-color: #7172b9; color: white">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>

    @include('admin.custom')
</div>

@include('admin.scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Add your custom JavaScript here
</script>

</body>
</html>
