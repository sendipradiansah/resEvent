<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="vh-100 bg-primary">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow" style="border-radius: 1rem;">
                        <div class="card-body p-5">

                            <h3 class="mb-4 text-center">Login</h3>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" autocomplete="off">
                                    @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>

                                <p class="text-center">
                                    Apakah Anda belum memiliki akun?
                                    <a href="{{ route('register') }}" class="text-decoration-none">Registrasi disini</a>
                                </p>
                                @error('message')
                                <p class="text-center text-danger ">{{ $message }}</p>
                                @enderror

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>