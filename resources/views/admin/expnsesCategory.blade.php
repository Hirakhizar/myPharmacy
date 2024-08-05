<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
    <style>
        /* Your existing styles */
    </style>
    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container form-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 form-group" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;"> Category/SubCategories</h2>
                        <p class="text-muted">Add Categories and their SubCategories for your Expenses</p>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                       
                        <form action="{{ url('expenses/category/add') }}" method="POST">
                            @csrf
                            <div class="row mt-2">
                                <div class="row mt-1">
                                    <h3 class="text-secondary">Category</h3>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="amount"><b style="color:#7172b9;">Add Category </b></label>
                                    <input type="text" class="form-control" id="amount" name="name" placeholder="Enter amount" required>
                                </div>
                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 mb-5 form-group">
                                    <button type="submit" class="btn btn-secondary">Add</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- subCategories --}}
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                       
                        <form action="{{ url('expenses/subCategory/add') }}" method="POST">
                            @csrf
                            <div class="row mt-2">
                                <div class="row mt-1">
                                    <h3 class="text-secondary">SubCategory</h3>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="amount"><b style="color:#7172b9;">Add SubCategory </b></label>
                                    <input type="text" class="form-control" id="amount" name="name" placeholder="Enter amount" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="method"><b style="color:#7172b9;">Categoires</b></label>
                                    <select class="form-control" id="method" name="category_id" required>
                                        <option></option>
                                        @foreach ($categories as $category )
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                       
                                    </select>
                                </div> 
                                
                            </div>
                            
                           
                            <div class="row mt-3">
                                <div class="col-md-3 mb-5 form-group">
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
{{-- show --}}
<div class="row mt-3">
    <div class="col-md-12 mb-3 form-group" style="text-align: center">
        <h2 class="text" style="color:#7172b9;"> Categories List</h2>
        <p class="text-muted">You can view  all Categories here</p>
    </div>
</div>
                <div class="card my-5 w-100">
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>SubCategory</th>
                                        <th>Category Type</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody id="orderTableBody">
                                    @php
                                        $count=0;
                                    @endphp
                                    @foreach ($subcategories as $sub)
                                    <tr>
                                        <td>{{ ++$count }}</td>
                                        <td>{{ $sub->name }}</td>
                                        <td>{{ $sub->category->name}}</td>
                                        <td><a href="{{ url('expenses/subCategory/remove',['id'=>$sub->id]) }}" class='btn btn-secondary'><b>Remove</b></a></td>
                                   
                                     
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
        @include('admin.custom')
    </div>
    @include('admin.scripts')

    <!-- SweetAlert Notification -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('message'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('message') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            // JavaScript to set the default date
            const dateInput = document.getElementById('dateInput');
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        });
    </script>
</body>
</html>
