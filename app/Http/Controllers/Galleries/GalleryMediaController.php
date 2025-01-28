<?php

namespace App\Http\Controllers\Galleries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Galleries\GalleryMediaRequest;
use App\Models\Gallery;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class GalleryMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryMediaRequest $request)
    {
        $gallery = Gallery::find($request->validated('gallery_id'));
        add_media($gallery, $request, 'galleries');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function downloadSingle(Media $media)
    {
        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * Display the specified resource.
     */
    public function downloadMultiple(Gallery $gallery)
    {
        $downloads = $gallery->getMedia('galleries');
        return MediaStream::create('my-files.zip')->addMedia($downloads);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $media->forceDelete();
        return messageResponse();
    }
}
