<div class="col-md-5">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Status</th>
                <th>Active/InActive</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $key=>$banner)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>
                    <a href="{{$banner->banner_image}}">
                        <i class="fa fa-eye" style="vertical-align:middle"></i>

                    </a>
                </td>

                <td>@if($banner->status==1)Active @else InActive @endif</td>
                <td>

                    <form action="{{route('admin.banner.status',Crypt::encrypt($banner->id))}}" method="post">

                        @csrf

                        <button type="submit" class="btn btn-success" @if($banner->status==0)
                            onclick="return confirm('are you sure to InActive this Banner Image?')" @else onclick="return
                            confirm('are you sure to Active this coupon?')" @endif>@if($banner->status==0)InActive
                            @else Active @endif</button>

                    </form>

                </td>
                <td>
                    <div class="btn-group">

                        <a href="{{route('admin.banner.delete',Crypt::encrypt($banner->id))}}"
                            class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>

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
    <span class="pull-right"> {{ $banners->links()}}</span>
</div>
