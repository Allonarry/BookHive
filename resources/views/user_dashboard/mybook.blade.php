@extends('layouts.master')

@section('title', 'My Books | BookHive')

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
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="{{ route('mybook') }}" class="active"><i class="fas fa-book"></i> My Books</a></li>
            <li><a href="{{ route('bookhive.create') }}"><i class="fas fa-plus-circle"></i> Post a Book</a></li>
            <li><a href=""><i class="fas fa-bookmark"></i> Saved Books</a></li>
            <li><a href=""><i class="fas fa-envelope"></i> Messages</a></li>
            <li><a href=""><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="section-header">
            <h1 class="section-title">My Books</h1>
            <a href="{{ route('bookhive.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Book
            </a>
        </div>

        @if($books->count() > 0)
            <div class="books-grid">
                @foreach($books as $book)
                    <div class="book-card">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="Book Cover" class="book-cover">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        
                        <div class="book-info">
                            <h3 class="book-title">{{ $book->title }}</h3>
                            <p class="book-author">by {{ $book->author }}</p>
                            
                            <div class="book-meta">
                                <span class="book-meta-item">
                                    <i class="fas fa-tag"></i> 
                                    {{ $book->genre->name ?? 'N/A' }}
                                </span>
                                @if($book->published_year)
                                    <span class="book-meta-item">
                                        <i class="fas fa-calendar-alt"></i> 
                                        {{ $book->published_year }}
                                    </span>
                                @endif
                            </div>
                            
                              <span class="book-status {{ $book->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                          {{ $book->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            
                            <div class="book-actions">
                                <a href="{{ route('books.show', $book->id) }}" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                
                                <a href="{{ route('books.edit', $book->id) }}" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <button class="btn-action {{ $book->status === 'active' ? 'btn-disable' : 'btn-enable' }}" 
                                onclick="toggleBookStatus({{ $book->id }})"
                                data-book-id="{{ $book->id }}"
                                data-current-status="{{ $book->status }}">
                                <i class="fas {{ $book->status === 'active' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                {{ $book->status === 'active' ? 'Disable' : 'Enable' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h4>No books posted yet</h4>
                <p>Start sharing your books with the BookHive community!</p>
                <a href="{{ route('bookhive.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Post Your First Book
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function toggleBookStatus(bookId) {
    if (confirm('Are you sure you want to change this book\'s status?')) {
        fetch(`/books/${bookId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const button = document.querySelector(`button[data-book-id="${bookId}"]`);
                const icon = button.querySelector('i');
                const statusBadge = button.closest('.book-card').querySelector('.book-status');
                
                if (data.new_status) {
                    // Update to active state
                    button.classList.remove('btn-enable');
                    button.classList.add('btn-disable');
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    button.innerHTML = button.innerHTML.replace('Enable', 'Disable');
                    
                    statusBadge.classList.remove('status-inactive');
                    statusBadge.classList.add('status-active');
                    statusBadge.textContent = 'Active';
                } else {
                    // Update to inactive state
                    button.classList.remove('btn-disable');
                    button.classList.add('btn-enable');
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    button.innerHTML = button.innerHTML.replace('Disable', 'Enable');
                    
                    statusBadge.classList.remove('status-active');
                    statusBadge.classList.add('status-inactive');
                    statusBadge.textContent = 'Inactive';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'An error occurred while updating the book status');
        });
    }
}
@endsection