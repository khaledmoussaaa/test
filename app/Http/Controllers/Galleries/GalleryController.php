<?php

namespace App\Http\Controllers\Galleries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Galleries\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $galleries = Gallery::nurseryScope($request)->get();
        return contentResponse($galleries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryRequest $request)
    {
        $gallery = Gallery::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return contentResponse($gallery->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->forceDelete();
        return messageResponse();
    }
}
