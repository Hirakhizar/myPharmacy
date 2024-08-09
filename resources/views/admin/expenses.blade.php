<!DOCTYPE html>
<html lang="en">
@include('admin.head')

<style>
    body {
        background-color: #f7f9fc;
        font-family: Arial, sans-serif;
    }
    .wrapper, .main-panel {
        background-color: #ffffff;
    }
    .search-container {
        background-color: #f1f1f1;
        border-radius: 8px;
        padding: 20px;
        margin: 20px;
        border: 1px solid #ccc;
    }
    .search-container h4 {
        margin-bottom: 15px;
    }
    .table-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .table th {
        color: #7172b9;
        border: 1px solid #dee2e6;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .text-primary {
        color: #2A2F5B;
    }
    .text-muted {
        color: #6c757d;
    }
    .no-results {
        text-align: center;
        padding: 20px;
        color: #7172b9;
    }
    .icon-btn {
        border: none;
        background: none;
        cursor: pointer;
    }
</style>

<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container table-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 text-center">
                        <h2 class="text-secondary">Your Expenses</h2>
                        <p class="text-muted">List of all your Expenses.</p>
                        <div class="mb-3  mx-5 d-flex justify-content-end ">
                            <button id="exportButton" class="btn btn-success">Export to Excel</button>
                        </div>
                    </div>
                    
                </div>
                <div class="search-container">
                    <form method="GET" action="{{ url('expenses') }}" class="row">
                        <div class="col-md-3 mb-3">
                            <h4 class='text-secondary'>Search Date</h4>
                            <input type="date" name="order_date" class="form-control" value="{{ request('order_date') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <h4 class='text-secondary'>Category</h4>
                            <select id="category" name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h4 class='text-secondary'>SubCategory</h4>
                            <select id="subcategory" name="subcategory_id" class="form-control">
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-category-id="{{ $subcategory->category_id }}" {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </form>
                </div>
             
                <div class="card my-5 w-100">
                    <div class="card-body">
                        <div class="table-container">
                            <span class="d-flex justify-content-end">
                                <a href="{{ url('expenses/add') }}" class='btn btn-secondary mb-5'>
                                  <i class="fas fa-plus mx-3"></i> Add Expenses
                                </a>
                            </span>
                            @if($expenses->isEmpty())
                                <div class="no-results">
                                    <h4>No matching expenses found</h4>
                                    <p>Please adjust your filters and try again.</p>
                                </div>
                            @else
                                <table class="table table-bordered table-striped">
                                    <span class="text-secondary"><h2>Expenses List</h2></span>

                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date</th>
                                            <th>Category</th>
                                            <th>SubCategory</th>
                                            <th>Amount</th>
                                            <th>Expense Head</th>
                                            <th><i class='fas fa-ellipsis-h'></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderTableBody">
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($expenses as $expense)
                                        <tr>
                                            <td>{{ ++$count }}</td>
                                            <td>{{ $expense->date }}</td>
                                            <td>{{ $expense->category->name }}</td>
                                            <td>{{ $expense->subcategory->name }}</td>
                                            <td>{{number_format( $expense->amount)}} Rs/-</td>
                                            <td>{{ $expense->description }}</td>
                                            <td>
                                                <a href="{{ url('expenses/edit', ['id' => $expense->id]) }}" class="icon-btn" data-toggle="tooltip" data-placement="top" title="Edit me" >
                                                    <i class="fas fa-edit text-warning"></i>
                                                </a>
                                                <button onclick="confirmDeletion({{ $expense->id }})" class="icon-btn" data-toggle="tooltip" data-placement="top" title="Delete me">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination mt-3 d-flex justify-content-center">
                                    {{ $expenses->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
        @include('admin.custom')
    </div>
    @include('admin.scripts')
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    function confirmDeletion(expenseId) {
        Swal.fire({
            title: 'Are you sure you want to delete this expense?',
            text: 'You will not be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/expenses/delete/${expenseId}`;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Cancelled',
                    'The expense has not been deleted.',
                    'error'
                );
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category');
        const subcategorySelect = document.getElementById('subcategory');
        const subcategoryOptions = Array.from(subcategorySelect.options);

        function filterSubcategories() {
            const selectedCategory = categorySelect.value;

            // Reset subcategory dropdown
            subcategorySelect.innerHTML = '<option value="">Select SubCategory</option>';

            // Filter and show relevant subcategories
            subcategoryOptions.forEach(option => {
                if (option.getAttribute('data-category-id') === selectedCategory || option.value === '') {
                    subcategorySelect.appendChild(option);
                }
            });
        }

        // Filter subcategories when category is changed
        categorySelect.addEventListener('change', filterSubcategories);

        // Initial filter to set subcategories based on initial category value
        filterSubcategories();

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

        // Initialize Bootstrap tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    });

    document.getElementById('exportButton').addEventListener('click', function() {
        // Get table data
        let table = document.querySelector('.table');
        let wb = XLSX.utils.table_to_book(table, { sheet: "Expenses" });
        let wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });

        // Create a blob and download
        let blob = new Blob([wbout], { type: "application/octet-stream" });
        let link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'expenses_list.xlsx';
        link.click();
    });
</script>
