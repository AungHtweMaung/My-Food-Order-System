@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')
    <div class="login-form">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div>
                <h2 class="text-center text-uppercase mb-2" style="font-family: Arial, Helvetica, sans-serif">
                    login
                </h2>

            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="text" name="email" placeholder="Email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>

        </form>
        <div class="register-link">
            <p>
                Don't you have account?
                <a href="{{ route('auth#registerPage') }}">Register Here</a>
            </p>
        </div>
    </div>
@endsection
