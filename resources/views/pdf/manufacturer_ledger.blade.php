<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Manufacturer Ledger</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Manufacturer</th>
                <th>Date</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $balances = [];
            @endphp
            @foreach ($transactions as $transaction)
                @php
                    $manufacturerId = $transaction->manufacturer_id;
                    if (!isset($balances[$manufacturerId])) {
                        $balances[$manufacturerId] = 0;
                    }

                    if ($transaction->type == 'debit') {
                        $balances[$manufacturerId] += $transaction->amount;
                        $debitAmount = number_format($transaction->amount);
                        $creditAmount = '';
                    } else {
                        $balances[$manufacturerId] -= $transaction->amount;
                        $debitAmount = '';
                        $creditAmount = number_format($transaction->amount);
                    }
                @endphp
                <tr>
                    <td>{{ $transaction->order_id }}</td>
                    <td>{{ $transaction->manufacturer_name }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $debitAmount ? $debitAmount . ' $' : ' - ' }}</td>
                    <td>{{ $creditAmount ? $creditAmount . ' $' : ' - ' }}</td>
                    <td>{{ number_format($balances[$manufacturerId]) }} $</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
