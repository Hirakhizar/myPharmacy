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
                        <h2 class="text" style="color:#7172b9;">Pyment Information</h2>
                        <p class="text-muted">List of all your payments.</p>
                    </div>
                </div>
                <div class="search-container">
                    <div class="row" style="color: #7172b9">
                        <div class="col-md-6">
                            <h4>Search Medicines</h4>
                            <input type="date" class="form-control" id="searchDateInput" placeholder="Search by Date and Time">
                        </div>
                    </div>
                </div>
                <div class="card my-5 w-100">
                    <div class="card-body" style="background-color: #f1f1f1; border-radius: 8px;  border: 1px solid #ccc; ">
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Invoice</th>
                                        <th>Payment Method</th>
                                        <th>Recieved Amount</th>

                                        <th>Date</th>

                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody id="medicineTableBody">
                                    @foreach ($payments as $order)
                                    <tr>

                                        <td>{{$order->invoice}}</td>
                                        <td>{{$order->method}} </td>
                                        <td>{{$order->amount}} Rs/-</td>

                                        <td>{{$order->date}}</td>

                                        <td><a href="{{url('payment/edit',$order->id)}}"><i class="fas fa-edit text-warning"></i></a></td>
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
        const dateText = row.cells[4].textContent; // Adjust the index to match the date column
        const rowDate = new Date(dateText);

        // Check if the date in the row matches the filter date
        row.style.display = (isNaN(filterDate.getTime()) || rowDate.toDateString() === filterDate.toDateString()) ? '' : 'none';
    });
});


</script>
