@extends('layouts.admin')

@section('title', 'Admin Dashboard')

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
        <h1 class="mb-4" style="color: var(--deep-teal); font-family: 'Dancing Script', cursive;">Admin Dashboard</h1>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="admin-stats-card">
                    <div class="admin-stats-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="admin-stats-number">{{ $bookCount }}</div>
                    <div class="admin-stats-label">Total Books</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-stats-card">
                    <div class="admin-stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="admin-stats-number">{{ $userCount }}</div>
                    <div class="admin-stats-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-stats-card">
                    <div class="admin-stats-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="admin-stats-number">{{ $genreCount }}</div>
                    <div class="admin-stats-label">Genres</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">Recent Books</h3>
                    </div>
                    <div class="admin-card-body">
                        @if($recentBooks->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recentBooks as $book)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $book->title }}</strong>
                                        <div class="text-muted small">{{ $book->author }}</div>
                                    </div>
                                    <span class="badge {{ $book->featured ? 'badge-featured' : 'badge-not-featured' }}">
                                        {{ $book->featured ? 'Featured' : 'Regular' }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No recent books found.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h3 class="admin-card-title">Recent Users</h3>
                    </div>
                    <div class="admin-card-body">
                        @if($recentUsers->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recentUsers as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                    <span class="badge {{ $user->is_blocked ? 'badge-blocked' : 'badge-active' }}">
                                        {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No recent users found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection