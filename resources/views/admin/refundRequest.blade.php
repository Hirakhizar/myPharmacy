<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<body>
<div class="wrapper">
    @include('admin.sidebar')

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container form-container"> 
            <div class="row mt-5 w-100 d-flex justify-content-center px-5">
                <div class="card my-5 w-100">
                    <h3 style="color: #7172b9; text-align: center; margin: 20px">Refund Order # {{ $order->id }}</h3>
                    <div class="form-group">
                        <label>Customer: {{ $order->customer }}</label>
                    </div>
                    <div class="form-group">
                        <label>Contact: {{ $order->phone }}</label>
                    </div>
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
                            @foreach($orderItems as $item)
                                @if($item->refund_status == 'noRequest')
                                    <tr>
                                        <td>{{ $item->medicineItems->name }}</td>
                                        <td>{{ $item->medicineItems->category->name }}</td>
                                        <td>{{ $item->medicineItems->price }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>
                                            <button onclick="confirmRemoval({{ $item->id }})" class="btn btn-danger"><b>Refund</b></button>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $total += $item->total;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card-body w-50">
                        <div class="row mt-3">
                            <div class="col-md-6 mb-5 ml-5 form-group">
                                <a href="{{ url('order/refund/') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
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
    function confirmRemoval(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/order/refund/item/' + itemId;
            }
        });
    }

    @if(Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ Session::get('error') }}',
        });
    @endif

    @if(Session::has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('success') }}',
        });
    @endif
</script>
</body>
</html>
