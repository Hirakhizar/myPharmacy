<!DOCTYPE html>
<html lang="en">
@include('admin.head')
<body>
<div class="wrapper">
    @include('admin.sidebar')

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container form-container">
            <div class="row mt-5 w-100 d-flex justify-content-center">
                <div class="card my-5 w-100">
                    <h3 style="color: #7172b9;text-align: center;margin:20px">Your Cart</h3>
                    <table class="table table-bordered" >
                        <thead>
                            <tr >
                                <th  style="color: #7172b9">Medicine Name</th>
                                <th  style="color: #7172b9">Category</th>
                                <th  style="color: #7172b9">Price</th>
                                <th  style="color: #7172b9">User</th>
                                <th  style="color: #7172b9">Quantity</th>
                                <th  style="color: #7172b9">Total price</th>
                                <th  style="color: #7172b9">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalprice = 0;
                            @endphp
                            @foreach($purchases as $pur)
                                <tr>
                                    @php
                                        $med = $medicines->firstWhere('id', $pur->medicine_id);
                                        $use = $user->id == $pur->user_id ? $user : null; // Assuming $user is the currently authenticated user
                                        $total = $pur->quantity * $med->price;
                                        $totalprice += $total;
                                    @endphp
                                    <td>{{ $med->name }}</td>
                                    <td>{{ $med->category->name }}</td>
                                    <td>{{ $med->price }} Rs/-</td>
                                    <td>{{ $use ? $use->name : 'N/A' }}</td>
                                    <td>{{ $pur->quantity }}</td>
                                    <td>{{ $total }} Rs/-</td>
                                    <td><button type="button" class="btn btn-danger "  ><a href="{{url('remove',$pur->id)}}" onclick="return confirm('Are you sure to remove this medicine ?')" style="color: white">Delete</a></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>

                        <h4><b style="color: #7172b9">Total Price :</b>{{ $totalprice }} Rs/-</h3>


                    <div class="row mt-3">
                        <div class="col-md-3 mb-5 form-group">
                            <button type="button" class="btn "  style="background-color: #7172b9; color: white"><a href="{{url('/confirm')}}" style="color: white">Confirm Order</a></button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Purchaser Modal -->

<script>
    function confirmOrder() {
    Swal.fire({
        title: 'Confirm Order',
        html: `
            <input id="swal-input1" class="swal2-input" placeholder="Name">
            <input id="swal-input2" class="swal2-input" placeholder="Email">
            <input id="swal-input3" class="swal2-input" placeholder="Address">
            <input id="swal-input4" class="swal2-input" placeholder="Phone Number">
        `,
        focusConfirm: false,
        preConfirm: () => {
            return {
                name: document.getElementById('swal-input1').value,
                email: document.getElementById('swal-input2').value,
                address: document.getElementById('swal-input3').value,
                phone: document.getElementById('swal-input4').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let purchaserData = result.value;
            fetch('{{ url('/purchase/confirm') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    purchaser_name: purchaserData.name,
                    purchaser_email: purchaserData.email,
                    purchaser_address: purchaserData.address,
                    purchaser_phone: purchaserData.phone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'There was an error confirming the order.', 'error');
            });
        }
    });
}

function submitOrder() {
    const formData = new FormData(document.getElementById('purchaserForm'));

    fetch('{{ url('/cart/confirm') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ url("/cart/receipt") }}';
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'There was an error confirming the order.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}
</script>

</body>
</html>
