@extends('layout')

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
                                        <a type="button" class="btn btn-default">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('companies.edit', $company) }}" type="button"
                                           class="btn btn-default">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-default">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
