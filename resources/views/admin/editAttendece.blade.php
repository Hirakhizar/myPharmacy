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
            <div class="row">
              <div class="col-md-12 mt-2 mb-2">
                <!-- Optional Header or Breadcrumbs -->
              </div>
            </div>
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Attendance</h4>
              </div>
              <div class="card-body">
                <h5>Update Attendance</h5>
                <form action="{{ url('member/attendece/update',['id'=>$attendence->id]) }}" method="post" id="attendenceForm">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Member</label>
                        <select name="member_id" class="form-control">
                          @foreach ($members as $member)
                            <option value="{{ $member->id }}" {{ $member->id == $attendence->member_id ? 'selected' : '' }}>
                              {{ $member->first_name.' '.$member->last_name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Date</label>
                        <input type="date" class="form-control" name="date" value="{{ $attendence->date }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Sign-in Time</label>
                        <input type="time" class="form-control" name="sign_in" value="{{ $attendence->sign_in }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="bmd-label-floating">Sign-out Time</label>
                        <input type="time" class="form-control" name="sign_out" value="{{ $attendence->sign_out }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mt-2">
                      <button type="submit" class="btn btn-success mx-3">Update</button>
                      <a href="{{ url('member/attendence') }}" class="btn btn-danger">Cancel</a>
                    </div>
                  </div>
                </form>
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
    document.getElementById('attendenceForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form submission

      // Send the form data using AJAX
      var formData = new FormData(this);

      fetch('{{ url('member/attendece/update',['id'=>$attendence->id]) }}', {
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
          text: 'There was an error updating the attendance.',
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
