<!DOCTYPE html>
<html lang="en">
 {{-- head --}}
 @include('admin.head')
 <style>
 .counter {
            display: flex;
            align-items: center;
        }
        .counter button {
            width: 30px;
            height: 30px;
        }
        .counter input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
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
         <div class="card my-5 w-75">

          <form id="medicineForm" action='{{ url('add/medicine') }}' method='POST'>
          @csrf
          <div class="row mt-3">
               <div class="col-md-6 mb-3 form-group">

           <h2>Add Medicine</h2>
           <p>You can add a medicine by fil these field.</p>
             </div>

             </div>


            <div class="row mt-3">
               <div class="col-md-4 form-group">

                  <label for="name"><b>Medicine Name</b></label>
              <input type="text" class="form-control " id="name" name="name" placeholder="Name">

             </div>
             <div class="col-md-4 form-group">

              <label for="Generic name"><b>Generic name</b></label>
              <input type="text" class="form-control " id="Generic name" name="Generic name" placeholder="Generic name">

             </div>
              <div class="col-md-4 form-group">

              <label for="SKU"><b>SKU</b></label>
              <input type="text" class="form-control" id="SKU" name="SKU" placeholder="SKU">

             </div>
            </div>
               <div class="row mt-3">
               <div class="col-md-4 form-group">

              <label for="Weight"><b>Weight</b></label>
              <input type="text" class="form-control" id="Weight" name="Weight" placeholder= " Weight">

             </div>
             <div class="col-md-4 form-group">

              <label for="purchased_item"><b>Category</b></label>
              <select class="form-control" name="Category" id="Category">
                <option value="Category" name="Category" disabled selected>Select Category</option>
              </select>
             </div>
              <div class="col-md-4 form-group">
                <label for="Manufacturer"><b>Manufacturer</b></label>
                <select class="form-control" name="Manufacturer" id="Manufacturer" >
                  <option value="Manufacturer" name="Manufacturer" disabled selected>Select Manufacturer</option>
                </select>
             </div>
             </div>

            <div class="row mt-3">
               <div class="col-md-4 form-group">
              <label for="price"><b>Price</b></label>
              <input type="number" class="form-control" id="price" name="price" placeholder="price">

             </div>
             <div class="col-md-4 form-group">
                <label for="Manufacturer Price"><b>Manufacturer Price</b></label>
                <input type="Manufacturer Price" class="form-control" id="Manufacturer Price" name="manuPrice" placeholder="Manufacturer Price">

              </div>
             <div class="col-md-4 form-group">
                 <label for="status"><b>Stock (box)</b></label>
                 <div class="counter">
                    <button type="button" class="form-control" onclick="increaseValue()">+</button>
                    <input type="text" class="form-control" id="counter" value="0" readonly>
                    <button type="button"class="form-control"  onclick="decreaseValue()">-</button>
                </div>

             </div>

            </div>

            <div class="row mt-3">
                <div class="col-md-4 form-group">
               <label for="date"><b>Exprie Date</b></label>
               <input type="date" class="form-control" id="date" name="date" placeholder="Exprie Date">

              </div>

              <div class="col-md-4 form-group">
                  <label for="status"><b>Status</b></label>
               <select class="form-control" id="status" placeholder="Status" value="status" name="status">
                <option name="status" value="status"></option>
                 <option name="status" value="active" >Active</option>
                 <option name="status" value="inactive" >Inactive</option>
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

            <button type="submit" class="btn btn-success ">add Medicine</button>

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
