@extends('layouts.master')

@section('title', 'Edit Profile | BookHive')

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

    /* ... (keep all your existing styles, just remove any bio/location specific ones) ... */
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
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-avatar {
            margin-right: 0;
            margin-bottom: 1.5rem;
        }
        
        .avatar-upload {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .avatar-preview {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>

<div class="dashboard-container container">
    <!-- Sidebar -->
    @include('user_dashboard.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar-section">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture" class="profile-avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2a5c5a&color=fff" alt="Profile Picture" class="profile-avatar">
                @endif
            </div>
            
            <div class="profile-info">
                <h2 class="profile-name">{{ auth()->user()->name }}</h2>
                <p class="text-muted">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
            </div>
        </div>

        <!-- Profile Form -->
        <form class="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="avatar-upload">
                <div class="avatar-preview">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" id="avatarPreview" alt="Avatar Preview">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2a5c5a&color=fff" id="avatarPreview" alt="Avatar Preview">
                    @endif
                </div>
                <div class="avatar-upload-btn">
                    <button type="button" class="btn btn-outline">
                        <i class="fas fa-camera me-2"></i> Change Avatar
                    </button>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>

        <!-- Password Update Form -->
        <div class="mt-5 pt-4 border-top">
            <h4 class="mb-4">Change Password</h4>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>

        <!-- Account Deletion -->
        <div class="mt-5 pt-4 border-top">
            <h4 class="mb-4">Delete Account</h4>
            <p class="text-muted mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                Delete Account
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview avatar before upload
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatarPreview').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection