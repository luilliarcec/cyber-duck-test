@extends('layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Companies</h3>
                </div>

                <form action="{{ route('companies.create') }}" method="post">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Company name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                placeholder="Enter name"
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
                            >
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo input</label>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input
                                        type="file"
                                        id="logo"
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
