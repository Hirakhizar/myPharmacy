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
                        <h2 class="text" style="color:#7172b9;">Add Expences</h2>
                        <p class="text-muted">Add your expneces here</p>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                       
                        <form action="{{ url('expenses/add') }}" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-4 form-group">
                                    <label for="method"><b style="color:#7172b9;">Category</b></label>
                                    <select class="form-control" id="method" name="category" required>
                                        <option></option>
                                        @foreach ($categories as $category )
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        
                                      
                                    </select>
                                </div>
                               
                                <div class="col-md-4 form-group">
                                    <label for="method"><b style="color:#7172b9;">SubCategory</b></label>
                                    <select class="form-control" id="method" name="subCategory" required>
                                        <option></option>
                                        @foreach ($subcategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        
                                      
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date"><b style="color:#7172b9;">Date</b></label>
                                    <input type="date" class="form-control" id="dateInput" name="date" placeholder="" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="amount"><b style="color:#7172b9;">Amount</b></label>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="date"><b style="color:#7172b9;">Description</b></label>
                                    <input type="text" class="form-control" id="dateInput" name="head" placeholder="" required>
                                </div>
                               
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 mb-5 form-group">
                                    <button type="submit" class="btn btn-secondary">Add Expenses</button>
                                    <a href="{{ url('/expenses/show') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </form>
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
