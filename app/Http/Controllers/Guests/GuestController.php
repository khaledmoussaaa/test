<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use App\Models\Nursery;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search query from the request
        $nurseries = Nursery::where('status', 'approved')
            ->when($search, function ($query, $search) {
                $query->whereLike('name', "%$search%")
                    ->orWhereLike('email', "%$search%")
                    ->orWhereLike('phone', "%$search%")
                    ->orWhereLike('address', "%$search%")
                    ->orWhereLike('country', "%$search%")
                    ->orWhereLike('city', "%$search%");
            })
            ->get();

        return contentResponse($nurseries->load('media', 'branches'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Nursery $nursery)
    {
        $nursery->rates = round((float) $nursery->reviews()->avg('rate'), 1);
        return contentResponse($nursery->load('media', 'services', 'contacts', 'reviews.user.media', 'branches'));
    }
}
