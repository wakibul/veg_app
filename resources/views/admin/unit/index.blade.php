<div class="col-md-6">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Unit Name</th>
                <th>Abbreviation</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($units as $key=>$unit)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>{{$unit->name}}</td>
                <td>{{$unit->abb}}</td>
                <td>@if($unit->status==0)Not Available @else Available @endif</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.unit.edit',Crypt::encrypt($unit->id))}}" class="btn btn-sm
                        btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="{{route('admin.unit.delete',Crypt::encrypt($unit->id))}}"
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
    <span class="pull-right"> {{ $units->links()}}</span>
</div>
