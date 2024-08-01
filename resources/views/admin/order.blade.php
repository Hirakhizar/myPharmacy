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
</style>

<body>
    <div class="wrapper">
        @include('admin.sidebar')
        <div class="main-panel">
            @include('admin.main_header')
            <div class="container table-container">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3" style="text-align: center">
                        <h2 class="text" style="color:#7172b9;">Your Orders</h2>
                        <p class="text-muted">List of all your orders.</p>
                    </div>
                </div>
                <div class="search-container">
                    <div class="row" style="color: #7172b9">
                        <div class="col-md-6">
                            <h4>Search Medicines</h4>
                            <input type="date" class="form-control" id="searchDateInput" placeholder="Search by Date and Time">
                        </div>
                        <div class="col-md-6">
                            <h4>Search Manufacturers</h4>
                            <input type="text" class="form-control" id="searchManufacturerInput" placeholder="Search by manufacturer">
                        </div>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px; padding: 20px; border: 1px solid #ccc; margin: 20px">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Manufacturer</th>
                                        <th>Total Amount</th>

                                        <th>Date</th>
                                        <th>status</th>
                                        <th>payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="medicineTableBody">
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{$order->manufacturer}}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>

                                        <td>{{$order->created_at}}</td>
                                        <td>{{$order->status}}</td>
                                        <td><a href="{{route('payment', $order->id)}}" class="btn btn-secondary">recieved</a></td>
                                        <td><a class="btn btn-success" href="{{route('detail',$order->id)}}">detail</a></td>
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
</body>
</html>
<script>
    document.getElementById('searchDateInput').addEventListener('input', function() {
    const filterDate = new Date(this.value);
    const rows = document.querySelectorAll('#medicineTableBody tr');

    rows.forEach(row => {
        const dateText = row.cells[3].textContent; // Adjust the index to match the date column
        const rowDate = new Date(dateText);

        // Check if the date in the row matches the filter date
        row.style.display = (isNaN(filterDate.getTime()) || rowDate.toDateString() === filterDate.toDateString()) ? '' : 'none';
    });
});

        document.getElementById('searchManufacturerInput').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#medicineTableBody tr');

            rows.forEach(row => {
                const manufacturerText = row.cells[1].textContent.toLowerCase();
                row.style.display = manufacturerText.includes(filter) ? '' : 'none';
            });
        });
</script>
