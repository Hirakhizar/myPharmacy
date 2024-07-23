<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<body>
<div class="wrapper">
    @include('admin.sidebar')

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container mt-2 ml-5">
            <div class="row mt-5 ml-5 w-100 d-flex justify-content-center">
                <div class="card my-5 w-75">
                    <form id="medicineForm" action="{{ url('medicine/update' ,['id'=>$medicine->id] ) }}" method="POST">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3 form-group">
                                <h2>Update Medicine</h2>
                                <p>Update the fields below.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 mt-5">
                                    <span class="d-flex justify-content-end mt-5"> <a href={{url('/medicine/list' )}} class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> Back</a></span>
                            </div>
                             </div>
                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="name"><b>Medicine Name</b></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $medicine->name }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="generic_name"><b>Generic Name</b></label>
                                <input type="text" class="form-control" id="generic_name" name="generic_name" placeholder="Generic Name" value="{{ $medicine->generic_name }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sku"><b>SKU</b></label>
                                <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU" value="{{ $medicine->sku }}" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="weight"><b>Weight</b></label>
                                <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight" value="{{ $medicine->weight }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="category_id"><b>Category</b></label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="" disabled>Select Category</option>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}" {{ $medicine->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="manufacturer_id"><b>Manufacturer</b></label>
                                <select class="form-control" name="manufacturer_id" id="manufacturer_id" required>
                                    <option value="" disabled>Select Manufacturer</option>
                                    @foreach ($manufactures as $manu)
                                    <option value="{{ $manu->id }}" {{ $medicine->manufacturer_id == $manu->id ? 'selected' : '' }}>
                                        {{ $manu->company_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="price"><b>Price</b></label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Price" value="{{ $medicine->price }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="manufacturer_price"><b>Manufacturer Price</b></label>
                                <input type="number" class="form-control" id="manufacturer_price" name="manufacturer_price" placeholder="Manufacturer Price" value="{{ $medicine->manufacturer_price }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="stock"><b>Stock (box)</b></label>
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock" value="{{ $medicine->stock }}" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 form-group">
                                <label for="expire_date"><b>Expire Date</b></label>
                                <input type="date" class="form-control" id="expire_date" name="expire_date" value="{{ $medicine->expire_date }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="status"><b>Status</b></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="" disabled>Select Status</option>
                                    <option value="low" {{ $medicine->status == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="avaliable" {{ $medicine->status == 'avaliable' ? 'selected' : '' }}>Available</option>
                                    <option value="out of stock" {{ $medicine->status == 'out of stock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 form-group">
                                <label for="description"><b>Medicine Details</b></label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ $medicine->description }}</textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3 mb-5 form-group">
                                <button type="submit" class="btn btn-success">Update Medicine</button>
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

    fetch('{{ url('medicine/update/' . $medicine->id) }}', {
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
            text: 'There was an error updating the medicine.',
            icon: 'error',
            confirmButtonText: 'OK',
              customClass: {
                    confirmButton: 'btn btn-danger' // Bootstrap success button class
                }
        });
    });
});
</script>
</body>
</html>
