@extends('layouts.master')

@section('title', 'Browse All Books | BookHive')

@section('content')
<style>
    :root {
        --deep-teal: #2a5c5a;
        --warm-terracotta: #c76b4a;
        --ivory: #f8f5f0;
        --oxblood: #76323f;
        --charcoal: #1e1e24;
        --soft-sage: #8a9b8a;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(rgba(42, 92, 90, 0.8), rgba(118, 50, 63, 0.7)),
                    url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-bottom: 3rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .hero-title {
        font-family: 'Dancing Script', cursive;
        font-size: 3.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        color: white;
        margin-bottom: 1rem;
        animation: fadeInDown 1s ease;
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
        color: rgba(255,255,255,0.9);
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        animation: fadeIn 1.5s ease;
    }
    
    /* Book Cards */
    .book-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .book-cover {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    
    .book-cover-placeholder {
        width: 100%;
        height: 300px;
        background-color: var(--ivory);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .book-body {
        padding: 1.25rem;
    }
    
    .book-title {
        font-weight: 600;
        color: var(--oxblood);
        margin-bottom: 0.25rem;
    }
    
    .book-author {
        color: var(--deep-teal);
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }
    
    .badge-genre {
        background-color: rgba(138, 155, 138, 0.2);
        color: var(--deep-teal);
        padding: 0.35em 0.65em;
    }
    
    .rating {
        color: #ffc107;
        margin-bottom: 0.5rem;
    }
    
    /* Genre Filter */
    .genre-filter {
        background-color: var(--ivory);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    
    .genre-filter label {
        font-weight: 600;
        color: var(--deep-teal);
        margin-right: 1rem;
    }
    
    .genre-filter select {
        border-color: var(--soft-sage);
        color: var(--charcoal);
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
        }
        .hero-section {
            height: 250px;
        }
        
        .genre-filter {
            width: 100%;
        }
        
        .genre-filter select {
            width: 100%;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">Browse Our Collection</h1>
        <p class="hero-subtitle">Discover thousands of books across all genres</p>
    </div>
</section>

<!-- Main Content -->
<div class="container mb-5">
    <!-- Genre Filter and Results Info -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div class="text-muted mb-3 mb-md-0">
        Showing {{ $books->firstItem() }}-{{ $books->lastItem() }} of {{ $books->total() }} books
    </div>
    
    @if(isset($genres) && $genres->count() > 0)
    <div class="genre-filter">
        <form action="{{ route('all.books') }}" method="GET">
            <label for="genre">Filter by Genre:</label>
            <select name="genre" id="genre" class="form-select" onchange="this.form.submit()">
                <option value="">All Genres</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    @endif
</div>
    
    <!-- Books Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @forelse($books as $book)
            <div class="col">
                <div class="book-card h-100">
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
                        
                        <!-- Rating -->
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
                        
                        <p class="small text-muted mb-2">
                            {{ Str::limit($book->description, 100) }}
                        </p>
                        
                        @if($book->published_year)
                            <p class="small text-muted mb-1">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $book->published_year }}
                            </p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="#" class="text-decoration-none text-muted small">
                                <i class="far fa-comment me-1"></i> 
                                {{ $book->comments_count }} comments
                            </a>
                            <a href="{{ route('books.show.public', $book) }}" class="btn btn-sm btn-outline-primary">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No books found. Check back later!
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $books->appends(request()->query())->links() }}
    </div>
</div>
@endsection