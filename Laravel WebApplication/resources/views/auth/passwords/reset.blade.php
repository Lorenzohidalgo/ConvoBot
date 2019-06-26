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
                        <form method="POST" action="{{ route('password.update') }}">
                         @csrf
                        <input type="hidden" name="token" value="{{ $token }}">    

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="{{ __('Email adress') }}"  class="form-control @error('email') is-invalid @enderror authInput" name="email" value="{{ old('email') }}" required autocomplete="email">
    
                                    @error('email')
                                        <span class="invalid-feedback authValidation" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>                        

                        <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control @error('password') is-invalid @enderror authInput" name="password" required autocomplete="new-password">
                                        
                                        @error('password')
                                            <span class="invalid-feedback authValidation" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <div class="col-md-12">
                                        <input id="password-confirm" placeholder="{{ __('Confirm the password') }}"  type="password" class="form-control authInput" name="password_confirmation" required autocomplete="new-password">
                                </div>
                        </div>                        
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="btn btn-primary authButton">
                                        {{ __('Reset Password') }}
                                </button>
    

                            </div>
                        </div>

                        <div class="form-group row">
                                <div class="col-md-6 authLinks text-left">
                                        <a class="btn btn-link" href="{{ route('login') }}">
                                            {{ __('I already have an account!') }}
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
