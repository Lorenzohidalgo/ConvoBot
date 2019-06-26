@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center fullAuthBrowserHeigh">


        <div class="col-md-8 my-auto">
            <div id="logoContainer">
               <img src="{{ asset('css/img/logoWhite.png') }}">
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <form method="POST" action="{{ route('login') }}">
                         @csrf

                         <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control @error('email') is-invalid @enderror authInput" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback authValidation" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                             </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror authInput" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>                        

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="btn btn-primary authButton">
                                        {{ __('Login') }}
                                </button>
    

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 authLinks text-left">
                                @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                @endif                     
                            </div>
                            <div class="col-md-6 authLinks text-right">
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Create new account') }}
                                </a>                   
                            </div>                            
                        </div> 

                        </form>
                    </div> 
                    <div class="col-1"></div>                                   
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
