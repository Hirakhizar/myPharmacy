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
                                    <td>{{ $cart->medicine->price }} Rs/-</td>
                                    <td>{{ $cart->qty }}</td>
                                    <td>{{ $cart->total }} Rs/-</td>
                                    <td>
                                        <button class='btn btn-danger delete-order' data-id="{{ $cart->id }}"><b>Remove</b></button>
        
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
                            <h4><b style="color: #7172b9">Total Price: {{ $total . ' Rs/-' }}</b></h4>
                            <div class="form-group">
                                <label style="color: #7172b9">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" name="customer" value='Anonymous Customer' required>
                            </div>
                            <div class="form-group">
                                <label style="color: #7172b9">Phone Number</label>
                                <input type="text" class="form-control" id="customerPhone" value="{{ old('phone') }}" name="phone" required>
                            </div>
                           
                            <div class="row mt-3">
                                <div class="col-md-4 form-group">
                                    <label for="method"><b style="color:#7172b9;">Method</b></label>
                                    <select class="form-control" id="method" name="method" required>
                                        <option value="" disabled selected>Select Method</option>
                                        <option value="card">Payment Via Card</option>
                                        <option value="cash Payment">Cash Payment</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="amount"><b style="color:#7172b9;">Amount</b></label>
                                    <input type="number" class="form-control" id="amount" name="amount"  value="{{ old('amount') }}"placeholder="Enter amount" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date"><b style="color:#7172b9;">Date</b></label>
                                    <input type="date" class="form-control" id="dateInput" name="date"  value="{{ old('date') }}"placeholder="Enter date" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-5 ml-5 form-group">
                                    <button type="submit" class="btn btn-secondary">Confirm Order</button>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to delete buttons
        document.querySelectorAll('.delete-order').forEach(function (button) {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-id');
                
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with deletion (send request to server)
                        fetch(`/cart/remove/${orderId}`, {
                            method: 'get',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                // Remove the row from the table
                                this.closest('tr').remove();

                                // Show success message
                                Swal.fire(
                                    'Deleted!',
                                    'Your item has been deleted.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to delete the item.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        });
                    } else {
                        // User canceled the deletion
                        console.log('item deletion canceled.');
                    }
                });
            });
        });
    });

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

        // JavaScript to set the default date
        const dateInput = document.getElementById('dateInput');
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    });
</script>

</body>
</html>
