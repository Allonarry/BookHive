@extends("layouts.master")

@section("title", "Sign Up | BookHive")

@section("content")
  <!-- Main Signup Content -->
  <div class="signup-container">
    <div class="signup-card">
      <h1 class="signup-title">Join BookHive</h1>
      
      <form id="signupForm" action="/register" method="post">
         @csrf
        <div class="row">
          <div class="col-md-12 mb-3">
            <label for="fullName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="fullName" placeholder="Full name" name="name" required>
            @error("name")
            <p class="alert alert-danger">{{$message}}</p>
            @enderror
          </div>
          
        </div>
        
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" required>
          <div class="form-text"></div>
          @error("email")
          <p class="alert alert-danger">{{$message}}</p>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Create a password" name="password" required>
          <div class="password-strength">
            <div class="password-strength-bar" id="passwordStrength"></div>
          </div>
          <div class="form-text"></div>
          @error("password")
            <p class="alert alert-danger">{{$message}}</p>
          @enderror
        </div>
        
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" name="password_confirmation" required>
        </div>
        
        
        
        <!-- <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="newsletter" checked>
          <label class="form-check-label" for="newsletter">
            Subscribe to our newsletter for book recommendations and updates
          </label>
        </div> -->
        
        <button type="submit" class="btn btn-signup">Create Account</button>
      </form>

      <div class="signup-footer">
        <p>Already have an account? <a href="login.html">Sign in here</a></p>
      </div>
    </div>
  </div>

 @endsection