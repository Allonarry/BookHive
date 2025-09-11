@extends("layouts.master")

@section("title", "Login | BookHive")

@section("content")


  <!-- Main Login Content -->
  <div class="login-container">
    <div class="login-card">
      <h1 class="login-title">Welcome Back</h1>
      
      <form action="/login" method="post">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" value="{{old('email')}}" required>
          @error("email")
          <p class="alert alert-danger">{{$message}}</p>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" value="{{old('password')}}" required>
           @error("password")
          <p class="alert alert-danger">{{$message}}</p>
          @enderror
          <div class="form-text text-end">
            <a href="forgot-password.html">Forgot password?</a>
          </div>
        </div>
        
        <!-- <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div> -->
        
        <button type="submit" class="btn btn-login">Log In</button>
      </form>

      <div class="login-footer">
        <p>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
      </div>

      

      
    </div>
  </div>

  @endsection


