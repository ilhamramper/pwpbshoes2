<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Karma Shop</title>

    <link rel="stylesheet"
        href="{{ asset('loginregister/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('loginregister/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <h1>Create Account</h1><br>
                <div class="form-group">
                    <input type="text" class="form-input form-control @error('name') is-invalid @enderror"
                        name="name" id="name" placeholder="Name" value="{{ old('name') }}" required
                        autocomplete="name" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-input form-control @error('email') is-invalid @enderror"
                        name="email" id="email" placeholder="Your Email" value="{{ old('email') }}" required
                        autocomplete="email" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-input form-control @error('password') is-invalid @enderror"
                        name="password" id="password" placeholder="Password" required autocomplete="new-password" />
                    <span data-toggle="#password" class="zmdi zmdi-eye-off field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-input form-control" name="password_confirmation"
                        id="password_confirm" placeholder="Password Confirmation" required
                        autocomplete="new-password" />
                    <span data-toggle="#password_confirm"
                        class="zmdi zmdi-eye-off field-icon toggle-password-confirm"></span>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" id="submit" class="form-submit" value="register">Sign
                        Up</button>
                </div>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <h1>Sign in</h1><br>
                <div class="form-group">
                    <input type="email" class="form-input form-control @error('email') is-invalid @enderror"
                        name="email" id="email" placeholder="Your Email" value="{{ old('email') }}" required
                        autocomplete="email" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-input form-control @error('password') is-invalid @enderror"
                        name="password" id="password_login" placeholder="Password" required
                        autocomplete="current-password" />
                    <span data-toggle="#password_login" class="zmdi zmdi-eye-off field-icon toggle-password-login"></span>
                </div>
                <a href="#">Forgot your password?</a>
                <div class="form-group">
                    <button type="submit" name="submit" id="submit" class="form-submit" value="login">Sign
                        In</button>
                </div>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('loginregister/script.js') }}"></script>
    <script src="{{ asset('loginregister/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        (function($) {
            $(".toggle-password").click(function() {
                $(this).toggleClass("zmdi-eye zmdi-eye-off");
                var input = $($(this).data("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $(".toggle-password-confirm").click(function() {
                $(this).toggleClass("zmdi-eye zmdi-eye-off");
                var input = $($(this).data("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $(".toggle-password-login").click(function() {
                $(this).toggleClass("zmdi-eye zmdi-eye-off");
                var input = $($(this).data("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            @if ($errors->has('login'))
                toastr.error("{{ $errors->first('login') }}", "Login Error");
            @endif

            @if ($errors->has('emailwrong'))
                toastr.error("{{ $errors->first('emailwrong') }}", "Login Error");
            @endif

            @if ($errors->has('email'))
                toastr.error("{{ $errors->first('email') }}", "Registration Error");
            @endif

            @if ($errors->has('password'))
                toastr.error("{{ $errors->first('password') }}", "Registration Error");
            @endif

            @if ($errors->has('wishlist'))
                toastr.error("{{ $errors->first('wishlist') }}", "Wishlist Error");
            @endif

            @if ($errors->has('cart'))
                toastr.error("{{ $errors->first('cart') }}", "Cart Error");
            @endif
        })(jQuery);
    </script>
</body>

</html>
