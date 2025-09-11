@extends('layouts.master')

@section('title', 'Book Details | BookHive')

@section('styles')
<style>
    .book-cover-large {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .book-title {
        font-family: 'Dancing Script', cursive;
        color: var(--oxblood);
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .book-author {
        color: var(--deep-teal);
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .rating {
        color: #ffc107;
        margin-bottom: 1rem;
    }

    .badge-genre {
        background-color: rgba(138, 155, 138, 0.2);
        color: var(--deep-teal);
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .book-meta p {
        margin-bottom: 0.5rem;
    }

    .btn-like {
        background-color: var(--ivory);
        color: var(--oxblood);
        border: 1px solid var(--oxblood);
        padding: 0.5rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .btn-like:hover {
        background-color: var(--oxblood);
        color: white;
    }

    .book-description {
        line-height: 1.8;
        margin-bottom: 3rem;
    }

    .comments-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .comment {
        padding: 1.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .comment-user {
        font-weight: 600;
        color: var(--oxblood);
    }

    .comment-date {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .comment-text {
        margin: 1rem 0;
    }

    .like-btn {
        background: none;
        border: none;
        color: #6c757d;
        padding: 0;
        margin-right: 1rem;
    }

    .like-btn:hover {
        color: var(--oxblood);
    }

    .like-btn.liked {
        color: var(--oxblood);
    }

    .rating.small {
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<div class="container my-5">
    <!-- Book Header -->
    <div class="book-header">
        <div class="row">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" 
                         class="book-cover-large" alt="{{ $book->title }}">
                @else
                    <div class="book-cover-placeholder">
                        <i class="fas fa-book-open fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h1 class="book-title">{{ $book->title }}</h1>
                <p class="book-author">by {{ $book->author }}</p>
                <div class="rating mb-3">
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
                    <span class="ms-1">{{ number_format($rating, 1) }} ({{ $book->reviews_count }} ratings)</span>
                </div>
                
                @if($book->genre)
                    <span class="badge badge-genre mb-3">{{ $book->genre->name }}</span>
                @endif
                
                <div class="book-meta">
                    @if($book->published_year)
                        <p><strong>Published:</strong> {{ $book->published_year }}</p>
                    @endif
                    @if($book->isbn)
                        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                    @endif
                </div>
                
                @auth
                <button type="button" class="btn-like favorite-btn {{ !empty($isFavorited) && $isFavorited ? 'active' : '' }}" data-fav-url="{{ route('books.toggle-favorite', $book) }}">
                <i class="fas fa-heart me-1"></i>
                <span class="fav-text">{{ (!empty($isFavorited) && $isFavorited) ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                </button>
                @endauth

                
                <div class="book-description">
                    <p>{{ $book->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
        <h3 class="mb-4"><i class="far fa-comments me-2"></i>Community Reviews ({{ $book->comments_count }})</h3>
        
        <!-- Comment Form -->
        @auth
        <div class="comment-form">
            <h5 class="mb-3">Add Your Review</h5>
            <form action="{{ route('books.comments.store', $book->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" name="content" rows="4" placeholder="Share your thoughts about this book..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select class="form-select" name="rating" id="rating" required>
                        <option value="">Select rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="spoilerWarning" name="contains_spoiler" value="1">
                        <label class="form-check-label" for="spoilerWarning">Contains spoilers</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Review</button>
                </div>
            </form>
        </div>
        @else
        <div class="alert alert-info">
            Please <a href="{{ route('login') }}">login</a> to leave a review.
        </div>
        @endauth

        <!-- Comments List -->
       <div class="comments-list mt-5">
    @forelse($book->comments as $comment)
        <div class="comment">
    <div class="d-flex justify-content-between">
        <div class="comment-user">{{ $comment->user->name }}</div>
        <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
    </div>
    <div class="rating small my-2">
        @for($i = 1; $i <= 5; $i++)
            <i class="{{ $i <= $comment->rating ? 'fas' : 'far' }} fa-star"></i>
        @endfor
    </div>
    <div class="comment-text">
        @if($comment->contains_spoiler)
            <p class="text-danger"><strong>Warning: Contains Spoilers</strong></p>
        @endif
        <p>{{ $comment->content }}</p>
    </div>

    @auth
    <div class="comment-actions mt-2">
        <button type="button"
        class="like-btn {{ $comment->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}"
        data-comment-id="{{ $comment->id }}"
        data-like-url="{{ route('comments.toggle-like', $comment) }}">
  <i class="{{ $comment->likes->contains('user_id', auth()->id()) ? 'fas' : 'far' }} fa-thumbs-up"></i>
  <span class="like-count">{{ $comment->likes->count() }}</span>
</button>

    </div>
    @endauth
</div>

    @empty
        <div class="alert alert-info">
            No reviews yet. Be the first to review!
        </div>
    @endforelse
</div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
  // Send CSRF + JSON headers with every AJAX call
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  });

  // Like / Unlike (event delegation)
  $(document).on('click', '.like-btn', function (e) {
    e.preventDefault();

    var $btn = $(this);
    var url  = $btn.data('likeUrl');
    if (!url || $btn.prop('disabled')) return;

    $btn.prop('disabled', true);

    $.post(url, {}, function (data) {
      if (!data || !data.success) { $btn.prop('disabled', false); return; }

      var liked   = !!data.liked;
      var $icon   = $btn.find('i');
      var $count  = $btn.find('.like-count');

      $btn.toggleClass('liked', liked);
      $icon.toggleClass('fas', liked).toggleClass('far', !liked);
      if ($count.length) $count.text(data.likes_count);

      $btn.prop('disabled', false);
    }, 'json').fail(function (xhr) {
      if (xhr.status === 401) {
        window.location.href = "{{ route('login') }}";
        return;
      }
      $btn.prop('disabled', false);
    });
  });
});


$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  });

  $(document).on('click', '.favorite-btn', function (e) {
    e.preventDefault();

    var $btn = $(this);
    var url  = $btn.data('favUrl');
    if (!url || $btn.prop('disabled')) return;

    $btn.prop('disabled', true);

    $.post(url, {}, function (data) {
      if (!data || !data.success) { $btn.prop('disabled', false); return; }

      var favorited = !!data.favorited;

      $btn.toggleClass('active', favorited);
      $btn.find('.fav-text').text(favorited ? 'Remove from Favorites' : 'Add to Favorites');

      var $count = $('.favorites-count');
      if ($count.length && typeof data.favorites_count !== 'undefined') {
        $count.text(data.favorites_count);
      }

      $btn.prop('disabled', false);
    }, 'json').fail(function (xhr) {
      if (xhr.status === 401) {
        window.location.href = "{{ route('login') }}";
        return;
      }
      $btn.prop('disabled', false);
    });
  });
});
</script>