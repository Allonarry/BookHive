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
            <i class="fas fa-brain"></i>
          </div>
          <h4>AI Recommendations</h4>
          <p>Discover books tailored to your unique reading taste with our AWS Bedrock recommendation engine.</p>
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

<!-- AI Integration Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--deep-teal) 0%, #1e4543 100%);">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h2 class="section-title text-white" style="color: white !important; font-family: 'Dancing Script', cursive; font-size: 3rem;">AI-Powered Book Intelligence</h2>
        <p class="lead mb-4">BookHive integrates next-generation Generative AI models directly into your reading workflow. Built on top of robust, security-first **AWS Bedrock** infrastructure, we deliver instant literary insights without compromising data privacy.</p>
        <div class="d-flex flex-column gap-3">
          <div class="d-flex align-items-start gap-3">
            <div class="p-2 rounded bg-white text-dark" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <i class="fas fa-magic" style="color: var(--deep-teal); font-size: 1.25rem;"></i>
            </div>
            <div>
              <h5 class="mb-1">Semantic Match Discovery</h5>
              <p class="small text-white-50">Our models parse your bookshelves and favorites to match you with stories based on themes, prose styles, and emotional arcs rather than just basic keyword searches.</p>
            </div>
          </div>
          <div class="d-flex align-items-start gap-3">
            <div class="p-2 rounded bg-white text-dark" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <i class="fas fa-book-reader" style="color: var(--deep-teal); font-size: 1.25rem;"></i>
            </div>
            <div>
              <h5 class="mb-1">Spoiler-Free Summarization</h5>
              <p class="small text-white-50">Need a quick primer on a long-read? Generate spoiler-free book overviews, structural outlines, and key concept breakdowns in a single tap.</p>
            </div>
          </div>
          <div class="d-flex align-items-start gap-3">
            <div class="p-2 rounded bg-white text-dark" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <i class="fas fa-chart-line" style="color: var(--deep-teal); font-size: 1.25rem;"></i>
            </div>
            <div>
              <h5 class="mb-1">Review Sentiment Analysis</h5>
              <p class="small text-white-50">Our NLP pipelines run sentiment mapping over thousands of reviews, giving you a snapshot of how readers react emotionally to any book.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <div class="p-5 rounded border border-light border-opacity-10 shadow-lg" style="background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px);">
          <i class="fas fa-brain fa-4x mb-4 text-warning" style="color: var(--warm-terracotta) !important;"></i>
          <h4 class="mb-3 text-white">AWS Bedrock Integration</h4>
          <p class="text-white-50 small mb-4">By orchestrating foundation models via Amazon Bedrock (deploying Claude 3.5 Sonnet), BookHive ensures that all prompts and data are encrypted end-to-end, maintaining absolute privacy for your personal reading logs.</p>
          <div class="d-flex justify-content-center gap-2 flex-wrap">
            <span class="badge bg-light text-dark px-3 py-2">Generative AI</span>
            <span class="badge bg-light text-dark px-3 py-2">NLP Sentiment</span>
            <span class="badge bg-light text-dark px-3 py-2">AWS Bedrock</span>
          </div>
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