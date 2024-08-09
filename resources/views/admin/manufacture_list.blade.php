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
              <h2 class="mt-3"> Manufacturers Lists</h2>
              <p>You have total {{  $total}} Manufacturers in Pharmacy.
                <span class="d-flex justify-content-end">
                  <a href="{{ route('manufacture-form') }}" class='btn btn-success'>
                    <i class="fas fa-plus mx-3"></i> Add Manufacturer
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
                    <th>Address</th>
                    <th>Balance</th>

                    <th>Status</th>
                    <th><i class='fas fa-ellipsis-h'></i></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($manufacturers as $manufacturer)
                  <tr>
                    <td>{{ $manufacturer->id }}</td>
                    <td><h6>{{ $manufacturer->company_name }}<br></h6>{{ $manufacturer->email }}</td>
                    <td>{{ $manufacturer->phone }}</td>
                    <td>City: {{ $manufacturer->city }}<br>
                      State : {{ $manufacturer->state }}<br>
                    Country : {{$manufacturer->country}}</td>
                    <td>{{ number_format($manufacturer->balance )}} Rs/-</td>
                    {{-- <td> <a href="{{route('manufacture.payment',$manufacturer->id)}}" class="btn btn-secondary">recieved</a></td> --}}
                    <td>{{ $manufacturer->status }}</td>
                    <td>
                      <div class="dropdown">
                        <i  class=" dropdown-toggle" id="dropdownMenuButton{{ $manufacturer->id }}" onclick="toggleDropdown({{ $manufacturer->id }})"><b>...</b></i>
                        <div class="dropdown-menu" id="dropdownMenu{{ $manufacturer->id }}" style="display: none;">
                          <a class="dropdown-item text-warning" href="{{ url('/manufacturer/edit',['id'=>$manufacturer->id]) }}">
                            <i class="fas fa-edit text-warning"></i> Edit
                          </a>
                          <a class="dropdown-item text-danger" href="{{ url('/manufacturer/delete',['id'=>$manufacturer->id]) }}" onclick="confirmDeletion({{ $manufacturer->id }})">
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
