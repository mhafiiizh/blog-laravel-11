<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

Route::get('/posts', function () {
    $posts = Post::filter(request(['search', 'category', 'author']))->latest()->paginate(7)->withQueryString();

    // dump(vars: request('search'));

    // if (request('search')) {
    //     $posts->where('title', 'LIKE', '%'. request('search'). '%');
    // }

    return view('posts', [
        'title' => 'Blog',
        'posts' => $posts
    ]);
});

Route::get('/posts/{post:slug}', function (Post $post) {

    return view('singlepost', ['title' => 'Single Post', 'post' => $post]);
});

Route::get('/authors/{user:username}', function (User $user) {
    // $post = $user->posts->load(['author', 'category']);

    return view('posts', ['title' => count($user->posts) . ' Articles by ' . $user->name, 'posts' => $user->posts]);
});

Route::get('/categories/{category:slug}', function (Category $category) {
    // $post = $category->posts->load(['author', 'category']);

    return view('posts', ['title' => 'Articles in: ' . $category->name, 'posts' => $category->posts]);
});


Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
});