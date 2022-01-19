<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Notifications\ReportNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function filter(Request $request)
    {
        $filtered_reports = Activity::where('user_id', Auth::user()->id);
        if ($request->date_from) {
            $date_from = Carbon::parse($request->date_from)->toDateString();
            $filtered_reports->whereDate('created_at', '>=', $date_from);
        }
        if ($request->date_to) {
            $date_to = Carbon::parse($request->date_to)->toDateString();
            $filtered_reports->where('created_at', '=<', $date_to);
        }
        return Inertia::render('Reports/Reports', ['reports' => $filtered_reports->get(['id','activity_date','duration','description'])]);
//        return Redirect::route('reports',['reports' => $filtered_reports]);
    }

    public function sendEmailNotification(Request $request){
        Notification::route('mail', $request->email_to )
            ->notify((new ReportNotification($request->date_from,$request->date_to,Str::random(30),Auth::user()->id)));
    }
}
