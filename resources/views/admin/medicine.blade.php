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

        <div class="container mt-2 ml-5">
            <div class="row mt-5 ml-5 w-100 d-flex justify-content-center">
                <div class="card my-5 w-75">
                    <form id="medicineForm" action="{{ url('add/medicine') }}" method="POST">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3 form-group">
                                <h2>Add Medicine</h2>
                                <p>You can add a medicine by filling these fields.</p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="name"><b>Medicine Name</b></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="generic_name"><b>Generic Name</b></label>
                                <input type="text" class="form-control" id="generic_name" name="generic_name" placeholder="Generic Name" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sku"><b>SKU</b></label>
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="weight"><b>Weight</b></label>
                                <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="category_id"><b>Category</b></label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="manufacturer_id"><b>Manufacturer</b></label>
                                <select class="form-control" name="manufacturer_id" id="manufacturer_id" required>
                                    <option value="" disabled selected>Select Manufacturer</option>
                                    @foreach ($manufactures as $manu)
                                    <option value="{{ $manu->id }}">{{ $manu->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="price"><b>Price</b></label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="manufacturer_price"><b>Manufacturer Price</b></label>
                                <input type="number" class="form-control" id="manufacturer_price" name="manufacturer_price" placeholder="Manufacturer Price" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="stock"><b>Stock (box)</b></label>
                                <div class="counter">
                                    <button type="button" class="form-control" onclick="increaseValue()">+</button>
                                    <input type="number" class="form-control" id="counter" name="stock" value="0" readonly>
                                    <button type="button" class="form-control" onclick="decreaseValue()">-</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="expire_date"><b>Expire Date</b></label>
                                <input type="date" class="form-control" id="expire_date" name="expire_date" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="status"><b>Status</b></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="low">Low</option>
                                    <option value="avaliable">Available</option>
                                    <option value="out of stock">Out of Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 form-group">
                                <label for="description"><b>Medicine Details</b></label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3 mb-5 form-group">
                                <button type="submit" class="btn btn-success">Add Medicine</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
  document.getElementById('medicineForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Send the form data using AJAX
    var formData = new FormData(this);

    fetch('{{ url('add/medicine') }}', {
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
                    confirmButton: 'btn btn-danger' // Bootstrap success button class
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error); // Log the error for debugging
        Swal.fire({
            title: 'Error!',
            text: 'There was an error adding the manufacture.',
            icon: 'error',
            confirmButtonText: 'OK',
              customClass: {
                    confirmButton: 'btn btn-danger' // Bootstrap success button class
                }
        });
    });
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
