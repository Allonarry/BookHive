@extends('layouts.master')

@section('title', 'View Book | BookHive')

@section('content')
<style>
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
            <h1 class="section-title">Book Details</h1>
            <a href="{{ route('mybook') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to My Books
            </a>
        </div>

        <div class="book-detail-card">
            @if($book->image)
                <img src="{{ asset('storage/' . $book->image) }}" alt="Book Cover" class="book-cover-img">
            @else
                <div class="book-placeholder">
                    <i class="fas fa-book"></i>
                </div>
            @endif
            
            <div class="book-info p-4">
                <h2 class="book-title">{{ $book->title }}</h2>
                <p class="book-author">by {{ $book->author }}</p>
                
                <div class="book-meta my-3">
                    <div class="mb-2">
                        <strong>Genre:</strong> {{ $book->genre->name ?? 'N/A' }}
                    </div>
                    @if($book->isbn)
                        <div class="mb-2">
                            <strong>ISBN:</strong> {{ $book->isbn }}
                        </div>
                    @endif
                    @if($book->published_year)
                        <div class="mb-2">
                            <strong>Published Year:</strong> {{ $book->published_year }}
                        </div>
                    @endif
                    <div class="mb-2">
                        <strong>Status:</strong>
                        <span class="book-status {{ $book->status ? 'status-active' : 'status-inactive' }}"> {{ $book->status ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Trade Option:</strong> {{ $book->trade_option ? 'Yes' : 'No' }}
                    </div>
                </div>
                
                <div class="book-description mb-4">
                    <h5>Description</h5>
                    <p>{{ $book->description }}</p>
                </div>
                
                <div class="book-actions d-flex gap-2">
                    <a href="{{ route('books.edit', $book->id) }}" class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-disable" onclick="return confirm('Are you sure you want to delete this book?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection