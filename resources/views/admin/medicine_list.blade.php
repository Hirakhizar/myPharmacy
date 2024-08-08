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
      <div class="container mt-5">
        <div class="row">
          <div class="col-11 container mt-3">
            <div class="p-4">
              <h2 class="mt-3">Medicines Lists</h2>
              <p>You have total {{ $total}}  Medicines in Pharmacy.
                <span class="d-flex justify-content-end">
                  <a href="{{ route('medicine-form') }}" class='btn btn-success'>
                    <i class="fas fa-plus mx-3"></i> Add Medicine
                  </a>
                  <button type="button" class="btn btn-danger mx-3 " onclick="confirmMultipleDeletion()">Delete Selected</button>
             
                </span>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-11 container">
            <div class='card container'>
              <form id="deleteForm" method="POST" action="{{ url('delete-multiple-medicines') }}">
                @csrf
                @method('DELETE')
                <table class="table">
                 
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="selectAll"></th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Generic Name</th>
                      <th>Weight</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Status</th>
                      <th><i class='fas fa-ellipsis-h'></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($medicines as $med)
                    <tr>
                      <td><input type="checkbox" name="ids[]" value="{{ $med->id }}"></td>
                      <td>{{ $med->id }}</td>
                      <td><h6>{{ $med->name }}</h6></td>
                      <td>{{ $med->generic_name }}</td>
                      <td>{{ $med->weight }}mg</td>
                      <td>{{ $med->category->name }}</td>
                      <td>{{ $med->price }} Rs/-</td>
                      <td>{{ $med->stock }}</td>
                      <td>{{ $med->status }}</td>
                      <td>
                        <div class="dropdown">
                          <i class="dropdown-toggle" id="dropdownMenuButton{{ $med->id }}" onclick="toggleDropdown({{ $med->id }})"><b>...</b></i>
                          <div class="dropdown-menu" id="dropdownMenu{{ $med->id }}" style="display: none;">
                            <a class="dropdown-item text-success" href="{{ url('/medicine/edit',['id'=>$med->id]) }}">
                              <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="dropdown-item text-danger" href="{{ url('/medicine/delete',['id'=>$med->id]) }}" onclick="confirmDeletion({{ $med->id }})">
                              <i class="fas fa-trash"></i> Delete
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
               </form>
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

    document.getElementById('selectAll').addEventListener('change', function() {
      var checkboxes = document.querySelectorAll('input[name="ids[]"]');
      for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
      }
    });

    function confirmDeletion(medId) {
      Swal.fire({
        title: 'Are you sure to delete this medicine?',
        text: 'You will not be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          deleteMedicine(medId);
        }
      });
    }

    function confirmMultipleDeletion() {
      Swal.fire({
        title: 'Are you sure to delete selected medicines?',
        text: 'You will not be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete them!',
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('deleteForm').submit();
        }
      });
    }
  </script>
</body>
</html>
