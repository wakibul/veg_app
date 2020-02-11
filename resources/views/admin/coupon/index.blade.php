<div class="col-md-5">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Coupon Code</th>
                <th>Coupon In</th>
                <th>Coupon Value</th>
                <th>Coupon Type</th>
                <th>Max coupon Use</th>
                <th>Valid to</th>
                <th>Minimun Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $key=>$coupon)
            <tr>
                <td>{{ ($key+1) }}</td>
            <td>{{$coupon->name}}</td>
            <td>{{$coupon->coupon_code}}</td>
            <td>@if($coupon->coupon_in==1)Percentage @else Rupees @endif</td>
            <td>{{$coupon->coupon_value}}</td>
            <td>{{$coupon->coupon_type}}</td>
            <td>{{$coupon->max_coupon_use}}</td>
            <td>{{$coupon->valid_to}}</td>
            <td>{{$coupon->minimun_amount}}</td>
            <td>@if($coupon->status==0)Active @else NotActive @endif</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.coupon.edit',Crypt::encrypt($coupon->id))}}" class="btn btn-sm
                        btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="{{route('admin.coupon.delete',Crypt::encrypt($coupon->id))}}"
                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No data</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    <span class="pull-right"> {{ $coupons->links()}}</span>
</div>
