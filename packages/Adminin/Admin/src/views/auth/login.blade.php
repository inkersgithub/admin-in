
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/admin/images/a2z.png">
    <link rel="stylesheet" href="/user/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="/user/css/style.css"> -->
</head>
<body >
<style>
    html, body {
        background: url({{ URL::asset('images/image.jpg') }})
    }
</style>

{{ Form::open(array('url' => '/admin/auth/login')) }}

{{csrf_field()}}

<div class="container">
    <div class="col-md-4"  id="form-wrapper">
        <h1 style="color:black; "><center>ADMIN</center></h1>
        <div class="form-group {{ $errors->has('user_name') ? ' has-error' : '' }} ">
            <div class="input-group input-wrapper">
                <span class="input-group-addon" id="user-id"></span>
                <input type="text" class="form-control credentials"  required name="user_name" value="{{ old('user_name') }}" placeholder="Enter Username" aria-describedby="user-addon">
            </div>
            @if ($errors->has('user_name'))
                <span class="help-block" style="color: red">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
            @endif
        </div>
        <div class="form-group ">
            <div class="input-group input-wrapper">
                <span class="input-group-addon" id="password"> </span>
                <input type="password" class="form-control credentials" required name="password"  placeholder="Enter Password" aria-describedby="password-addon">
            </div>
        </div>
    </div>

    <div class="col-md-2 button-wrapper">
        <button id="login-button" type="submit" class="btn btn-lg">Login</button>
    </div>
    {{--</form>--}}
    {!! Form::close() !!}
    <style type="text/css">
        .container {
            width: 22%;
            margin-top: 14%;
            margin-left: 37%;
            padding: 16px;
            border: 3px solid  black;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #69425f;
            color: white;
            padding: 14px 20px;
            margin: 8px 105px;
            border: none;
            cursor: pointer;
            width: 50%;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script src="/user/js/bootstrap.min.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">




    </script>



    @if(Session::has('saveMsg'))
        <script>

            swal("Authentication error!");


        </script>
        @endif
        </body>


        </html>
