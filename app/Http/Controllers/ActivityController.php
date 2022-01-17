<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ActivityController extends Controller
{
    //

    public function create()
    {
        return Inertia::render('Contacts/Create', [
            'activities' => Auth::user()
                ->activities(),
        ]);
    }
}
