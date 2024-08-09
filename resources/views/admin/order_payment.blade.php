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
    .form-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
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
    .counter {
        display: flex;
        align-items: center;
    }
    .counter button {
        width: 35px;
        height: 35px;
        border: 1px solid #7172b9;
        background-color: #7172b9;
        color: #ffffff;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
    }
    .counter button:hover {
        background-color: #2A2F5B;
        border-color: #2A2F5B;
    }
    .counter input {
        width: 50px;
        text-align: center;
        margin: 0 5px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px;
    }
    .btn-primary {
        background-color: #7172b9;
        border-color: #7172b9;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background-color: #7172b9;
        border-color: #7172b9;
    }
    .btn-info {
        background-color: #7172b9;
        border-color: #7172b9;
        border-radius: 5px;
    }
    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
    }
    .btn-block {
        display: block;
        width: 100%;
        text-align: center;
    }
    .text-primary {
        color: #2A2F5B;
    }
    .text-muted {
        color: #6c757d;
    }
</style>
<head>
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
                        <h2 class="text" style="color:#7172b9;">Add Payment </h2>
                        <p class="text-muted">Add payment for your order</p>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                       <h3 style="color:#7172b9;">Order : {{$order->id}}</h3>
                        <h4><b style="color:#7172b9;">User Name : {{$order->user->name}}</b></h3>
                            <h4><b style="color:#7172b9;">Total Amount : {{number_format($order->total_amoun)}} Rs/-</b></h3>
                                <h4><b style="color:#7172b9;">Remaining Amount : {{number_format($order->remaining_amount)}} Rs/-</b></h3>
                            <form id="paymentForm" action="{{ route('payment.store', $order->id) }}" method="POST" data-remaining-amount="{{$order->remaining_amount}}">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-md-4 form-group">
                                        <label for="method"><b style="color:#7172b9;">Method</b></label>
                                        <select class="form-control" id="method" name="method" required>
                                            <option value="" disabled selected>Select Method</option>
                                            <option value="card">Via Card</option>
                                            <option value="cod">Cash on Delivery</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="amount"><b style="color:#7172b9;">Amount</b></label>
                                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="date"><b style="color:#7172b9;">Date</b></label>
                                        <input type="date" class="form-control" id="date" name="date" placeholder="Enter date" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3 mb-5 form-group">
                                        <button type="submit" class="btn btn-secondary">Add Amount</button>
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
    @if(session('message'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('message') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <!-- SweetAlert Validation -->
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            var totalAmount = parseFloat(this.dataset.totalAmount);
            var enteredAmount = parseFloat(document.getElementById('amount').value);

            if (enteredAmount > totalAmount) {
                Swal.fire({
                    title: 'Error!',
                    text: 'The entered amount exceeds the total amount.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                this.submit(); // Submit the form if validation passes
            }
        });
    </script>

</body>
</html>
