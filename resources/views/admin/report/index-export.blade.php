<html>

<body>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>SL No.</th>
                <th>Order No</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Delivery Slot</th>
                
            </tr>
        </thead>
        <tbody>
            
            @forelse($orders as $key => $order)
          
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$order->order_confirm_id??'NA'}}</td>
                <td>{{$order->address ?? ''}}</td>
                <td>{{$order->recipient_no??'NA'}}</td>
                <td> {{$order->timeSlot->slot??''}}</td>
               
            </tr>
           
            @empty
            <tr>
                <td colspan="8">No Data</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="2">Total Amount:</td>
                <td>{{$total_amount}}</td>
            </tr>
        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
</body>

</html>
