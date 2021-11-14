@extends('layouts.layout')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


@section('content')
                <div class="login">
                    <form method="POST" action="{{ route('login') }}" class="form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" >E-mail cím:</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password">Jelszó:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        Maradjak bejelentkezve
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="button">
                                    Bejelentkezés
                                </button>

                                @if (Route::has('password.request'))
                                    <button class="button" href="{{ route('password.request') }}">
                                        Eljelejtette a jelszavát?
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                        <div>Bejelentkezés Facebook vagy Google fiókkal:</div>
                        <a href="{{ url('auth/facebook') }}" class="fa fa-facebook"></a>
                        <a href="{{ url('auth/google') }}" class="fa fa-google"></a>
                </div>
@endsection
