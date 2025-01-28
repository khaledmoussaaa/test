<?php

namespace App\Http\Controllers\Faqs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faqs\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faqs = Faq::nurseryScope($request)->get();
        return contentResponse($faqs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $faq = Faq::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return contentResponse($faq);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->forceDelete();
        return messageResponse();
    }
}
