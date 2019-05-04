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

    <title>Registrar</title>
</head>
<body>
    <section class="background-side">
    </section>
    <section class="login-side">
        <label class="title">Tasks</label>
        <form method="POST" action="{{route('register')}}">
        @csrf
            <section class="login-box">
                <label class="login-title"> Cadastrar </label>
                <input id="name" name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nome" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <input id="email" name="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-Mail" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Senha" required>
                @if ($errors->has('email'))
                    <span class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <input id="password-confirm" name="password_confirmation" type="password" class="form-control" placeholder="Confirmar Senha" required>
                @if (count($errors) > 0)
                    @foreach ($errors as $error)
                        <span class="alert alert-danger" role="alert">{{$error->getMessage()}}</div>
                    @endforeach
                @endif
                <button type="submit" class="btn btn-block login-btn" >Cadastrar</button>
                <a href="{{url('/logar')}}" class="login-link">Já possui conta? Entrar</a>
            </section>
        </form>
    </section>
</body>
</html>