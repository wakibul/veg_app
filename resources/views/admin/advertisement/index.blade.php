
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
            @forelse($advertisements as $key=>$advertisement)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>
                    <a href="{{$advertisement->picture}}">
                        <i class="fa fa-eye" style="vertical-align:middle"></i>

                    </a>
                </td>

                <td>@if($advertisement->status==1)Active @else InActive @endif</td>
                <td>

                    <form action="{{route('admin.footer-banner.status',Crypt::encrypt($advertisement->id))}}" method="post">

                        @csrf

                        <button type="submit" class="btn btn-success" @if($advertisement->status==1)
                            onclick="return confirm('are you sure to InActive this Footer Banner Image?')" @else
                            onclick="return
                            confirm('are you sure to Active this Footer Banner Image?')" @endif>@if($advertisement->status==0)Active
                            @else InActive @endif</button>

                    </form>

                </td>
                <td>
                    <div class="btn-group">

                        <a href="{{route('admin.footer-banner.delete',Crypt::encrypt($advertisement->id))}}"
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
    <span class="pull-right"> {{ $advertisements->links()}}</span>
</div>
