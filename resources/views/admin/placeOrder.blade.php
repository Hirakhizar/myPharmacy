<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<style>
    body {
        background-color: #f7f9fc;
        font-family: Arial, sans-serif;
    }
    .wrapper {
        background-color: #ffffff;
    }
    .main-panel {
        background-color: #f7f9fc;
    }
    .form-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
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
    .counter {
        display: flex;
        align-items: center;
    }
    .counter button {
        width: 35px;
        height: 35px;
        border: 1px solid #7172b9;
        background-color: #7172b9;
        color: #ffffff;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
    }
    .counter button:hover {
        background-color: #2A2F5B;
        border-color: #2A2F5B;
    }
    .counter input {
        width: 50px;
        text-align: center;
        margin: 0 5px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px;
    }
    .table-container {
        margin-top: 20px;
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
    .btn-primary {
        background-color: #7172b9;
        border-color: #7172b9;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background-color: #7172b9;
        border-color: #7172b9;
    }
    .btn-info {
        background-color: #7172b9;
        border-color: #7172b9;
        border-radius: 5px;
    }
    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
    }
    .btn-block {
        display: block;
        width: 100%;
        text-align: center;
    }
    .text-primary {
        color: #2A2F5B;
    }
    .text-muted {
        color: #6c757d;
    }
</style>
<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container form-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 form-group" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;">Sale Medicine</h2>
                        <p class="text-muted">Select medicines and add them to the cart.</p>
                    </div>
                </div>
                <div class="search-container">
                    <div class="row" style="color: #7172b9">
                        <div class="col-md-6">
                            <h4>Search Medicines</h4>
                            <input type="text" class="form-control" id="searchMedicineInput" placeholder="Search by name">
                        </div>

                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="medicineTableBody">
                                    @foreach ($medicines as $medicine)
                                    <tr data-id="{{ $medicine->id}}">
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->category->name }}</td>
                                        <td>{{ $medicine->price }}</td>

                                        <td>
                                            <div class="counter">
                                                <button type="button" onclick="decreaseValue({{ $medicine->id }})">-</button>
                                                <input type="number" id="counter_{{ $medicine->id }}" name="quantity[{{ $medicine->id }}]" value="1" readonly>
                                                <button type="button" onclick="increaseValue({{ $medicine->id }})">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ url('cart/add', ['id'=>$medicine->id]) }}" method="POST" id="form_{{ $medicine->id }}">
                                                @csrf
                                                <input type="hidden" name="quantity" id="hidden_quantity_{{ $medicine->id }}" value="0">
                                                <button type="button" onclick="submitForm({{ $medicine->id }})" class="btn" style="background-color: #7172b9; color: white">Add to Cart</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3 mb-5 form-group">
                                <a href="{{ url('/cart/view2') }}" class="btn btn-block" style="background-color: #7172b9; color: white">View Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
        @include('admin.custom')
    </div>
    @include('admin.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function increaseValue(medicineId) {
            const counter = document.getElementById('counter_' + medicineId);
            let value = parseInt(counter.value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            counter.value = value;
        }

        function decreaseValue(medicineId) {
            const counter = document.getElementById('counter_' + medicineId);
            let value = parseInt(counter.value, 10);
            value = isNaN(value) ? 0 : value;
            value = value > 0 ? value - 1 : 0;
            counter.value = value;
        }

        function submitForm(medicineId) {
            const counter = document.getElementById('counter_' + medicineId);
            const hiddenQuantity = document.getElementById('hidden_quantity_' + medicineId);
            const form = document.getElementById('form_' + medicineId);

            hiddenQuantity.value = counter.value;
            if (counter.value > 0) {
                form.submit();
            } else {
                Swal.fire('Please select a quantity greater than zero.');
            }
        }

        document.getElementById('searchMedicineInput').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#medicineTableBody tr');

            rows.forEach(row => {
                const medicineName = row.cells[0].textContent.toLowerCase();
                row.style.display = medicineName.includes(filter) ? '' : 'none';
            });
        });


        </script>

</body>
</html>
