<html>

<body>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="2">SL No.</th>
                <th rowspan="2">Order No</th>
                <th colspan="4">Order Item</th>
                <th rowspan="2">Phone</th>
                <th rowspan="2">Delivery Slot</th>

            </tr>
            <tr>
                <td>Product Name</td>
                <td>Quantity</td>
                <td>Unit</td>
                <td>Price</td>
            </tr>
        </thead>
        <tbody>

            @forelse($orders as $key => $order)
@php
    $row_count = $order->orderTransactions->count();
@endphp
            <tr>
                <td @if($row_count) rowspan="{{$row_count}}"  @endif>{{$key+1}}</td>
                <td @if($row_count) rowspan="{{$row_count}}"  @endif>{{$order->order_confirm_id??'NA'}}</td>

                @foreach($order->orderTransactions as $index => $transaction)
                @if (!$loop->first)
                    <tr>
                @endif
                 <td> {{$transaction->product->name??'NA'}}</td>
                  <td>{{$transaction->quantity??'NA' }}</td>
                  <td> {{$transaction->productPackage->packageMaster->name??'NA'}}</td>
                  <td> {{$transaction->price??'NA'}}</td>
                  @if (!$index)
                    <td @if($row_count) rowspan="{{$row_count}}"  @endif>{{$order->recipient_no??'NA'}}</td>
                    <td @if($row_count) rowspan="{{$row_count}}"  @endif> {{$order->timeSlot->slot??''}}</td>
                @endif
              </tr>
                @endforeach

             @endforeach

        </tbody>

    </table>
</body>

</html>
