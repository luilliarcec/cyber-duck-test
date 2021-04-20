@extends('layout')

@section('breadcrumps')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Employees</h1>
        </div>

        <div class="col-sm-6 text-right">
            <a href="{{ route('employees.create') }}" class="btn btn-success">Add new employee</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employees</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->first_name }}</td>
                                <td>{{ $employee->last_name }}</td>
                                <td>{{ $employee->company->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('employees.edit', $employee) }}" type="button"
                                           class="btn btn-default">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('employees.destroy', $employee) }}"
                                              method="post" class="form-delete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    class="btn btn-default">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.form-delete')
            .forEach(element => element.addEventListener('submit', evt => {
                evt.preventDefault();

                let response = confirm("Are you sure to delete this record?");

                if (response) {
                    console.log(evt.target.submit())
                }
            }))
    </script>
@endpush
