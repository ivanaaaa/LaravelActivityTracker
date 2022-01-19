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
        $notification = $request->all();
        $token = Str::random(30);
        Auth::user()->reportNotification()->create(
            [
                'date_from' => $notification['date_from'],
                'date_to' => $notification['date_to'],
                'token' => $token,
            ]
        );
        Notification::route('mail', $notification['email_to'] )
            ->notify((new ReportNotification($notification['date_from'],$notification['date_to'],$token,Auth::user()->id)));
    }
    public function emailReport(Request $request){
        $notification = \App\Models\ReportNotification::where('token',$request->token)->first();
        if ($notification === null)
        {
           return Inertia::render('Reports/MailReport',['reports'=>new Activity()]);
        }
        else
        {
            $filtered_reports = Activity::where('user_id', $notification->user_id);
            if ($notification->date_from) {
                $date_from = Carbon::parse($notification->date_from)->toDateString();
                $filtered_reports->whereDate('created_at', '>=', $date_from);
            }
            if ($notification->date_to) {
                $date_to = Carbon::parse($notification->date_to)->toDateString();
                $filtered_reports->where('created_at', '=<', $date_to);
            }
            return Inertia::render('Reports/MailReport', ['reports' => $filtered_reports->get(['id','activity_date','duration','description'])]);
        }
    }
}
