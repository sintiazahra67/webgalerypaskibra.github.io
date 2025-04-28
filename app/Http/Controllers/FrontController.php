<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BannerAdvertisement;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $categories = Category::all();

        $posts = Post::with(['category'])
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(3)
        ->get();

        $featured_posts = Post::with(['category'])
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->take(3)
        ->get();

        $banner_advertisements =
        BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        // ->take(1)
        ->first();

       $authors = Author::all();

    $aboutus_posts = Post::whereHas('category', function($query){
    $query->where('judul', 'About Us');
    })
    ->where('is_featured', 'not_featured')
    ->latest()
    ->take(6)
    ->get();

    $aboutus_featured_posts = Post::whereHas('category', function($query){
        $query->where('judul', 'About Us');
    })
    ->where('is_featured', 'featured')
    ->inRandomOrder()
    ->first();

    $championship_posts = Post::whereHas('category', function($query){
        $query->where('judul', 'Championship');
    })
    ->where('is_featured', 'not_featured')
    ->latest()
    ->take(6)
    ->get();

    $championship_featured_posts = Post::whereHas('category', function($query){
        $query->where('judul', 'Championship');
    })
    ->where('is_featured', 'featured')
    ->inRandomOrder()
    ->first();

    $activity_posts = Post::whereHas('category', function($query){
        $query->where('judul', 'Activity');
    })
    ->where('is_featured', 'not_featured')
    ->latest()
    ->take(6)
    ->get();

    $activity_featured_posts = Post::whereHas('category', function($query){
        $query->where('judul', 'Activity');
    })
    ->where('is_featured', 'featured')
    ->inRandomOrder()
    ->first();




    $prestasi_posts = Post::whereHas('category', function($query){
        $query->where('judul', 'Prestasi');
    })
    ->where('is_featured', 'not_featured')
    ->latest()
    ->take(3)
    ->get();

    return view('front.index', compact(
        'aboutus_featured_posts',
        'aboutus_posts',
        'championship_featured_posts',
        'championship_posts',
        'activity_featured_posts',
        'activity_posts',
        'categories',
        'authors',
        'posts',
        'featured_posts',
        'banner_advertisements',
        'prestasi_posts'
    ));
}

    public function category(Category $category){
        $categories = Category::all();


        $banner_advertisements = 
        BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        return view('front.category', 
        compact('category', 'categories', 'banner_advertisements'));
    }

    public function author(Author $author){
        $categories = Category::all();

        $authors = $author;

        $banner_advertisements = 
        BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        return view('front.author', 
        compact('categories', 'banner_advertisements', 'authors'));
    }

    public function search(Request $request){
        $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $categories = Category::all();

        $keyword = $request->keyword;

        $posts = Post::with(['category', 'author'])
        ->where('judul', 'like', '%' . $keyword . '%')->paginate(6);

        return view('front.search', 
        compact('posts', 'keyword', 'categories'));
    }

    public function details(Post $post){
        $categories = Category::all();

        $posts = Post::with(['category'])
        ->where('is_featured', 'not_featured')
        ->where('id', '!=', $post->id)
        ->latest()
        ->take(3)
        ->get();

        $banner_advertisements = 
        BannerAdvertisement::where('is_active', 'active')
        ->where('type', 'banner')
        ->inRandomOrder()
        ->first();

        $square_advertisements = 
        BannerAdvertisement::where('type', 'square')
        ->where('is_active', 'active')
        ->inRandomOrder()
        ->first();

        $author_posts = Post::where('author_id', $post->author_id)
        ->where('id', '!=', $post->id)
        ->inRandomOrder()
        ->get();

        return view('front.details', 
        compact('author_posts', 'square_advertisements', 
        'post', 'posts', 'categories', 'banner_advertisements'));
}
}