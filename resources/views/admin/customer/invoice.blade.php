<html>
    <head>
        <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
        </style>
        <body>
    <table style="width:100%">
        <tr aria-rowspan="2">
            <td colspan="2" style="text-align: left">Local Farmer</td>
        <td colspan="2" style="text-align: right">Order No:{{$order->order_confirm_id??''}}<br> Date:{{date('Y-M-D')}}<br> Name:{{$order->customer->name??''}}<br>Mobile No:{{$order->customer->mobile??''}}</td>
        </tr>
    </table>
    <table style="width:100%" border="1">
        <tr>
          <th>Sl.</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Type</th>
          <th>Price</th>
        </tr>
         @foreach($order->orderTransactions as $key=>$transaction)
        <tr>
             <td align="right">{{$key+1}}</td>
            <td align="right">{{$transaction->product->name??'NA'}}</td>
            <td align="right">{{$transaction->quantity??'NA' }}</td>
            <td align="right">{{$transaction->productPackage->packageMaster->name??'NA'}}</td>
            <td align="right">{{$transaction->price??'NA'}}</td>
        </tr>
         @endforeach
         <tr>
         <td colspan="4"></td>
         <td align="right">Price:{{$order->total_price??'0.00'}}<br>Discount Amount:{{$order->discount_amt??'0.00'}}<br> Total Amount:{{$order->total_price_with_tax??'0.00'}}</td>
          </tr>
      </table>
        </body>
</html>
