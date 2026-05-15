<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->latestFirst();

        if ($category = $request->query('categoria')) {
            $query->byCategory($category);
        }

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        $featured = Post::published()->latestFirst()->take(3)->get();

        $availableCategories = Post::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('blog.index', [
            'posts' => $posts,
            'featured' => $featured,
            'availableCategories' => $availableCategories,
            'categoryLabels' => Post::getCategories(),
            'activeCategory' => $category,
            'search' => $search,
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        if ($post->published_at && $post->published_at->isFuture()) {
            abort(404);
        }

        $post->increment('views_count');

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($q) => $q->where('category', $post->category))
            ->latestFirst()
            ->take(3)
            ->get();

        return view('blog.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'categoryLabels' => Post::getCategories(),
        ]);
    }
}
