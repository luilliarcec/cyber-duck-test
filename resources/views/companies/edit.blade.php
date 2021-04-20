@extends('layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Companies</h3>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible m-4">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5>
                            <i class="icon fas fa-ban"></i>
                            Alert!
                        </h5>

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('companies.update', $company) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <div class="form-group">
                            <img src="{{ $company->logo }}" class="img-size-50 mr-5 img-circle"
                                 alt="company_logo">
                        </div>

                        <div class="form-group">
                            <label for="name">Company name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                placeholder="Enter name"
                                value="{{ old('name', $company->name) }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter email"
                                value="{{ old('email', $company->email) }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input
                                type="text"
                                id="website"
                                name="website"
                                class="form-control"
                                placeholder="Enter website url"
                                value="{{ old('website', $company->website) }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo input</label>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input
                                        type="file"
                                        id="logo"
                                        name="logo"
                                        class="custom-file-input"
                                    >

                                    <label class="custom-file-label" for="logo">
                                        Choose file
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
