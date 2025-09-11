<?php

namespace App\Http\Controllers\book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Get featured books (you can add a 'featured' column to your books table)
    $featuredBooks = Book::where('featured', true)
                    ->with('genre')
                    ->withCount('comments')
                    ->limit(4)
                    ->get();

    $testimonials = [
        [
            'rating' => 5,
            'text' => "BookHive helped me discover authors I never would have found on my own...",
            'name' => "Sarah Johnson",
            'role' => "Avid Reader",
            'image' => "https://randomuser.me/api/portraits/women/32.jpg"
        ],
        [
            'rating' => 5,
            'text' => "I've doubled my reading since joining. The challenges keep me motivated and the discussions are so enriching.",
            'name' => "Michael Zaheer",
            'role' => "Avid Reader",
            'image' => "https://randomuser.me/api/portraits/men/45.jpg"
        ],
        [
            'rating' => 5,
            'text' => "As an author, I love connecting with my readers through BookHive. The community is engaged and thoughtful",
            'name' => "Priya Patel", // Added missing name
            'role' => "Author",
            'image' => "https://randomuser.me/api/portraits/women/68.jpg" // Changed image to match the one from your earlier example
        ],
    ];

    return view("bookhive.index", compact('featuredBooks', 'testimonials'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        $books = Book::where('user_id', Auth::id())->with('genre')->get();
        return view("bookhive.create_book", compact("genres", "books"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bookTitle' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'publishedYear' => 'nullable|integer|min:1000|max:' . date("Y"),
            'genre' => 'required|exists:genres,id',
            'description' => 'required|string',
            'tradeOption' => 'nullable|boolean',
            'bookImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = $request->file('bookImage')->store('book-covers', 'public');

        Book::create([
            'title' => $validated['bookTitle'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'published_year' => $validated['publishedYear'] ?? null,
            'genre_id' => $validated['genre'],
            'description' => $validated['description'],
            'trade_option' => $request->has('tradeOption'),
            'user_id' => Auth::id(),
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('mybook')->with('success', 'Book posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with('genre')->findOrFail($id);
        
        // Ensure the user can only view their own books
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user_dashboard.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $genres = Genre::all();
        
        // Ensure the user can only edit their own books
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user_dashboard.edit', compact('book', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        
        // Ensure the user can only update their own books
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'bookTitle' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'publishedYear' => 'nullable|integer|min:1000|max:' . date("Y"),
            'genre' => 'required|exists:genres,id',
            'description' => 'required|string',
            'tradeOption' => 'nullable|boolean',
            'bookImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload if new image is provided
        if ($request->hasFile('bookImage')) {
            // Delete old image if it exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $imagePath = $request->file('bookImage')->store('book-covers', 'public');
            $validated['image'] = $imagePath;
        }

        $book->update([
            'title' => $validated['bookTitle'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'published_year' => $validated['publishedYear'] ?? null,
            'genre_id' => $validated['genre'],
            'description' => $validated['description'],
            'trade_option' => $request->has('tradeOption'),
            'image' => $validated['image'] ?? $book->image,
        ]);

        return redirect()->route('mybook')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        
        // Ensure the user can only delete their own books
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete associated image if it exists
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('mybook')->with('success', 'Book deleted successfully!');
    }

    public function homepage()
    {
        return view("book.index");
    }

    // a method that returns user own books
    public function mybook()
    {
        $books = Book::where('user_id', Auth::id())->with('genre')->get();
        return view("user_dashboard.mybook", compact('books'));
    }

    public function dashboard()
    {
        $books = Book::where('user_id', Auth::id())
                ->with('genre')
                ->latest()
                ->get();

        $books_count = $books->count();

        return view('user_dashboard.dashboard', compact('books', 'books_count'));
    }

   public function toggleStatus($id)
{
    try {
        $book = Book::where('user_id', Auth::id())->findOrFail($id);
        
        // Toggle between 'active' and 'disable'
        $book->status = $book->status === 'active' ? 'disable' : 'active';
        $book->save();

        return response()->json([
            'success' => true,
            'new_status' => $book->status === 'active',
            'message' => 'Book status updated successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function allBooks()
{
    $genres = Genre::orderBy('name')->get();
    
    $books = Book::where('status', 'active')
                ->with('genre', 'user')
                ->withCount('comments')
                ->when(request('genre'), function($query) {
                    $query->whereHas('genre', function($q) {
                        $q->where('id', request('genre'));
                    });
                })
                ->latest()
                ->paginate(12);
    
    return view('bookhive.all_books', compact('books', 'genres'));
}

// Add this method to your existing controller
public function showPublic(Book $book)
{
    $book->load([
        'genre', 
        'comments' => function($query) {
            $query->with(['user', 'likes'])->latest();
        }
    ])->loadCount('comments');
    
    return view('bookhive.book_details', compact('book'));
}

public function storeComment(Request $request, $bookId)
{
    $validated = $request->validate([
    'content' => 'required|string|max:1000',
    'rating' => 'required|integer|between:1,5',
    'contains_spoiler' => 'nullable|boolean',
]);

    $book = Book::findOrFail($bookId);

    $book->comments()->create([
    'content' => $validated['content'],
    'rating' => $validated['rating'],
    'contains_spoiler' => $validated['contains_spoiler'],
    'user_id' => auth()->id(),
]);

    return redirect()->back()->with('success', 'Review added successfully!');
}

public function toggleLike(Request $request, Comment $comment)
{
    // Log the incoming request for debugging
    \Log::info('Toggle like request received', [
        'comment_id' => $comment->id,
        'user_id' => auth()->id(),
        'request_method' => $request->method(),
        'request_headers' => $request->headers->all()
    ]);

    // Check authentication
    if (!auth()->check()) {
        \Log::warning('Unauthenticated like attempt');
        return response()->json([
            'success' => false,
            'message' => 'You must be logged in to like comments'
        ], 401);
    }

    try {
        $userId = auth()->id();
        
        // Check if user already liked this comment
        $existingLike = $comment->likes()->where('user_id', $userId)->first();
        $liked = false;

        if ($existingLike) {
            // Unlike: Remove the existing like
            $existingLike->delete();
            $liked = false;
            \Log::info('Comment unliked', ['comment_id' => $comment->id, 'user_id' => $userId]);
        } else {
            // Like: Create new like
            $comment->likes()->create([
                'user_id' => $userId
            ]);
            $liked = true;
            \Log::info('Comment liked', ['comment_id' => $comment->id, 'user_id' => $userId]);
        }

        // Get updated likes count
        $likesCount = $comment->likes()->count();

        $response = [
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount,
            'message' => $liked ? 'Comment liked' : 'Comment unliked'
        ];

        \Log::info('Toggle like response', $response);

        return response()->json($response);

    } catch (\Exception $e) {
        \Log::error('Error toggling like', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'comment_id' => $comment->id,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while processing your request'
        ], 500);
    }
}

public function toggleFavorite(Request $request, Book $book)
{
    $user = auth()->user();

    $exists = $user->favoriteBooks()->where('book_id', $book->id)->exists();

    if ($exists) {
        $user->favoriteBooks()->detach($book->id);
        $favorited = false;
    } else {
        $user->favoriteBooks()->attach($book->id);
        $favorited = true;
    }

    $count = $book->favoritedBy()->count();

    return response()->json([
        'success' => true,
        'favorited' => $favorited,
        'favorites_count' => $count,
    ]);
}


public function favorites()
{
    $books = auth()->user()
        ->favoriteBooks()
        ->with('genre')
        ->withCount('comments')
        ->orderByDesc('book_favorites.created_at')  // show most recently saved first
        ->paginate(12);

    return view('user_dashboard.favorites', compact('books'));
}



public function browse()
{
    $genres = Genre::orderBy('name')->get();
    
    $books = Book::with(['genre', 'comments'])
                ->when(request('genre'), function($query) {
                    // Get the genre ID from the name
                    $genre = Genre::where('name', request('genre'))->first();
                    if ($genre) {
                        $query->where('genre_id', $genre->id);
                    }
                })
                ->paginate(12);
    
    return view('all.books', compact('books', 'genres'));
}

public function subscribeToNewsletter(Request $request)
{
    $validated = $request->validate([
        'email' => ['required','email','max:255'],
        'website' => ['nullable','size:0'], // honeypot must stay empty
    ], [
        'website.size' => 'Spam detected.',
    ]);

    // Optional: save to DB
    // NewsletterSubscriber::firstOrCreate(['email' => $validated['email']]);

    // Send welcome/confirm email (queue if you’ve set up a worker)
    try {
        if (config('queue.default') !== 'sync') {
            Mail::to($validated['email'])->queue(new NewsletterWelcome($validated['email']));
        } else {
            Mail::to($validated['email'])->send(new NewsletterWelcome($validated['email']));
        }
    } catch (\Throwable $e) {
        \Log::error('Newsletter email failed', ['error' => $e->getMessage()]);
        if ($request->expectsJson()) {
            return response()->json(['ok' => false, 'success' => false, 'message' => 'Subscription saved, but email failed.'], 500);
        }
        return back()->with('error', 'Subscription saved, but we could not send the email. Please try again later.');
    }

    // JSON for your global AJAX handler (it accepts ok or success)
    if ($request->expectsJson()) {
        return response()->json(['ok' => true, 'success' => true, 'message' => 'Thanks for subscribing! Please check your email.']);
    }

    // normal non-AJAX flow
    return back()->with('success', 'Thanks for subscribing! Please check your email.');
}

}