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
  <span class="d-flex justify-content-end ml-2 mt-5"> <a href={{url('members/show')}} class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Back</a></span>
        </div>
         </div>
         <div class="row ml-5 w-100 d-flex justify-content-center">
         <div class="card my-5 w-75 ">

          <form id="customerForm" action='{{  url('member/update', ['id' => $member->id]) }}' method='POST'>
          @csrf
          <div class="row mt-3">
               <div class="col-md-6 mb-3 form-group">

           <h2>Update Member</h2>
           <p>You can update member's details  by fil these field.</p>
             </div>

             </div>


             <div class="row mt-3">
               <div class="col-md-4 form-group">

                  <label for="name">First Name</label>
              <input type="text" class="form-control " id="name" name="first_name" value={{ $member->first_name }} placeholder="Name">

             </div>
              <div class="col-md-4 form-group">

                  <label for="name">Last Name</label>
              <input type="text" class="form-control " id="name" name="last_name" value={{ $member->last_name }} placeholder="Name">

             </div>
              <div class="col-md-4 form-group">

                  <label for="name">Gender</label>

              <select class="form-control" id="gender" name="gender">
               <option value=""></option>
                <option value="male" {{ $member->gender=='male' ? 'selected' :'' }} >Male</option>
                <option value="female"{{ $member->gender=='female'? 'selected' :'' }}>Female</option>
                <option value="other"{{ $member->gender=='other'? 'selected' :'' }}>other</option>
              </select>

             </div>
             <div class="col-md-4 form-group">

              <label for="phone">Phone</label>
              <input type="tel" class="form-control " id="phone" name="phone" value={{ $member->phone }} placeholder="Phone no">

             </div>
              <div class="col-md-4 form-group">

                  <label for="date">Date of Birth</label>
              <input type="date" class="form-control " id="date" name="date_of_birth" value={{ $member->date_of_birth }} placeholder="">

             </div>
              <div class="col-md-4 form-group">

              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email"value={{ $member->email }}  placeholder="Email">

             </div>
             </div>
               <div class="row mt-3">
               <div class="col-md-4 form-group">

              <label for="purchased_item">Address</label>
              <input type="text" class="form-control" id="purchased_item" name="address" value={{ $member->address }}  placeholder= " Address">

             </div>
             <div class="col-md-4 form-group">

              <label for="purchased_item">Upload Photo</label>
              <input type="file" class="form-control" id="purchased_item" name="image">

             </div>
               <div class="col-md-4 form-group">

           
              <img src="{{ asset('storage/' . $member->photo_path ) }}" alt="Image" class="w-25 h-auto"> 
           

             </div>
             
             

             </div>
                 <div class="row mt-3">
               <div class="col-md-3 form-group">
 <label for="amount">National ID</label>

              <input type="file" class="form-control" id="amount" name="national_id" >

             </div>
             <div class="col-md-3 form-group">
  <img src="{{ asset('storage/' .  $member->national_id ) }}" alt="Image" class="w-50 h-auto">  </div>
               <div class="col-md-3 form-group">
 <label for="amount">Certificates</label>
  
              <input type="file" class="form-control" id="amount" name="certificates" >

             </div>
                 <div class="col-md-3 form-group">
             <img src="{{ asset('storage/' . $member->certificates ) }}" alt="Image" class="w-50 h-auto"> 
             </div>
              <div class="col-md-4 form-group">

                  <label for="datej">Date of Joining</label>
              <input type="date" class="form-control " id="datej" name="date_of_joining" value={{$member->joining_date}}>

             </div>
             <div class="col-md-4 form-group">
                 <label for="status">Status</label>
              <select class="form-control" id="status" name="status" >
               <option value=""></option>
                <option value="active"{{ $member->status=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive"{{ $member->status=='inactive' ? 'selected' : '' }}>Inactive</option>
                 <option value="pending"{{ $member->status=='pending' ? 'selected' : '' }}>Pending</option>
              </select>
             </div>
               <div class="col-md-4 form-group">
                 <label for="status">Designation</label>
              <select class="form-control" id="status" name="designation">
               <option value=""></option>
                <option value="admin" {{ $member->designation=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="manager"  {{ $member->designation=='manager' ? 'selected' : '' }}>Manager</option>
              <option value="pharmacist"  {{ $member->designation=='pharmacist' ? 'selected' : '' }}>Pharmacist</option>
              <option value="accountant" {{ $member->designation=='accountant' ? 'selected' : '' }}>Accountant</option>
              <option value="salesman"  {{ $member->designation=='salesman' ? 'selected' : '' }}>Salesmane</option>
              <option value="cleaner"  {{ $member->designation=='cleaner' ? 'selected' : '' }}>Cleaner</option>
              </select>
             </div>

             </div>



     <div class="row mt-3">
               <div class="col-md-12 form-group">

              <label for="description">Short Biography</label>
              <textarea class="form-control" id="description" name="bio" rows="3" >{{ $member->short_biography }} </textarea>

             </div>

             </div>

 <div class="row mt-3">
               <div class="col-md-3 mb-5 form-group">

            <button type="submit" class="btn btn-success ">Update</button>

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
     event.preventDefault(); // Prevent the form from submitting the traditional way

     // Get the form data
     var formData = new FormData(this);

     // Perform the update operation using fetch
     fetch('{{ url('member/update', ['id' => $member->id]) }}', {
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
         text: 'There was an error updating the Member.',
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
