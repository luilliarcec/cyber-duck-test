@extends('layout')

@section('breadcrumps')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Companies</h1>
        </div>

        <div class="col-sm-6 text-right">
            <a href="{{ route('companies.create') }}" class="btn btn-success">Add new company</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Companies</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $company->id }}</td>
                                <td>
                                    <img src="{{ $company->logo_url }}" class="img-size-50 mr-3 img-circle"
                                         alt="company_logo">
                                </td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->email }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('companies.edit', $company) }}" type="button"
                                           class="btn btn-default">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('companies.destroy', $company) }}"
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
                    {{ $companies->links() }}
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
