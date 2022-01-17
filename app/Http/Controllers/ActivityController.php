<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ActivityController extends Controller
{
    //

    public function create()
    {
        return Inertia::render('Contacts/Create', [
            'activities' => Auth::user()->account
                ->activities(),
        ]);
    }

    public function store()
    {
            Auth::user()->activities()->create(
                \Illuminate\Support\Facades\Request::validate([
                    'activity_date' => ['required','date', 'after_or_equal:today'],
                    'duration' => ['required','integer', 'min:0'],
                    'description' => ['required']
                ])
            );
            return Redirect::route('reports')->with('success', 'Contact created.');
    }
}
