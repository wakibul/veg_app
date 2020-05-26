<html>

<body>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>SL No.</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>House No</th>
                <th>Landmark</th>
                <th>Address</th>


            </tr>
        </thead>
        <tbody>

            @forelse($customers as $key => $customer)

            <tr>
                <td>{{$key+1}}</td>
                <td>{{$customer->name??'NA'}}</td>
                <td>{{$customer->email ?? ''}}</td>
                <td>{{$customer->mobile??'NA'}}</td>
                <td> {{$customer->house_no??''}}</td>
                <td> {{$customer->landmark??''}}</td>
                <td> {{$customer->address??''}}</td>

            </tr>

            @empty
            <tr>
                <td colspan="8">No Data</td>
            </tr>
            @endforelse

        </tbody>
        <tfoot>

        </tfoot>
    </table>
</body>

</html>
