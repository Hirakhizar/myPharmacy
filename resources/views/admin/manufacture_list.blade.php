<!-- resources/views/manufacturers/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.head')
</head>
<body>
    <div class="wrapper">
        @include('admin.sidebar')

        <div class="main-panel">
            @include('admin.main_header')

            <div class="container mt-2 ml-5">
                <div class="row mt-5 ml-5 w-100 d-flex justify-content-center">
                    <div class="card my-5 w-75">
                        <div class="card-body">
                            <h2>Manufacturers</h2>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Balance</th>
                                        <th>Address</th>

                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($manufacturers as $manufacturer)
                                        <tr>
                                            <td>{{ $manufacturer->id }}</td>
                                            <td>{{ $manufacturer->company_name}}</td>
                                            <td>{{ $manufacturer->email }}</td>
                                            <td>{{ $manufacturer->phone }}</td>
                                            <td>{{ $manufacturer->balance }}</td>
                                            <td><b>Country </b> {{ $manufacturer->country }}
                                            <br><b> City</b> : {{ $manufacturer->city }}
                                            <br><b>State</b> : {{ $manufacturer->state }}</td>
                                            <td>{{ $manufacturer->status }}</td>
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
