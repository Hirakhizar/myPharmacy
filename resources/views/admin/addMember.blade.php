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
        <div class="row">
        <div class="col-md-10 mt-5">
  <span class="d-flex justify-content-end ml-2 mt-5"> <a href={{url('members/show' )}} class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Back</a></span>
        </div>
         </div>
         <div class="row ml-5 w-100 d-flex justify-content-center">
         <div class="card my-5 w-75 ">

          <form id="customerForm" action='{{ url('add/member') }}' method='POST'>
          @csrf
          <div class="row mt-3">
               <div class="col-md-6 mb-3 form-group">

           <h2>Add Member</h2>
           <p>You can add member by fil these field.</p>
             </div>

             </div>


             <div class="row mt-3">
               <div class="col-md-4 form-group">

                  <label for="name">First Name</label>
              <input type="text" class="form-control " id="name" name="first_name" placeholder="Name">

             </div>
              <div class="col-md-4 form-group">

                  <label for="name">Last Name</label>
              <input type="text" class="form-control " id="name" name="last_name" placeholder="Name">

             </div>
              <div class="col-md-4 form-group">

                  <label for="name">Gender</label>

              <select class="form-control" id="gender" name="gender">
               <option value=""></option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>

             </div>
             <div class="col-md-4 form-group">

              <label for="phone">Phone</label>
              <input type="tel" class="form-control " id="phone" name="phone" placeholder="Phone no">

             </div>
              <div class="col-md-4 form-group">

                  <label for="date">Date of Birth</label>
              <input type="date" class="form-control " id="date" name="date_of_birth" placeholder="">

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

              <label for="purchased_item">Upload Photo</label>
              <input type="file" class="form-control" id="purchased_item" name="image">

             </div>
             
             
  <div class="col-md-4 form-group">
                 <label for="status">Designation</label>
              <select class="form-control" id="status" name="designation">
               <option value=""></option>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
              <option value="pharmacist">Pharmacist</option>
              <option value="accountant">Accountant</option>
              <option value="salesmane">Salesmane</option>
              <option value="CLeaner">CLeaner</option>
              </select>
             </div>
             </div>
                 <div class="row mt-3">
               <div class="col-md-4 form-group">
 <label for="amount">National ID</label>
              <input type="file" class="form-control" id="amount" name="national_id" >

             </div>
               <div class="col-md-4 form-group">
 <label for="amount">Certificates</label>
              <input type="file" class="form-control" id="amount" name="certificates" >

             </div>
              <div class="col-md-4 form-group">

                  <label for="datej">Date of Joining</label>
              <input type="date" class="form-control " id="datej" name="date_of_joining">

             </div>
             <div class="col-md-4 form-group">
                 <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
               <option value=""></option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                 <option value="Pending">Pending</option>
              </select>
             </div>

             </div>



     <div class="row mt-3">
               <div class="col-md-12 form-group">

              <label for="description">Short Biography</label>
              <textarea class="form-control" id="description" name="bio" rows="3" ></textarea>

             </div>

             </div>

 <div class="row mt-3">
               <div class="col-md-3 mb-5 form-group">

            <button type="submit" class="btn btn-success ">add Member</button>

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

    fetch('{{ url('add/member') }}', {
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