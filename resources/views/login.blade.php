@extends('temp.main') @section('content')
<title>Login</title>
<div
    class="container d-flex align-items-center justify-content-center"
    style="height: 100vh;"
>
    <div class="card rounded-3 w-100" style="max-width: 350px;">
        <div class="card-body">
            <div class="text-center">
                <img
                    src="storage/icon.svg"
                    class="img-fluid"
                    alt="Logo"
                    style="max-width: 100px;"
                />
                <h3>Login</h3>
            </div>
            @if (\Session::has('alert'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('alert') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="username"
                        class="form-control"
                        name="username"
                        placeholder="Username"
                        required
                        autocomplete="off"
                    />
                </div>
                <div class="form-group mt-2">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Password"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="btn btn-primary btn-block w-100 mt-2"
                    value="Log In"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
@endsection