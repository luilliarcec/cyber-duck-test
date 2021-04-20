@extends('layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employees</h3>
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

                <form action="{{ route('employees.store') }}" method="post">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                class="form-control"
                                placeholder="Enter first name"
                                value="{{ old('first_name') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                class="form-control"
                                placeholder="Enter last name"
                                value="{{ old('last_name') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="company_id">Company</label>
                            <select id="company_id" name="company_id" class="form-control">
                                @foreach($companies as $key => $value)
                                    <option value="{{ $key }}"
                                            @if($key == old('company_id')) selected @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter email"
                                value="{{ old('email') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                class="form-control"
                                placeholder="Enter website url"
                                value="{{ old('phone') }}"
                            >
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
