<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'BookHive')</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/bookhive/css/style.css">
  <link rel="stylesheet" href="/bookhive/css/app.css">
  <style>
    
  </style>
</head>
<body>
  <!-- Navigation Header -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="{{route('bookhive.index')}}">BookHive</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('bookhive.index') }}">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('all.books') }}">Browse</a>
    </li>

    @guest
        {{-- Guest: Login & Sign Up --}}
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item ms-lg-3">
            <a class="btn btn-outline-light" href="{{ route('register') }}">Sign Up</a>
        </li>
    @endguest

    @auth
        {{-- Authenticated: User Menu --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                @if(Auth::user()->avatar ?? false)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                @else
                    <i class="fas fa-user-circle me-1"></i>
                @endif
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    @endauth
</ul>

      </div>
    </div>
  </nav>

  @yield("content")

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <h3 class="text-white mb-4">BookHive</h3>
          <p>Your gateway to discovering great books and connecting with fellow readers worldwide.</p>
          <div class="social-icons mt-4">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-goodreads"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Explore</h5>
            <a href="#">Books</a>
            <a href="#">Authors</a>
            <a href="#">Genres</a>
            <a href="#">New Releases</a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Community</h5>
            <a href="#">Discussions</a>
            <a href="#">Book Clubs</a>
            <a href="#">Challenges</a>
            <a href="#">Events</a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Company</h5>
            <a href="#">About Us</a>
            <a href="#">Blog</a>
            <a href="#">Careers</a>
            <a href="#">Contact</a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <div class="footer-links">
            <h5>Support</h5>
            <a href="#">Help Center</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
          </div>
        </div>
      </div>
      <hr class="mt-4 mb-4">
      <div class="text-center">
        <small>© {{ date('Y') }} BookHive. All rights reserved.</small>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
   @yield('scripts') 
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    if (typeof bootstrap === 'undefined') {
        document.write('<script src="/path/to/local/bootstrap.bundle.min.js"><\/script>');
    }
</script>
</body>
</html>