<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- custom css -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js"
        integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0067FF;
            background-image: linear-gradient(-315deg, #0067FF 0%, #008FFD 30%);
        }

        .login {
            width: 360px;
            height: min-content;
            padding: 20px;
            border-radius: 12px;
            background: #FFF;
        }

        .login h1 {
            font-size: 36px;
            margin-bottom: 25px;

        }

        .login form .form-group {
            margin-bottom: 12px;
        }

        .login form input[type=submit] {
            font-size: 20px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="login">

        <h1 class="text-center">LOGIN</h1>
        <form class="" method="POST" action="/login">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="form-lable" for="email">Email address</label>
                <input class="form-control" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-lable" for="password">Password</label>
                <input class="form-control" type="password" name="password"required>
            </div>
            <input id="btnLogin" class="btn btn-success w-100" type="submit" value="SIGN IN">
            @if (isset($status) && $status == 400)
                <div id="alert" class="alert alert-danger alert-dismissible" role="alert">
                    <div>Wrong email or password</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </form>
    </div>
</body>

</html>
