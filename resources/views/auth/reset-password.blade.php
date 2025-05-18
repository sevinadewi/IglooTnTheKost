<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Reset Password</title>

        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/boxicons/css/boxicons.min.css">

        <link rel="stylesheet" href="assets/css/aside.css">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="app-v1">
            <div class="login-cont">
                <div class="left">
                    <img src="assets/img/IndekostLogo.svg" alt="Igloo Indekost">
                    <h2>Igloo Indekost</h2>
                </div>
                <div class="right">
                    <h2>Reset Password</h2>

                    <form action="/reset-password" method="POST">
                        @csrf
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your Email here">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your Password here">
                        </div>
                        <div class="input-group">
                            <label for="repassword"> Retype Password</label>
                            <input type="password" id="repassword" name="password_confirmation" placeholder="Re-Enter your Password here">
                        </div>
                        <div class="input-group">
                            <input type="hidden" id="token" name="token" value="{{ $token }}">
                        </div>
                      
                        <button type="submit" class="btn-login">Send</button>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger col-md-6">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    
                                @endforeach
                            </ul>

                        </div>
                    @endif

                    <p class="footer-login">Copyright Igloo Indekost</p>
                </div>
            </div>
        </div>

        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/vendor/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/vendor/one-page/scrollIt.min.js"></script>

        <script src="assets/js/script.js"></script>
    </body>
</html>
