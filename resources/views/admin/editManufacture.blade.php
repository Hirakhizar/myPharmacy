<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
</head>
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
                        <form id="manufactureForm" method="POST" action="{{url('manufacturer/update/',['id'=>$manufacturer->id])}}">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3 form-group">
                                    <h2>Edit Manufacturer</h2>
                                    <p>You can add a manufacturer by filling in these fields.</p>
                                </div>
                            </div>

                                <div class="col-md-11 mt-5">
                                        <span class="d-flex justify-content-end mt-5"> <a href={{url('/manufacturers/list' )}} class="btn btn-primary">
                                        <i class="fa fa-arrow-left"></i> Back</a></span>
                                </div>

                            <div class="row mt-3">
                                <div class="col-md-4 form-group">
                                    <label for="company_name"><b>Company</b></label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company" value="{{$manufacturer->company_name}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email"><b>Email</b></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="{{$manufacturer->email}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="phone"><b>Phone</b></label>
                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="phone" value="{{$manufacturer->phone}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 form-group">
                                    <label for="balance"><b>Balance</b></label>
                                    <input type="text" class="form-control" id="balance" name="balance" placeholder="balance" value="{{$manufacturer->balance}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="country"><b>Country</b></label>
                                    <input type="text" class="form-control" id="country" name="country" placeholder="country" value="{{$manufacturer->country}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="city"><b>City</b></label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="city"  value="{{$manufacturer->city}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 form-group">
                                    <label for="state"><b>State</b></label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="state"  value="{{$manufacturer->state}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="status"><b>Status</b></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" disabled selected>Select Status</option>
                                        <option value="active" {{ $manufacturer->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{$manufacturer->status == 'active' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 mb-5 form-group">
                                    <button type="submit" class="btn btn-success">Update</button>
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
        document.getElementById('manufactureForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            // Send the form data using AJAX
            var formData = new FormData(this);

            fetch('{{ url('manufacturer/update',  ['id' => $manufacturer->id]) }}',  {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                console.log('Response data:', data); // Log the response for debugging
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message, // Display the server message
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745', // Bootstrap success button color
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message, // Display the server error message
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545', // Bootstrap danger button color
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error); // Log the error for debugging
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error adding the manufacturer: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545', // Bootstrap danger button color
                });
            });
        });
    </script>

</body>
</html>
