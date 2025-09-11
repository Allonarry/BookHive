@extends('layouts.master')

@section('title', 'Edit Book | BookHive')

@section('content')
<style>
    /* Add any additional styles you need here */
    .book-form-container {
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        padding: 2rem;
    }
    .current-image {
        max-width: 200px;
        border-radius: 4px;
        margin-top: 10px;
    }
    /* Add any additional styles you need here */
    .book-detail-card {
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .book-cover-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
    .book-placeholder {
        width: 100%;
        height: 300px;
        background-color: #f8f5f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8a9b8a;
        font-size: 3rem;
    }

    :root {
      --deep-teal: #2a5c5a;
      --warm-terracotta: #c76b4a;
      --ivory: #f8f5f0;
      --oxblood: #76323f;
      --charcoal: #1e1e24;
      --soft-sage: #8a9b8a;
    }

    /* Dashboard Layout */
    .dashboard-container {
      display: flex;
      min-height: calc(100vh - 72px);
      margin-top: 1rem;
    }

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

    /* Main Content Styles */
    .main-content {
      flex: 1;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
      padding: 2rem;
    }

    /* Books Section */
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .section-title {
      font-family: 'Dancing Script', cursive;
      color: var(--oxblood);
      font-size: 2rem;
      margin: 0;
    }

    .btn-primary {
      background-color: var(--warm-terracotta);
      border-color: var(--warm-terracotta);
      color: white;
      font-weight: 600;
      padding: 0.75rem 1.5rem;
    }

    .btn-primary:hover {
      background-color: #b55d3f;
      border-color: #b55d3f;
    }

    .books-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
    }

    .book-card {
      border: 1px solid #eee;
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .book-cover {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 1px solid #eee;
    }

    .book-cover-placeholder {
      width: 100%;
      height: 200px;
      background-color: var(--ivory);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--soft-sage);
      font-size: 3rem;
    }

    .book-info {
      padding: 1.25rem;
    }

    .book-title {
      font-weight: 600;
      color: var(--oxblood);
      margin-bottom: 0.25rem;
      font-size: 1.1rem;
    }

    .book-author {
      color: var(--deep-teal);
      font-size: 0.9rem;
      margin-bottom: 0.75rem;
    }

    .book-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      margin-bottom: 0.75rem;
      font-size: 0.85rem;
    }

    .book-meta-item {
      display: flex;
      align-items: center;
      color: #666;
    }

    .book-meta-item i {
      margin-right: 0.25rem;
      color: var(--soft-sage);
    }

    .book-status {
      display: inline-block;
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.8rem;
      font-weight: 500;
      margin-bottom: 1rem;
    }

    .status-active {
      background-color: rgba(138, 155, 138, 0.2);
      color: var(--deep-teal);
    }

    .status-inactive {
      background-color: rgba(119, 119, 119, 0.1);
      color: #666;
    }

    .book-actions {
      display: flex;
      gap: 0.5rem;
    }

    .btn-action {
      flex: 1;
      padding: 0.5rem;
      border: none;
      border-radius: 4px;
      font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-action i {
      margin-right: 0.25rem;
    }

    .btn-view {
      background-color: var(--deep-teal);
      color: white;
    }

    .btn-view:hover {
      background-color: #1e4b49;
    }

    .btn-edit {
      background-color: var(--soft-sage);
      color: white;
    }

    .btn-edit:hover {
      background-color: #798d79;
    }

    .btn-disable {
      background-color: #f8f5f0;
      color: var(--charcoal);
    }

    .btn-disable:hover {
      background-color: #e8e5e0;
    }

    .btn-enable {
      background-color: #f8f5f0;
      color: var(--deep-teal);
    }

    .btn-enable:hover {
      background-color: #e8e5e0;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 3rem 0;
    }

    .empty-state-icon {
      font-size: 3rem;
      color: var(--soft-sage);
      margin-bottom: 1rem;
    }

    .empty-state h4 {
      color: var(--oxblood);
      margin-bottom: 0.5rem;
    }

    .empty-state p {
      color: #666;
      margin-bottom: 1.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .dashboard-container {
        flex-direction: column;
      }
      
      .sidebar {
        width: 100%;
        margin-right: 0;
        margin-bottom: 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .section-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .section-header .btn {
        margin-top: 1rem;
        width: 100%;
      }
    }

    @media (max-width: 576px) {
      .books-grid {
        grid-template-columns: 1fr;
      }
    }

</style>

<div class="dashboard-container container">
    <!-- Sidebar -->
    @include('user_dashboard.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <div class="section-header">
            <h1 class="section-title">Edit Book</h1>
            <a href="{{ route('mybook') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to My Books
            </a>
        </div>

        <div class="book-form-container">
            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="bookTitle" class="form-label">Book Title</label>
                    <input type="text" class="form-control" id="bookTitle" name="bookTitle" value="{{ old('bookTitle', $book->title) }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="isbn" class="form-label">ISBN (optional)</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="publishedYear" class="form-label">Published Year (optional)</label>
                        <input type="number" class="form-control" id="publishedYear" name="publishedYear" 
                               value="{{ old('publishedYear', $book->published_year) }}"
                               min="1000" max="{{ date('Y') }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select class="form-select" id="genre" name="genre" required>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre', $book->genre_id) == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $book->description) }}</textarea>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="tradeOption" name="tradeOption" 
                           {{ old('tradeOption', $book->trade_option) ? 'checked' : '' }}>
                    <label class="form-check-label" for="tradeOption">Available for trade</label>
                </div>
                
                <div class="mb-4">
                    <label for="bookImage" class="form-label">Book Cover Image</label>
                    <input type="file" class="form-control" id="bookImage" name="bookImage">
                    @if($book->image)
                        <div class="mt-2">
                            <small>Current image:</small><br>
                            <img src="{{ asset('storage/' . $book->image) }}" class="current-image">
                        </div>
                    @endif
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection