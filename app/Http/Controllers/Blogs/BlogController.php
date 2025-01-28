<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blogs\BlogRequest;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::get();
        return contentResponse($blogs->load('media'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $blog = Blog::create($request->validated());
        add_media($blog, $request, 'blogs');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return contentResponse($blog->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());
        add_media($blog, $request, 'blogs');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->forceDelete();
        return messageResponse();
    }
}
