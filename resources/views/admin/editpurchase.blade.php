<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<style>
.counter {
    display: flex;
    align-items: center;
}
.counter button {
    width: 50px;
    height: 30px;
}
.counter input {
    width: 80px;
    text-align: center;
    margin: 0 5px;
}
</style>
<body>
<div class="wrapper">
    @include('admin.sidebar')

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container ml-5">
            <div class="row mt-5 ml-5 w-100 d-flex justify-content-center">
                <div class="col-md-11 mt-5">
                    <span class="d-flex justify-content-end mt-5"> <a href={{url('/purchase/list' )}} class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Back</a></span>
            </div>
                <div class="card my-5 w-75">
                    <form id="updateMedicineForm" action="{{ url('purchase/update', $purchases->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3 form-group">
                                <h2>Update Purchase</h2>
                                <p>You can update the purchase by editing these fields.</p>
                            </div>
                        </div>

                        <div class="row mt-3">

                            <div class="col-md-4 form-group">
                                <label for="medicine_id"><b>Medicine Name</b></label>
                                <select class="form-control" name="medicine_id" id="medicine_id" required>
                                    <option value="" disabled>Select Medicine</option>
                                    @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}" @if($purchases->medicine_id == $medicine->id) selected @endif>{{ $medicine->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="category_id"><b>Category</b></label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="" disabled>Select Category</option>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}" @if($purchases->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="manufacturer_id"><b>Manufacturer</b></label>
                                <select class="form-control" name="manufacturer_id" id="manufacturer_id" required>
                                    <option value="" disabled>Select Manufacturer</option>
                                    @foreach ($manufactures as $manu)
                                    <option value="{{ $manu->id }}" @if($purchases->manufacturer_id == $manu->id) selected @endif>{{ $manu->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="quantity"><b>Quantity</b></label>
                                <div class="counter">
                                    <button type="button" class="form-control" onclick="increaseValue()">+</button>
                                    <input type="number" class="form-control" id="counter" name="quantity" value="{{ $purchases->quantity }}" readonly>
                                    <button type="button" class="form-control" onclick="decreaseValue()">-</button>
                                </div>
                            </div>
                            {{-- <div class="col-md-4 form-group">
                                <label for="total_price"><b>Total Price</b></label>
                                <input type="number" class="form-control" id="total_price" name="total_price" placeholder="Total Price" value="{{ $purchases->total_price }}" readonly>
                            </div> --}}
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3 mb-5 form-group">
                                <button type="submit" class="btn btn-success">Update Purchase</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- List of Purchases can go here --}}

        @include('admin.footer')
    </div>

    @include('admin.custom')
</div>

@include('admin.scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('updateMedicineForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Assuming you have a way to get the remaining amount, you need to set it here
    var remainingAmount = parseFloat('{{ $order->remaining_amount }}'); // Adjust according to your actual remaining amount variable
    var enteredAmount = parseFloat(document.getElementById('counter').value);

    if (enteredAmount > remainingAmount) {
        Swal.fire({
            title: 'Error!',
            text: 'The entered amount exceeds the remaining amount.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    } else {
        // Send the form data using AJAX
        var formData = new FormData(this);

        fetch('{{ url('purchase/update', $purchases->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the response for debugging
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message, // Display the server message
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: 'red',
                    customClass: {
                        confirmButton: 'btn btn-success' // Bootstrap success button class
                    }
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message, // Display the server error message
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-danger' // Bootstrap danger button class
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log the error for debugging
            Swal.fire({
                title: 'Error!',
                text: 'There was an error updating the purchase.',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger' // Bootstrap danger button class
                }
            });
        });
    }
});
</script>
<script>
function increaseValue() {
    var value = parseInt(document.getElementById('counter').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('counter').value = value;
}

function decreaseValue() {
    var value = parseInt(document.getElementById('counter').value, 10);
    value = isNaN(value) ? 0 : value;
    value = value > 0 ? value - 1 : 0;
    document.getElementById('counter').value = value;
}
</script>
</body>
</html>
