<div class="col-md-7">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Type</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key=>$user)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>{{$user->name}}</td>
                <td>@if($user->type==2)Sub Admin @endif</td>
                <td>{{$user->email}}</td>
                <td>@if($user->status==0)Not Active @else Active @endif</td>
                <td>
                    <form action="{{route('admin.user.status',Crypt::encrypt($user->id))}}" method="post">

                        @csrf
                    <button type="submit" class="btn btn-success" @if($user->status==0)
                        onclick="return confirm('are you sure to Active this user?')" @else onclick="return
                        confirm('are you sure to InActive this user?')" @endif>@if($user->status==0)Active
                        @else InActive @endif</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No data</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    <span class="pull-right"> {{ $users->links()}}</span>
</div>
