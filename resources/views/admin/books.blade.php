@extends('layouts.admin')

@section('title', 'Manage Books')

@section('content')
<style>
    /* Admin Panel Specific Styles */
.admin-container {
    padding: 2rem 0;
}

.admin-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.admin-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.admin-card-header {
    background-color: var(--deep-teal);
    color: white;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.admin-card-title {
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
}

.admin-card-body {
    padding: 1.5rem;
}

.admin-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.admin-table th {
    background-color: var(--ivory);
    color: var(--deep-teal);
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid var(--soft-sage);
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.admin-table tr:last-child td {
    border-bottom: none;
}

.admin-table tr:hover td {
    background-color: rgba(138, 155, 138, 0.05);
}

.admin-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-featured {
    background-color: rgba(199, 107, 74, 0.1);
    color: var(--warm-terracotta);
}

.badge-not-featured {
    background-color: rgba(30, 30, 36, 0.1);
    color: var(--charcoal);
}

.badge-active {
    background-color: rgba(42, 92, 90, 0.1);
    color: var(--deep-teal);
}

.badge-blocked {
    background-color: rgba(118, 50, 63, 0.1);
    color: var(--oxblood);
}

.admin-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-feature {
    background-color: var(--warm-terracotta);
    color: white;
}

.btn-feature:hover {
    background-color: #b55d3f;
}

.btn-block {
    background-color: var(--oxblood);
    color: white;
}

.btn-block:hover {
    background-color: #5c2732;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #bb2d3b;
}

.admin-stats-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: transform 0.3s ease;
}

.admin-stats-card:hover {
    transform: translateY(-5px);
}

.admin-stats-icon {
    font-size: 2rem;
    color: var(--warm-terracotta);
    margin-bottom: 1rem;
}

.admin-stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--deep-teal);
    margin-bottom: 0.5rem;
}

.admin-stats-label {
    color: var(--charcoal);
    font-size: 1rem;
    opacity: 0.8;
}

.admin-form-group {
    margin-bottom: 1.5rem;
}

.admin-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--charcoal);
}

.admin-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.admin-form-control:focus {
    border-color: var(--soft-sage);
    box-shadow: 0 0 0 0.2rem rgba(138, 155, 138, 0.25);
    outline: none;
}

.admin-alert {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
}

.alert-success {
    background-color: rgba(42, 92, 90, 0.1);
    color: var(--deep-teal);
    border-left: 4px solid var(--deep-teal);
}

.alert-danger {
    background-color: rgba(118, 50, 63, 0.1);
    color: var(--oxblood);
    border-left: 4px solid var(--oxblood);
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.page-item.active .page-link {
    background-color: var(--deep-teal);
    border-color: var(--deep-teal);
}

.page-link {
    color: var(--deep-teal);
    margin: 0 0.25rem;
    border-radius: 6px !important;
}

.page-link:hover {
    color: var(--warm-terracotta);
}

@media (max-width: 768px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
    
    .admin-card-header {
        padding: 1rem;
    }
    
    .admin-card-body {
        padding: 1rem;
    }
}

</style>
<div class="admin-container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="color: var(--deep-teal); font-family: 'Dancing Script', cursive;">Manage Books</h1>
            <a href="#" class="btn btn-primary" style="background-color: var(--warm-terracotta); border-color: var(--warm-terracotta);">
                <i class="fas fa-plus me-2"></i>Add New Book
            </a>
        </div>
        
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">All Books</h3>
            </div>
            <div class="admin-card-body">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Genre</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>
                                    <strong>{{ $book->title }}</strong>
                                    @if($book->featured)
                                        <span class="badge badge-featured ms-2">Featured</span>
                                    @endif
                                </td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->genre->name ?? '-' }}</td>
                                <td>{{ $book->user->name }}</td>
                                <td>
                                    <span class="badge {{ $book->status ? 'badge-active' : 'badge-not-featured' }}">
                                        {{ $book->status ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Feature --}}
                                        <form action="{{ route('admin.books.feature', $book) }}"
                                                method="POST"
                                                data-ajax
                                                data-action="book-feature">
                                            @csrf
                                            <button type="submit" class="admin-btn btn-feature">
                                                <i class="fas fa-{{ $book->featured ? 'star' : 'star-half-alt' }} me-1"></i>
                                                {{ $book->featured ? 'Unfeature' : 'Feature' }}
                                            </button>
                                        </form>

                                        {{-- Edit --}}
                                        <a href="{{ route('books.edit', $book) }}" class="admin-btn" style="background-color: var(--deep-teal); color: white;">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>

                                        {{-- Delete (AJAX) --}}
                                        <form action="{{ route('admin.books.destroy', $book) }}"
                                                method="POST"
                                                data-ajax
                                                data-action="delete"
                                                data-confirm="Delete this book?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn btn-delete">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection