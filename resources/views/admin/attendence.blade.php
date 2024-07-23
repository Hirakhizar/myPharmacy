<!DOCTYPE html>
<html lang="en">
 {{-- head --}}
 @include('admin.head')
 <style>
  .dropdown-menu {
    position: absolute;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: .25rem;
    box-shadow: 0 0 .125rem rgba(0, 0, 0, .075);
    z-index: 1000;
  }
  .dropdown-item {
    padding: .5rem 1rem;
    display: block;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    background-color: transparent;
    border: 0;
    cursor: pointer;
  }
  .dropdown-item:hover {
    background-color: #f8f9fa;
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
        <div class="container w-100">
          <div class="row mt-4 w-100 container">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Attendance</h4>
                </div>
                <div class="card-body">
                  <h5>Add Attendance</h5>
                  <form action="{{ url('member/attendece/add') }}" method="post" id="attendenceForm">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Member Name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date</label>
                          <input type="date" class="form-control" name="date">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Sign-in Time</label>
                          <input type="time" class="form-control" name="sign_in">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-success ml-2">Save Information</button>
                      </div>
                    </div>
                 </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4 w-100 container">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Attendance List</h4>
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label for="filter-start-date" class="bmd-label-floating">Start Date</label>
                      <input type="date" id="filter-start-date" class="form-control">
                    </div> <!-- .col-md-6 -->
                    <div class="col-md-4">
                      <label for="filter-end-date" class="bmd-label-floating">End Date</label>
                      <input type="date" id="filter-end-date" class="form-control">

                    </div>
                     <div class="col-md-4  mt-3">
                
 <button type="submit" class="btn btn-primary">Filter</button>
                    </div> 
                 
                  </div> 
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                          
                              <th>Member</th>
                              <th>Date</th>
                              <th>Sign-in</th>
                              <th>Sign-out</th>
                              <th>Stay Time</th>
                              <th><i class="fas fa-ellipsis-h"></i></th>
                            </tr>
                          </thead>
                          <tbody>
                      @foreach($attendence as $attendence)
                            <tr>
                       
      @php
  $stayHours = $attendence->stay_time ? floor($attendence->stay_time / 3600) : 0;
  $stayMinutes = $attendence->stay_time ? floor(($attendence->stay_time % 3600) / 60) : 0;
@endphp
           
  <td>{{ $attendence->members->first_name }}</td>
  <td>{{ \Carbon\Carbon::parse($attendence->date)->format('d/m/Y') }}</td>
  <td>{{ \Carbon\Carbon::parse($attendence->sign_in)->format('h:i A') }}</td>
  <td>{{ \Carbon\Carbon::parse($attendence->sign_out)->format('h:i A') }}</td>
 <td>{{ $stayHours }} hr {{ $stayMinutes }} min</td>
  <td>
                           
  <div class="dropdown">
    <i class="fas fa-ellipsis-h dropdown-toggle" id="dropdownMenuButton{{ $attendence->id }}" onclick="toggleDropdown({{ $attendence->id }})"></i>
    <div class="dropdown-menu" id="dropdownMenu{{ $attendence->id }}" style="display: none;">
      <a class="dropdown-item text-success" href="{{ url('member/attendece/edit', ['id' => $attendence->id]) }}">
        <i class="fas fa-edit"></i> Edit
      </a>
      <a class="dropdown-item text-danger" href="{{ url('member/attendece/delete', ['id' => $attendence->id]) }}" onclick="confirmDeletion({{ $attendence->id }}); return false;">
        <i class="fas fa-trash"></i> Delete
      </a>
    </div>
  </div>
</td>

                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div> <!-- .col-12 -->
                </div>
              </div>
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
    function toggleDropdown(id) {
      var dropdownMenu = document.getElementById('dropdownMenu' + id);
      var isDisplayed = dropdownMenu.style.display === 'block';
      // Hide all dropdowns
      document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
      // Toggle the current dropdown
      dropdownMenu.style.display = isDisplayed ? 'none' : 'block';
    }

    // Optional: Hide dropdowns when clicking outside
    window.onclick = function(event) {
      if (!event.target.matches('.dropdown-toggle')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
      }
    }

    function confirmDeletion(attendenceId) {
  Swal.fire({
    title: 'Are you sure you want to delete this attendance record?',
    text: 'You will not be able to revert this!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      // Redirect to the delete URL
      window.location.href = '{{ url('member/attendece/delete') }}/' + attendenceId;
    }
  });
}
   document.getElementById('attendenceForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Send the form data using AJAX
    var formData = new FormData(this);

    fetch('{{ url('member/attendece/add') }}', {
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
            text: 'There was an error adding the attendence.',
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
