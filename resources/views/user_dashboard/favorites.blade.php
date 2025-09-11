@extends('layouts.master')
@section('title', 'Saved Books | BookHive')

@section('content')
<style>
     /* Sidebar Styles */
    .sidebar {
      width: 250px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
      padding: 1.5rem;
      margin-right: 1.5rem;
      height: fit-content;
    }

    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-menu li {
      margin-bottom: 0.5rem;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: var(--charcoal);
      text-decoration: none;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .sidebar-menu a:hover {
      background-color: rgba(138, 155, 138, 0.1);
      color: var(--deep-teal);
    }

    .sidebar-menu a.active {
      background-color: rgba(138, 155, 138, 0.2);
      color: var(--deep-teal);
      font-weight: 600;
    }

    .sidebar-menu i {
      margin-right: 0.75rem;
      width: 20px;
      text-align: center;
    }
  .dashboard-container{display:flex;min-height:calc(100vh - 72px);margin-top:1rem;}
  .sidebar{width:250px;background:#fff;border-radius:8px;box-shadow:0 3px 10px rgba(0,0,0,.08);padding:1.5rem;margin-right:1.5rem;height:fit-content;}
  .main-content{flex:1;background:#fff;border-radius:8px;box-shadow:0 3px 10px rgba(0,0,0,.08);padding:2rem;}
  .section-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;}
  .section-title{font-family:'Dancing Script',cursive;color:#76323f;font-size:2rem;margin:0;}
  .btn-primary{background:#c76b4a;border-color:#c76b4a;color:#fff;font-weight:600;padding:.6rem 1.2rem;}
  .books-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem;}
  .book-card{border:1px solid #eee;border-radius:8px;overflow:hidden;transition:.2s;}
  .book-card:hover{transform:translateY(-3px);box-shadow:0 5px 15px rgba(0,0,0,.08);}
  .book-cover{width:100%;height:180px;object-fit:cover;border-bottom:1px solid #eee;}
  .book-cover-placeholder{width:100%;height:180px;background:#f8f5f0;display:flex;align-items:center;justify-content:center;color:#8a9b8a;font-size:2rem;border-bottom:1px solid #eee;}
  .book-body{padding:1rem;}
  .book-title{font-weight:600;color:#76323f;margin:0 0 .25rem;font-size:1rem;line-height:1.3;}
  .book-author{color:#2a5c5a;font-size:.9rem;margin-bottom:.5rem;}
  .card-actions{display:flex;gap:.5rem;}
  .btn-view{background:#2a5c5a;color:#fff;border:none;border-radius:6px;padding:.45rem .65rem;font-size:.85rem;text-decoration:none;}
  .btn-fav{background:#f8f5f0;color:#76323f;border:1px solid #76323f;border-radius:6px;padding:.45rem .65rem;font-size:.85rem;display:flex;align-items:center;gap:.35rem;}
  .btn-fav.active{background:#76323f;color:#fff;}
  .empty-state{text-align:center;padding:3rem 0;}
  .empty-state i{font-size:3rem;color:#8a9b8a;margin-bottom:1rem;}
  @media(max-width:992px){.dashboard-container{flex-direction:column}.sidebar{width:100%;margin-right:0;margin-bottom:1.5rem}}

</style>

<div class="dashboard-container container">
  {{-- Sidebar --}}
  @include('user_dashboard.partials.sidebar')

  {{-- Main --}}
  <div class="main-content">
    <div class="section-header">
      <h1 class="section-title">Saved Books</h1>
      <a href="{{ route('all.books') }}" class="btn btn-primary"><i class="fas fa-search me-1"></i> Browse Books</a>
    </div>

    @if($books->count() === 0)
      <div class="empty-state">
        <i class="fas fa-bookmark"></i>
        <h4>No saved books yet</h4>
        <p>Find a book you love and click “Add to Favorites”.</p>
        <a href="{{ route('all.books') }}" class="btn btn-primary mt-2">Discover Books</a>
      </div>
    @else
      <div class="books-grid" id="favorites-grid">
        @foreach($books as $book)
          <div class="book-card" data-book-id="{{ $book->id }}">
            @if($book->image)
              <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="book-cover">
            @else
              <div class="book-cover-placeholder"><i class="fas fa-book"></i></div>
            @endif

            <div class="book-body">
              <div class="book-title">{{ $book->title }}</div>
              <div class="book-author">by {{ $book->author }}</div>

              <div class="card-actions">
                <a href="{{ route('books.show.public', $book) }}" class="btn-view">
                  <i class="fas fa-eye me-1"></i> View
                </a>

                {{-- Toggle favorite --}}
                <button type="button"
                        class="btn-fav favorite-btn active"
                        data-fav-url="{{ route('books.toggle-favorite', $book) }}">
                  <i class="fas fa-heart"></i>
                  <span class="fav-text">Saved</span>
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        {{ $books->links() }}
      </div>
    @endif
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  });

  // Remove / add from Saved (inline)
  $(document).on('click', '.favorite-btn', function (e) {
    e.preventDefault();

    var $btn = $(this);
    var url  = $btn.data('favUrl');
    if (!url || $btn.prop('disabled')) return;

    $btn.prop('disabled', true);

    $.post(url, {}, function (data) {
      if (!data || !data.success) { $btn.prop('disabled', false); return; }

      // If removed, remove the card from the grid
      if (!data.favorited) {
        $btn.closest('.book-card').fadeOut(150, function () {
          $(this).remove();
          if ($('#favorites-grid .book-card').length === 0) {
            location.reload(); // simplest way to show empty-state + reset pagination
          }
        });
      } else {
        // If added (e.g., from other pages), reflect active state
        $btn.addClass('active').find('.fav-text').text('Saved');
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
@endsection
