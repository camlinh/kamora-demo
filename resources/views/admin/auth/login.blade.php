
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <base href="{{asset('')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="backend/vendor/bootstrap/css/bootstrap.min.css">
    <link href="backend/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="backend/libs/css/style.css">
    <link rel="stylesheet" href="backend/libs/css/custom.css">
    <link rel="stylesheet" href="backend/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
              <img class="logo-img" src="backend/images/logo.png" alt="logo" height="50">
            </div>
            <div class="card-body">
                  {!!Form::open()->post()->route('admin.login.post')!!}
                    {!! Form::text('email')->type('email')->attrs(['class' => 'form-control-lg'])->placeholder('Email') !!}
                    {!! Form::text('password')->type('password')->attrs(['class' => 'form-control-lg'])->placeholder('Password') !!}
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember"><span class="custom-control-label">Nhớ mật khẩu</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Đăng nhập</button>
                  {!!Form::close()!!}
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="backend/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="backend/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>