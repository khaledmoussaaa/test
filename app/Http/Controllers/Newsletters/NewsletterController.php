<?php

namespace App\Http\Controllers\Newsletters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletters\NewsletterRequest;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $newsletters = Newsletter::branchScope($request)->classPublicScope($request)->latest()->get();
        return contentResponse($newsletters->load(['nursery', 'media', 'likes', 'class_room:id,name', 'nursery.media']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsletterRequest $request)
    {
        $newsletter = Newsletter::create($request->validated());
        add_media($newsletter, $request, 'newsletters');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Newsletter $newsletter)
    {
        return contentResponse($newsletter->load('media', 'nursery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsletterRequest $request, Newsletter $newsletter)
    {
        $newsletter->update($request->validated());
        add_media($newsletter, $request, 'newsletters');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->forceDelete();
        return messageResponse();
    }
    /**
     * Make like for specific news.
     */
    public function likeOrUnlike(Newsletter $newsletter)
    {
        $like = $newsletter->likes()->firstWhere('user_id', auth_user_id());
        if ($like) {
            $newsletter->decrement('likes_count');
            $like->forceDelete(); // Dislike if already liked
        } else {
            $newsletter->likes()->create(['user_id' => auth_user_id()]); // Like if not already liked
            $newsletter->increment('likes_count');
        }
        return messageResponse();
    }
}
