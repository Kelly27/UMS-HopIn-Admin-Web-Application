@extends('layouts.html_head')

@section('style')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="loginPage container-fluid">
    <div class="container">
        <div class="panel-default panel col-md-offset-7">
            <div class="panel-heading">
                <img src="{{asset('imgs/ums_logo.png')}}" class="img-responsive">
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('staff_number') ? ' has-error' : '' }}">
                        <label for="staff_number" class="col-md-4 control-label">Staff Number</label>

                        <div class="col-md-6">
                            <input id="staff_number" type="staff_number" class="form-control" name="staff_number" value="{{ old('staff_number') }}" required autofocus>

                            @if ($errors->has('staff_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('staff_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
{{-- 
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a> --}}
                        </div>
                    </div>

{{--                     <div class="text-center">
                        <a href="{{route('register')}}"> Register a new account</a>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
