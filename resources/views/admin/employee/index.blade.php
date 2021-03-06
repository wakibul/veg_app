<div class="col-md-5">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone No.</th>
                <th >Address</th>
                <th>pin</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $key=>$employee)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>{{$employee->name}}</td>
                <td>{{$employee->mobile}}</td>
                <td width="25%">{{$employee->address}}</td>
                <td>{{$employee->pincode}}</td>
                <td>
                    <a href="{{ $employee->document }}">
                        <i class="fa fa-eye"style="vertical-align:middle"></i>

                    </a>
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.employee.edit',Crypt::encrypt($employee->id))}}" class="btn btn-sm
                        btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="{{route('admin.employee.delete',Crypt::encrypt($employee->id))}}"
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
    <span class="pull-right"> {{ $employees->links()}}</span>
</div>
