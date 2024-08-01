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
      <div class="container mt-5 ">
        <div class="row">
          <div class="col-11 container mt-3">
            <div class="p-4">
              <h2 class="mt-3">Members Lists</h2>
              <p>You have total {{$totalmember}} members in Pharmacy.
                <span class="d-flex justify-content-end">
                  <a href="{{ url('members/add') }}" class='btn btn-success'>
                    <i class="fas fa-plus mx-3"></i> Add members
                  </a>
                </span>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-11 container">
            <div class='card container'>
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Desiganetion</th>
                     <th>Status</th>
                    <th><i class='fas fa-ellipsis-h'></i></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $member)
                  <tr>
                    <td>{{ $member->id }}</td>
                    <td><h6>{{ $member->first_name }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->designation }}</td>
                    <td>{{ $member->status }}</td>

                    <td>
                      <div class="dropdown">
                        <i class="fas fa-ellipsis-h dropdown-toggle" id="dropdownMenuButton{{ $member->id }}" onclick="toggleDropdown({{ $member->id }})"></i>
                        <div class="dropdown-menu" id="dropdownMenu{{ $member->id }}" style="display: none;">
                          <a class="dropdown-item text-success" href="{{ url('/member/edit',['id'=>$member->id]) }}">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <a class="dropdown-item text-danger" href="{{ url('/member/delete',['id'=>$member->id]) }}" onclick="confirmDeletion({{ $member->id }})">
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

    function confirmDeletion(customerId) {
      Swal.fire({
        title: 'Are you sure To Delete Customer?',
        text: 'You will not be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          deleteCustomer(customerId);
        }
      });
    }


  </script>
</body>
</html>
