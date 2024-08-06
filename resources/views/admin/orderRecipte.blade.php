<!DOCTYPE html>
<html lang="en">
@include('admin.head')

<body>
<div class="wrapper">
    @include('admin.sidebar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <div class="main-panel">
        @include('admin.main_header')

        <div class="container ">
            <div class="row d-flex justify-content-center p-5 w-75">
                <div class="card mb-2 mt-5 w-50" id="receipt">
                    <div class="card-body">
                        <h2 class="d-flex justify-content-center">Order Receipt</h2>
                      
                        <p class="small"><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p class="small"><strong>Name:</strong> {{ $order->customer }}</p>
                        <p class="small"><strong>Contact:</strong> {{ $order->phone }}</p>

                        <table class="table table-sm small w-100">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Qty</td>
                                    <td>Price</td>
                                    <td>Subtotal</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderitems as $item)
                                    <tr>
                                        <td>{{ $item->medicineItems->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>${{ number_format($item->medicineItems->price) }}</td>
                                        <td>${{ number_format($item->qty * $item->medicineItems->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <p class="small"><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                        <p class="small"><strong>Paid:</strong> ${{ number_format($order->paid, 2) }}</p>
                        <p class="small"><strong>Remaining:</strong> ${{ number_format($order->remaining, 2) }}</p>
                    </div>
                </div>
                <div class="my-3 d-flex justify-content-center">
                    <button onclick="printReceipt()" class="btn btn-primary mx-3">Print Receipt</button>
              
                    <button onclick="downloadPDF()" class="btn btn-warning">Download PDF</button>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>

    @include('admin.custom')
</div>

@include('admin.scripts')

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
}

/* Print Styles */
@media print {
    body * {
        visibility: hidden;
    }
    #receipt, #receipt * {
        visibility: visible;
    }
    #receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    /* Optional: Adjust text size for print */
    .small {
        font-size: 0.8rem;
    }

    /* Optional: Remove unnecessary styles for print */
    .btn, .header, .footer {
        display: none;
    }
}
</style>

<script>
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
    
        doc.setFontSize(20);
        doc.text('Order Receipt', 10, 10);
    
        doc.setFontSize(12);
        doc.text(`Order ID: {{ $order->id }}`, 10, 20);
        doc.text(`Name: {{ $order->customer }}`, 10, 30);
        doc.text(`Phone Number: {{ $order->phone }}`, 10, 40);
    
        doc.text('Order Details:', 10, 50);
        doc.text('Name', 10, 60);
        doc.text('Qty', 60, 60);
        doc.text('Price', 80, 60);
        doc.text('Subtotal', 100, 60);
    
        let y = 70;
        @foreach ($orderitems as $item)
            doc.text('{{ $item->medicineItems->name }}', 10, y);
            doc.text('{{ $item->qty }}', 60, y);
            doc.text('${{ number_format($item->medicineItems->price, 2) }}', 80, y);
            doc.text('${{ number_format($item->qty * $item->medicineItems->price, 2) }}', 100, y);
            y += 10;
        @endforeach
    
        doc.text(`Total: ${{ number_format($order->total, 2) }}`, 10, y + 10);
        doc.text(`Paid: ${{ number_format($order->paid, 2) }}`, 10, y + 20);
        doc.text(`Remaining: ${{ number_format($order->remaining, 2) }}`, 10, y + 30);
    
        doc.save('order_receipt.pdf');
    }

    function printReceipt() {
        window.print();
    }
</script>
    
</body>
</html>
