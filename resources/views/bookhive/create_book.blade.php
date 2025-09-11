@extends("layouts.master")

@section("title", "Post a Book | BookHive")

@section("content")
<style>
:root {
  --deep-teal: #2a5c5a;
  --warm-terracotta: #c76b4a;
  --ivory: #f8f5f0;
  --oxblood: #76323f;
  --charcoal: #1e1e24;
  --soft-sage: #8a9b8a;
}

.dashboard-container {
  display: flex;
  min-height: calc(100vh - 72px);
  margin-top: 1rem;
}

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

.main-content {
  flex: 1;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.08);
  padding: 2rem;
}

.dashboard-header {
  margin-bottom: 2rem;
}

.dashboard-title {
  font-family: 'Dancing Script', cursive;
  color: var(--oxblood);
  font-size: 2.5rem;
}

.post-book-card {
  background-color: var(--ivory);
  border-radius: 8px;
  padding: 2rem;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.alert {
  padding: 1rem;
  border-radius: 4px;
  margin-bottom: 1.5rem;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}

.alert-danger ul {
  margin-bottom: 0;
  padding-left: 1rem;
}

.form-label {
  font-weight: 500;
  color: var(--deep-teal);
  margin-bottom: 0.5rem;
  display: block;
}

.form-control, .form-select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: white;
  transition: border-color 0.3s;
}

.form-control:focus, .form-select:focus {
  border-color: var(--soft-sage);
  box-shadow: 0 0 0 0.25rem rgba(138, 155, 138, 0.25);
  outline: none;
}

.form-check {
  display: flex;
  align-items: center;
}

.form-check-input {
  margin-right: 0.5rem;
}

.form-check-label {
  color: var(--charcoal);
}

.btn-post {
  background-color: var(--warm-terracotta);
  color: white;
  border: none;
  padding: 0.75rem 2rem;
  border-radius: 4px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-post:hover {
  background-color: #b55d3f;
}

/* Responsive adjustments */
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
  .dashboard-title {
    font-size: 2rem;
  }
  
  .post-book-card {
    padding: 1.5rem;
  }
}
</style>

<div class="dashboard-container container">
  <!-- Sidebar -->
  <div class="sidebar">
    <ul class="sidebar-menu">
      <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
      <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> My Profile</a></li>
      <li><a href="{{ route('mybook') }}"><i class="fas fa-book"></i> My Books</a></li>
      <li><a href="{{ route('bookhive.create') }}" class="active"><i class="fas fa-plus-circle"></i> Post a Book</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-header">
      <h1 class="dashboard-title">Post a New Book</h1>
    </div>

    <div class="post-book-card">
      {{-- Success message --}}
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      {{-- Show validation errors --}}
      @if($errors->any()))
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="postBookForm" method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="bookTitle" class="form-label">Book Title</label>
            <input type="text" class="form-control" name="bookTitle" value="{{ old('bookTitle') }}" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" name="author" value="{{ old('author') }}" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" value="{{ old('isbn') }}">
          </div>
          <div class="col-md-6 mb-3">
            <label for="publishedYear" class="form-label">Published Year</label>
            <input type="number" class="form-control" name="publishedYear" value="{{ old('publishedYear') }}" min="1000" max="{{ date('Y') }}">
          </div>
        </div>

        {{-- Book Image --}}
        <div class="mb-3">
          <label for="bookImage" class="form-label">Book Cover Image</label>
          <input type="file" class="form-control" name="bookImage" accept="image/*">
          <small class="text-muted">Max file size: 2MB (JPEG, PNG, GIF)</small>
        </div>

        <div class="mb-3">
          <label for="genre" class="form-label">Genre</label>
          <select class="form-select" name="genre" required>
            <option value="" disabled {{ old('genre') ? '' : 'selected' }}>Select genre</option>
            @foreach($genres as $genre)
              <option value="{{ $genre->id }}" {{ old('genre') == $genre->id ? 'selected' : '' }}>
                {{ $genre->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" name="tradeOption" value="1" {{ old('tradeOption') ? 'checked' : '' }}>
          <label class="form-check-label">Open to trade offers</label>
        </div>

        <button type="submit" class="btn btn-post">Post Book</button>
      </form>
    </div>
  </div>
</div>
@endsection