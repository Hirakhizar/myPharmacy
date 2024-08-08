<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<style>
    /* Your existing CSS styles */
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
                        <h3 style="color:#7172b9;">Order : {{$payment->order_id}}</h3>
                        <h4><b style="color:#7172b9;">User Name : {{$payment->order->user->name}}</b></h4>
                        <h4><b style="color:#7172b9;">Total Amount : {{$payment->order->total_amount}} Rs/-</b></h4>
                        <h4><b style="color:#7172b9;">Remaining Amount : {{$payment->order->remaining_amount}} Rs/-</b></h4>
                        <form id="paymentForm" action="{{ route('payment.update', $payment->order_id) }}" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                <input type="hidden" id="remainingAmount" value="{{ $payment->order->remaining_amount }}">
                                <input type="hidden" id="totalAmount" value="{{ $payment->order->total_amount }}">

                                <div class="col-md-4 form-group">
                                    <label for="method"><b style="color:#7172b9;">Method</b></label>
                                    <select class="form-control" id="method" name="method" required>
                                        <option value="" disabled selected>Select Method</option>
                                        <option value="card" {{$payment->method == 'card' ? 'selected' : ''}}>Via Card</option>
                                        <option value="cod" {{$payment->method == 'cod' ? 'selected' : ''}}>Cash on Delivery</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="amount"><b style="color:#7172b9;">Amount</b></label>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" value="{{$payment->amount}}" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date"><b style="color:#7172b9;">Date</b></label>
                                    <input type="date" class="form-control" id="date" name="date" placeholder="Enter date" value="{{$payment->date}}" required>
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

    @if(session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            var totalAmount = parseFloat(document.getElementById('totalAmount').value);
            var remainingAmount = parseFloat(document.getElementById('remainingAmount').value);
            var enteredAmount = parseFloat(document.getElementById('amount').value);

            if (enteredAmount > totalAmount) {
                Swal.fire({
                    title: 'Error!',
                    text: 'The entered amount exceeds the total amount.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
             else {
                this.submit(); // Submit the form if the validation passes
            }
        });
    </script>
</body>
</html>
