<!DOCTYPE html>
<html lang="en">
 {{-- head --}}
 @include('admin.head')
 <style>
   /* Add any custom styles here */
 </style>
 {{-- end head --}}
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      @include('admin.sidebar')
      <!-- End Sidebar -->

      <div class="main-panel">
        {{-- main-header --}}
        @include('admin.main_header')
        {{-- end main-header --}}
        <div class="container mt-2 ml-5">
        <div class="row">
        <div class="col-md-11 mt-5">
  <span class="d-flex justify-content-end mt-5"> <a href={{url('customer/show' )}} class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Back</a></span>
        </div>
         </div>
          <div class="row ml-5 w-100 d-flex justify-content-center">
            <div class="card my-5 w-75 ">

              <form id="customerForm">
                @csrf
                <div class="row mt-2">
                  <div class="col-md-6 mb-3 form-group">
                    <h2>Update Customer Details</h2>
                    <p>You can update a customer by filling these fields.   </p>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-md-4 form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}">
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}" placeholder="Phone no">
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" placeholder="Email">
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4 form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $customer->address }}" placeholder="Address">
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="purchased_item">Purchased Item</label>
                    <input type="text" class="form-control" id="purchased_item" name="purchased_item" value="{{ $customer->medicine->name }}" placeholder="Purchased item">
                  </div>
                  <div class="col-md-4 form-group">
                    <label for="purchased_quantity">Purchased Quantity</label>
                    <input type="number" class="form-control" id="purchased_quantity" name="qty" value="{{ $customer->purchaced_qty }}" placeholder="Purchased quantity">
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6 form-group">
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" value="{{ $customer->amount }}" placeholder="Amount">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                      <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                      <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12 form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ $customer->description }}</textarea>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-3 mb-5 form-group">
                    <button type="submit" class="btn btn-success">Update</button>

                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        {{-- footer --}}
        @include('admin.footer')
        {{-- end footer --}}
      </div>

      <!-- Custom template | don't include it in your project! -->
      @include('admin.custom')
      <!-- End Custom template -->
    </div>
    <!-- Core JS Files -->
    @include('admin.scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.getElementById('customerForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        // Get the form data
        var formData = new FormData(this);

        // Perform the update operation using fetch
        fetch('{{ url('customer/update', ['id' => $customer->id]) }}', {
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
              confirmButtonColor: '#3085d6',
              customClass: {
                confirmButton: 'btn btn-success' // Bootstrap success button class
              }
            }).then(() => {
              location.reload(); // Reload the page if needed
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: data.message, // Display the server error message
              icon: 'error',
              confirmButtonText: 'OK',
              customClass: {
                confirmButton: 'btn btn-danger' // Bootstrap error button class
              }
            });
          }
        })
        .catch(error => {
          console.error('Error:', error); // Log the error for debugging
          Swal.fire({
            title: 'Error!',
            text: 'There was an error updating the customer.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
              confirmButton: 'btn btn-danger' // Bootstrap error button class
            }
          });
        });
      });
    </script>
  </body>
</html>
