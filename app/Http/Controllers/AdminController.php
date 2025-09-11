<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage as StorageFacade; // <-- alias to avoid name clashes
use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $bookCount  = Book::count();
        $userCount  = User::count();
        $genreCount = Genre::count();

        $recentBooks = Book::with('user', 'genre')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'bookCount', 'userCount', 'genreCount', 'recentBooks', 'recentUsers'
        ));
    }

    public function books()
    {
        $books = Book::with(['user', 'genre'])->latest()->paginate(10);
        return view('admin.books', compact('books'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function genres()
    {
        $genres = Genre::withCount('books')->latest()->paginate(10);
        return view('admin.genres', compact('genres'));
    }

    public function toggleBlock(User $user, Request $request)
    {
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'ok'        => true,
                'is_blocked'=> $user->is_blocked,
                'message'   => $user->is_blocked ? 'User blocked successfully' : 'User unblocked successfully'
            ]);
        }

        return back()->with('success', $user->is_blocked ? 'User blocked successfully' : 'User unblocked successfully');
    }

    public function toggleFeatured(Book $book, Request $request)
    {
        $book->featured = !$book->featured;
        $book->save();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'ok'       => true,
                'type'     => 'feature_toggled',
                'id'       => $book->id,
                'featured' => (bool) $book->featured,
                'message'  => $book->featured ? 'Book featured successfully' : 'Book unfeatured successfully'
            ]);
        }

        return back()->with('success', $book->featured ? 'Book featured successfully' : 'Book unfeatured successfully');
    }

    public function addGenre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name'
        ]);

        $genre = Genre::create(['name' => $request->name]);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'ok'      => true,
                'genre'   => $genre,
                'message' => 'Genre added successfully'
            ]);
        }

        return back()->with('success', 'Genre added successfully');
    }

    public function deleteGenre(Genre $genre, Request $request)
    {
        if ($genre->books()->count() > 0) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'ok'      => false,
                    'message' => 'Cannot delete genre that has books associated with it'
                ], 422);
            }

            return back()->with('error', 'Cannot delete genre that has books associated with it');
        }

        $genre->delete();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['ok' => true, 'message' => 'Genre deleted successfully']);
        }

        return back()->with('success', 'Genre deleted successfully');
    }

    public function deleteUser(User $user, Request $request)
    {
        if ($user->role === 'admin') {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'ok'      => false,
                    'message' => 'Cannot delete admin users'
                ], 422);
            }

            return back()->with('error', 'Cannot delete admin users');
        }

        $user->delete();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['ok' => true, 'message' => 'User deleted successfully']);
        }

        return back()->with('success', 'User deleted successfully');
    }

    // SINGLE source of truth for book deletion (AJAX + fallback)
    public function destroy(Request $request, Book $book)
    {
        DB::beginTransaction();

        try {
            $id = $book->id;

            // Optional: cleanup files
            if (!empty($book->cover_path) && StorageFacade::exists($book->cover_path)) {
                StorageFacade::delete($book->cover_path);
            }
            if (!empty($book->file_path) && StorageFacade::exists($book->file_path)) {
                StorageFacade::delete($book->file_path);
            }

            // Optional: relations (guard with method_exists so it won't explode if missing)
            if (method_exists($book, 'favorites')) {
                $book->favorites()->detach();
            }
            if (method_exists($book, 'comments')) {
                $book->comments()->delete();
            }

            $book->delete();

            DB::commit();

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'ok'      => true,
                    'id'      => $id,
                    'message' => 'Book deleted'
                ], 200);
            }

            return redirect()->route('admin.books')->with('success', 'Book deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete book failed', ['error' => $e->getMessage(), 'book_id' => $book->id ?? null]);

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'ok'      => false,
                    'message' => 'Failed to delete book. Please try again.'
                ], 500);
            }

            return redirect()->route('admin.books')->with('error', 'Failed to delete book. Please try again.');
        }
    }
}
 