@extends("layouts.master")

@section("title", "BookHive - Discover Your Next Favorite Book")

@section("content")

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <h1 class="hero-title">Discover Your Next Favorite Book</h1>
    <p class="hero-subtitle">Join our community of passionate readers, explore thousands of titles, and share your literary journey</p>
    <div class="d-flex justify-content-center gap-3">
      <a href="{{ route('all.books') }}" class="btn btn-primary">Browse Books</a>
      <a href="{{ route('register') }}" class="btn btn-outline-light">Join Community</a>
    </div>
  </div>
</section>

<!-- Featured Books -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Featured This Month</h2>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      @foreach($featuredBooks as $book)
        <div class="col">
          <div class="book-card">
            @if($book->image)
              <img src="{{ asset('storage/' . $book->image) }}" class="book-cover" alt="{{ $book->title }}">
            @else
              <div class="book-cover-placeholder">
                <i class="fas fa-book-open fa-3x text-muted"></i>
              </div>
            @endif
            <div class="book-body">
              <h5 class="book-title">{{ $book->title }}</h5>
              <p class="book-author">{{ $book->author }}</p>
              <div class="rating">
                @php
                  $rating = $book->averageRating();
                  $fullStars = floor($rating);
                  $hasHalfStar = $rating - $fullStars >= 0.5;
                @endphp
                
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= $fullStars)
                    <i class="fas fa-star"></i>
                  @elseif($i == $fullStars + 1 && $hasHalfStar)
                    <i class="fas fa-star-half-alt"></i>
                  @else
                    <i class="far fa-star"></i>
                  @endif
                @endfor
                <span class="ms-1">{{ number_format($rating, 1) }}</span>
              </div>
              @if($book->genre)
                <span class="badge badge-genre mb-2">{{ $book->genre->name }}</span>
              @endif
              <p class="small text-muted">{{ Str::limit($book->description, 100) }}</p>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="#" class="text-decoration-none text-muted small">
                  <i class="far fa-comment me-1"></i> {{ $book->comments_count }} comments
                </a>
                <a href="{{ route('books.show.public', $book) }}" class="btn btn-sm btn-outline-primary">Add Comment</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="text-center mt-4">
      <a href="{{ route('all.books') }}" class="btn btn-outline-primary">View All Featured Books</a>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Why Join BookHive?</h2>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card text-center">
          <div class="feature-icon">
            <i class="fas fa-book-open"></i>
          </div>
          <h4>Personalized Recommendations</h4>
          <p>Discover books tailored to your unique reading taste with our smart recommendation engine.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center">
          <div class="feature-icon">
            <i class="fas fa-users"></i>
          </div>
          <h4>Vibrant Community</h4>
          <p>Join discussions, share reviews, and connect with fellow book lovers around the world.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card text-center">
          <div class="feature-icon">
            <i class="fas fa-trophy"></i>
          </div>
          <h4>Reading Challenges</h4>
          <p>Participate in fun challenges to expand your reading horizons and earn badges.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">What Our Readers Say</h2>
    </div>
    <div class="row g-4">
      @foreach($testimonials as $testimonial)
        <div class="col-md-4">
          <div class="testimonial-card">
            <div class="rating mb-3">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= $testimonial['rating'])
                  <i class="fas fa-star"></i>
                @elseif($i == ceil($testimonial['rating']) && strpos($testimonial['rating'], '.') !== false)
                  <i class="fas fa-star-half-alt"></i>
                @else
                  <i class="far fa-star"></i>
                @endif
              @endfor
            </div>
            <p class="testimonial-text">{{ $testimonial['text'] }}</p>
            <div class="d-flex align-items-center mt-3">
              <img src="{{ $testimonial['image'] }}" class="rounded-circle me-3" width="50" height="50" alt="{{ $testimonial['name'] }}">
              <div>
                <h6 class="mb-0">{{ $testimonial['name'] }}</h6>
                <small class="text-muted">{{ $testimonial['role'] }}</small>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="newsletter-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h2 class="mb-4">Stay Updated</h2>
        <p class="mb-5">Subscribe to our newsletter for weekly reading recommendations, author interviews, and community news.</p>
        <form class="row g-2 justify-content-center" action="{{ route('newsletter.subscribe') }}" method="POST">
          @csrf
          <div class="col-md-8">
            <input type="email" name="email" class="form-control newsletter-input" placeholder="Your email address" required>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn newsletter-btn w-100">Subscribe</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

@endsection