<!DOCTYPE html>
<html lang="en">
<head>
    {{-- head --}}
    @include('admin.head')
    {{-- end head --}}
    <style>
      .receipt-container {
          background-color: #ffffff;
          border: 1px solid #ccc;
          border-radius: 8px;
          padding: 20px;
          margin: 20px auto; /* Keep auto margin for centering horizontally */
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          max-width: 400px;
         /* Align text to the left */
      }
      .receipt-header {
          text-align: center; /* Align header text to the center */
          margin-bottom: 10px;
      }
      .receipt-header h2 {
          margin: 0;
      }
      .receipt-details {
          margin-bottom: 20px;
      }
      .receipt-details p {
          margin: 5px 0;
          text-align: left; /* Align text to the left */
      }
    
      .table-small {
          max-width: 380px;
          border-collapse: collapse;
          margin: 0;
          text-align: center; /* Center text in table */
      }
      .table-small th, .table-small td {
          border: 1px solid #ddd;
          padding: 2px;
      }
    
      .print-button {
          text-align: center;
          margin-top: 20px; 
      }
      .print-button button {
          margin: 0 10px; /* Space between buttons */
      }
    </style>
    <!-- Include jsPDF and html2pdf libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
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
            <div class="container">
              <div class="print-button">
                <button onclick="printReceipt()" class="btn btn-primary mb-3">Print Receipt</button>
                <button onclick="downloadPDF()" class="btn btn-secondary mb-3">Download PDF</button>
            </div>
                <!-- Receipt -->
                <div class="receipt-container w-75 mt-5 ">
                    <div class="receipt-header">
                        <h2>Receipt</h2>
                    </div>
                    <div class="">
                      <p><strong>Invoice # </strong> {{ $order->invoice}}<br>
                      <strong>Customer:</strong> {{ $order->customer}}</p>
                    </div>
                        <table class='table-small'>
                        <tr>
                          <th>Order_No</th>
                          <th>Amount</th>
                          <th>Date</th>
                          <th>Payment_Method</th>

                        </tr>
                      
                    
                        <tr>
                        <td>{{ $payment->order_id }}</td>
                          <td>{{number_format( $payment->amount )}} Rs/-</td>
                          <td>{{ $payment->date }}</td>
                          <td>{{ $payment->payment_method }}</td>
                 
                        </tr>
                      </table>
                      <div class="mt-4"><strong>Total: </strong>{{ number_format($order->total)}}Rs/-

                        <br>
                      <span><strong>Paid: </strong> {{number_format( $order->paid)}} Rs/-</span>
                </div>
                    </div>


                <!-- End Receipt -->
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

    <script>
        function printReceipt() {
            const printWindow = window.open('', '', 'height=600,width=800');
            const receiptContent = document.querySelector('.receipt-container').innerHTML;
            printWindow.document.write('<html><head><title>Print Receipt</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(receiptContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }

        function downloadPDF() {
            const element = document.querySelector('.receipt-container');
            const opt = {
                margin:       0.5,
                filename:     'receipt.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>
