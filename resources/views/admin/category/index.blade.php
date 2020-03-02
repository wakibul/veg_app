<div class="col-md-6">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $key=>$category)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>{{$category->name}}</td>
                <td>
                    <a href="{{$category->banner_image}}">
                        <i class="fa fa-eye" style="vertical-align:middle"></i>

                    </a>
                </td>
                <td>@if($category->status==1)Active @else InActive @endif</td>

                <td>
                    <form action="{{route('admin.category.status',Crypt::encrypt($category->id))}}" method="post">

                        @csrf

                        <button type="submit" class="btn btn-success" @if($category->status==0)
                            onclick="return confirm('are you sure to Active this Category?')" @else onclick="return
                            confirm('are you sure to InActive this Category?')" @endif>@if($category->status==0)Active
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
    <span class="pull-right"> {{ $categories->links()}}</span>
</div>
