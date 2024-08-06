<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
    <style>
        /* Your existing styles */
    </style>
    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container form-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 form-group" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;">Update PAyment Details</h2>
                        <p class="text-muted">Update payment for your order here</p>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                        <h3 style="color:#7172b9;">Order : {{$info->order_id}}</h3>
                       
                        <form action="{{ url('order/payment/update', ['id' => $info->id]) }}" method="POST">

                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-4 form-group">
                                    <label for="method"><b style="color:#7172b9;">Method</b></label>
                                    <select class="form-control" id="method" name="method" required>
                                        <option value="" disabled selected>Select Method</option>
                                        <option value="card" {{$info->payment_method=='card' ? 'selected' :''}}>Payment Via Card</option>
                                        <option value="cash Payment" {{$info->payment_method=='cash Payment' ? 'selected' :''}}>Cash Payment</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="amount"><b style="color:#7172b9;">Amount</b></label>
                                    <input type="number" class="form-control" id="amount" name="amount" value={{  $info->amount }} placeholder="Enter amount" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date"><b style="color:#7172b9;">Date</b></label>
                                    <input type="date" class="form-control" id="dateInput" name="date" value={{ $info->date }} placeholder="Enter date" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 mb-5 form-group">
                                    <button type="submit" class="btn btn-secondary">Update</button>
                                    <a href="{{ url('order/showOrders') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
        @include('admin.custom')
    </div>
    @include('admin.scripts')

    <!-- SweetAlert Notification -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('message'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('message') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

                    });
    </script>
</body>
</html>
