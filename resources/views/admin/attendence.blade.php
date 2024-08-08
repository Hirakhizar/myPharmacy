<!DOCTYPE html>
<html lang="en">
{{-- head --}}
@include('admin.head')
<style>
  /* Your existing styles */
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
        <!-- Add Attendance Form -->
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
                        <label class="bmd-label-floating">Member</label>
                        <select name="member_id" id="" class="form-control">
                          <option value="" disabled selected>Select Member</option>
                          @foreach ($members as $member)
                          <option value="{{ $member->id }}">{{ $member->first_name.' '.$member->last_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Date</label>
                        <input type="date" class="form-control" id="dateInput" name="date">
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
        <!-- End Add Attendance Form -->

        <!-- Attendance List -->
        <div class="row mt-4 w-100 container">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Attendance List</h4>
              </div>
              <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ url('member/attendence') }}">
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label for="filter-start-date" class="bmd-label-floating">Start Date</label>
                      <input type="date" id="filter-start-date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                      <label for="filter-end-date" class="bmd-label-floating">End Date</label>
                      <input type="date" id="filter-end-date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 mt-4">
                      <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                  </div>
                </form>
                <!-- End Filter Form -->

                <!-- Attendance Table -->
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
                          @foreach($attendence as $record)
                          <tr>
                            @php
                            $stayHours = $record->stay_time ? floor($record->stay_time / 3600) : 0;
                            $stayMinutes = $record->stay_time ? floor(($record->stay_time % 3600) / 60) : 0;
                            @endphp
                            <td>{{ $record->members->first_name }}</td>
                            <td>{{ $record->date }}</td>
                            {{-- <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($record->sign_in)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->sign_out)->format('h:i A') }}</td>
                            <td>{{ $stayHours }} hr {{ $stayMinutes }} min</td>
                            <td>
                              <div class="dropdown">
                                <i class="fas fa-ellipsis-h dropdown-toggle" id="dropdownMenuButton{{ $record->id }}" onclick="toggleDropdown({{ $record->id }})"></i>
                                <div class="dropdown-menu" id="dropdownMenu{{ $record->id }}" style="display: none;">
                                  <a class="dropdown-item text-success" href="{{ url('member/attendece/edit', ['id' => $record->id]) }}">
                                    <i class="fas fa-edit"></i> Edit
                                  </a>
                                  <a class="dropdown-item text-danger" href="{{ url('member/attendece/delete', ['id' => $record->id]) }}" onclick="confirmDeletion({{ $record->id }}); return false;">
                                    <i class="fas fa-trash"></i> Delete
                                  </a>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="pagination mt-3 d-flex justify-content-center">
                        {{ $attendence->links('pagination::bootstrap-5') }}
                    </div>
                    </div>
                  </div>
                </div>
                <!-- End Attendance Table -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Attendance List -->
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

    document.addEventListener('DOMContentLoaded', function() {
      // Set the default date to today
      const dateInput = document.getElementById('dateInput');
      const today = new Date().toISOString().split('T')[0];
      dateInput.value = today;

      // Set the default time to the current time
      const timeInput = document.querySelector('input[name="sign_in"]');
      const now = new Date();
      const hours = now.getHours().toString().padStart(2, '0');
      const minutes = now.getMinutes().toString().padStart(2, '0');
      timeInput.value = `${hours}:${minutes}`;
    });
  </script>
</body>
</html>
