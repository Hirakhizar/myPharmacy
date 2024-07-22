<!DOCTYPE html>
<html lang="en">
 {{-- head --}}
 @include('admin.head')
 <style>

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
         <div class="row mt-5 ml-5 w-100 d-flex justify-content-center">
         <div class="card my-5 w-75 ">

          <form id="customerForm" action='{{ url('add/customer') }}' method='POST'>
          @csrf
          <div class="row mt-3">
               <div class="col-md-6 mb-3 form-group">

           <h2>Add Customer</h2>
           <p>You can add a customer by fil these field.</p>
             </div>

             </div>


             <div class="row mt-3">
               <div class="col-md-4 form-group">

                  <label for="name">Name</label>
              <input type="text" class="form-control " id="name" name="name" placeholder="Name">

             </div>
             <div class="col-md-4 form-group">

              <label for="phone">Phone</label>
              <input type="tel" class="form-control " id="phone" name="phone" placeholder="Phone no">

             </div>
              <div class="col-md-4 form-group">

              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">

             </div>
             </div>
               <div class="row mt-3">
               <div class="col-md-4 form-group">

              <label for="purchased_item">Address</label>
              <input type="text" class="form-control" id="purchased_item" name="address" placeholder= " Address">

             </div>
             <div class="col-md-4 form-group">

              <label for="purchased_item">Purchased Item</label>
              <input type="text" class="form-control" id="purchased_item" name="purchased_item" placeholder="Purchased item">

             </div>
              <div class="col-md-4 form-group">

              <label for="purchased_quantity">Purchased Quantity</label>
              <input type="number" class="form-control" id="purchased_quantity" name="qty" placeholder="Purchased quantity">

             </div>
             </div>

                 <div class="row mt-3">
               <div class="col-md-6 form-group">
 <label for="amount">Amount</label>
              <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount">

             </div>
             <div class="col-md-6 form-group">
                 <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
               <option value=""></option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
             </div>

             </div>



     <div class="row mt-3">
               <div class="col-md-12 form-group">

              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>

             </div>

             </div>

 <div class="row mt-3">
               <div class="col-md-3 mb-5 form-group">

            <button type="submit" class="btn btn-success ">add Customer</button>

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
    <!--   Core JS Files   -->
 @include('admin.scripts')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
  document.getElementById('customerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Send the form data using AJAX
    var formData = new FormData(this);

    fetch('{{ url('add/customer') }}', {
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
            text: 'There was an error adding the customer.',
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
