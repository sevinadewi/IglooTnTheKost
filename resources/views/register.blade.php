<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Igloo Indekost</title>

        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendor/boxicons/css/boxicons.min.css">

        <link rel="stylesheet" href="assets/css/aside.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="app-v1">
            <div class="login-cont">
                <div class="left">
                    <img src="assets/img/IndekostLogo.svg" alt="Igloo Indekos">
                    <h2>Igloo Indekos</h2>
                </div>
                <div class="right">
                    <h2>Create your Free Account</h2>
                   <form action="register" method="POST">
                    @csrf
                        <div class="input-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" placeholder="Enter your Full Name here">
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" placeholder="Enter your Email here">
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" placeholder="Enter your Password here">
                        </div>
                        <button class="btn-login" type="submit" onclick="window.location.href='login.html'">Create Account</button>
                   </form>

                    <p class="login-text">Already have an account? <a href="/login">Log in</a></p>
                    <p class="or">- OR -</p>
                    <div class="google-btn">
                        <i class='bx bxl-google'></i>
                        <span>Sign up with Google</span>
                    </div>
                    <p class="footer-login">Copyright Igloo Indekos</p>
                </div>
            </div>
        </div>

        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/vendor/jquery/jquery-3.5.1.min.js"></script>
        <script src="assets/vendor/one-page/scrollIt.min.js"></script>

        <script src="assets/js/script.js"></script>
    </body>
</html>
