<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_caption' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'category_id', 'content', 'excerpt', 'image_caption', 'status']);
        $data['user_id'] = Auth::id() ?? 1; // Default to 1 if not logged in
        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        $data['published_at'] = $request->status === 'published' ? now() : null;

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/news'), $filename);
            $data['featured_image'] = 'uploads/news/' . $filename;
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_caption' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'category_id', 'content', 'excerpt', 'image_caption', 'status']);
        
        if ($news->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        }

        if ($request->status === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        } elseif ($request->status === 'draft') {
            $data['published_at'] = null;
        }

        if ($request->hasFile('featured_image')) {
            // Delete old file if exists
            if ($news->featured_image && file_exists(public_path($news->featured_image))) {
                @unlink(public_path($news->featured_image));
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/news'), $filename);
            $data['featured_image'] = 'uploads/news/' . $filename;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->featured_image && file_exists(public_path($news->featured_image))) {
            @unlink(public_path($news->featured_image));
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Buat direktori jika belum ada
            if (!file_exists(public_path('uploads/news/content'))) {
                mkdir(public_path('uploads/news/content'), 0777, true);
            }

            $file->move(public_path('uploads/news/content'), $filename);
            return response()->json(['url' => asset('uploads/news/content/' . $filename)]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
