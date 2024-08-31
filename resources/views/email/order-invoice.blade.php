<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 16px;">
    @if($mailData['userType'] == 'customer')
        <h1>Thank for you order</h1>
        <h2>You Order ID: #{{ $mailData['order']->id}}</h2>
    @else
        <h1>You have received a new order</h1>
        <h2>You Order ID: #{{ $mailData['order']->id}}</h2>
    @endif

    <div>
        <h3>Shipping Address</h3>
            <address>
                <strong>{{$mailData['order']->first_name." ".$mailData['order']->last_name}}</strong><br>
                Address: {{$mailData['order']->address}}<br>
                City: {{$mailData['order']->city.','.getCountry($mailData['order']->country_id)->name}}<br>
                Phone: {{ formatPhoneNumber($mailData['order']->mobile )}}<br>
                Email: {{ $mailData['order']->email}}<br>
                <strong>Shipped Date: {{ \Carbon\Carbon::parse($mailData['order']->shipped_date)->format('d, M y, H:i')}}</strong>
            </address>
        </div>

        <h3>Product</h3>
        <table>
            <thead>
                <tr style="background: #ccc">
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>

            </thead>
            <tbody>

                @foreach ($mailData['order']->order_items as $orderItem)
                    <tr>
                        <td>{{ $orderItem->name}}</td>
                        <td>$ {{ number_format($orderItem->price, 2) }}</td>
                        <td>{{ $orderItem->qty}}</td>
                        <td>$ {{ number_format($orderItem->total, 2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" align="right">Subtotal:</th>
                    <td>$ {{ number_format($mailData['order']->subtotal, 2)}}</td>
                </tr>

                <tr>
                    <th colspan="3" align="right">Shipping:</th>
                    <td>$ {{ number_format($mailData['order']->shipping, 2)}}</td>
                </tr>
                <tr>
                    <th colspan="3" align="right">Discount:</th>
                    <td>$ {{ number_format($mailData['order']->discount, 2)}}</td>
                </tr>
                <tr>
                    <th colspan="3" align="right">Grand Total:</th>
                    <td>$ {{ number_format($mailData['order']->grand_total, 2)}}</td>
                </tr>

            </tbody>
        </table>
</body>
</html>
