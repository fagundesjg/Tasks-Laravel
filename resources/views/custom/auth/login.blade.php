<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet"> 
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
</head>
<body>
    <section class="background-side">
    </section>
    <section class="login-side">
        <label class="title">Tasks</label>
        <form action="{{route('login')}}" method="POST">
            <section class="login-box">
            @csrf
                <label class="login-title"> Entrar </label>
                <input id="email" name="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-Mail">
                @if ($errors->has('email'))
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Senha">
                @if ($errors->has('password'))
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit" class="btn btn-block login-btn" >Entrar</button>
                <a href="{{url('/registrar')}}" class="login-link">Não possui conta? Cadastrar</a>
            </section>
        </form>
    </section>
</body>
</html>