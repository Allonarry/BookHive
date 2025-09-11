<div class="sidebar">
  <ul class="sidebar-menu">
    <li>
      <a href="{{ route('dashboard') }}"
         @class(['active' => request()->routeIs('dashboard')])>
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>

    <li>
      <a href="{{ route('profile.edit') }}"
         @class(['active' => request()->routeIs('profile.*')])>
        <i class="fas fa-user"></i> My Profile
      </a>
    </li>

    <li>
      <a href="{{ route('mybook') }}"
         @class(['active' => request()->routeIs(['mybook','books.*'])])>
        <i class="fas fa-book"></i> My Books
      </a>
    </li>

    <li>
      <a href="{{ route('bookhive.create') }}"
         @class(['active' => request()->routeIs('bookhive.create')])>
        <i class="fas fa-plus-circle"></i> Post a Book
      </a>
    </li>

    <li>
      <a href="{{ route('favorites.index') }}"
         @class(['active' => request()->routeIs('favorites.*')])>
        <i class="fas fa-bookmark"></i> Saved Books
      </a>
    </li>

    <li>
      <a href="#"
         @class(['active' => request()->routeIs('messages.*')])>
        <i class="fas fa-envelope"></i> Messages
      </a>
    </li>

    <li>
      <a href="#"
         @class(['active' => request()->routeIs('settings.*')])>
        <i class="fas fa-cog"></i> Settings
      </a>
    </li>
  </ul>
</div>
