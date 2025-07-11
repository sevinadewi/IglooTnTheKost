<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Minkos</title>

        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/boxicons/css/boxicons.min.css">
        
        <link rel="stylesheet" href="assets/css/aside.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="app-v1">
            <div class="login-cont">
                <div class="left">
                    <img src="assets/img/IndekostLogo.svg" alt="Igloo Indekost">
                    <h2>Minkos</h2>
                </div>
                <div class="right">
                    <h2>Login</h2>

                    @if (session('status'))
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: '{{ session("status") }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        </script>
                    @endif

                    <form action="login" method="POST" onsubmit="return validateLogin()">
                        @csrf
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your Email here">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your Password here">
                        </div>
                        <div>
                            <a href="{{ route('password.request') }}">Lupa password?</a>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                    </form>
                    <p class="login-text">Don't have an account? <a href="/register">Sign up</a></p>
                    {{-- <p class="or">- OR -</p>
                    <div class="google-btn">
                        <i class='bx bxl-google'></i>
                        <span>Sign in with Google</span>
                    </div> --}}
                    <p class="footer-login">Copyright Minkos</p>
                </div>
    
            </div>
        </div>

        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/vendor/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/vendor/one-page/scrollIt.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('assets/js/validation.js') }}"></script>
        <script src="assets/js/script.js"></script>
    </body>
</html>
