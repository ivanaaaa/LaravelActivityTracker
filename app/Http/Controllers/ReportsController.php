<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Notifications\ReportNotification;
use App\Models\ReportNotification as ReportNotificationModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade as PDF;

class ReportsController extends Controller
{

    //filter
    public function filter(Request $request)
    {
        $filtered_reports = $this->filterByActivityDate($request->date_from, $request->date_to, Auth::user()->id);
        return Inertia::render('Reports/Reports', ['reports' => $filtered_reports->paginate(15)]);
    }


    //send email notification from report
    public function sendEmailNotification(Request $request)
    {
        $notification = $request->all();
        $token = Str::random(30);
        Auth::user()->reportNotification()->create(
            [
                'date_from' => $notification['date_from'],
                'date_to' => $notification['date_to'],
                'token' => $token,
            ]
        );
        if ($request->email_to) {
            Notification::route('mail', $notification['email_to'])
                ->notify((new ReportNotification($notification['date_from'], $notification['date_to'], $token, Auth::user()->id)));
        } else {
            Auth::user()->notify((new ReportNotification($notification['date_from'], $notification['date_to'], $token, Auth::user()->id)));
        }
        $emailAndFilter = new \Illuminate\Http\Request();
        $emailAndFilter->setMethod('POST');
        $emailAndFilter->request->add([
            'date_from' => $notification['date_from'],
            'date_to' => $notification['date_to']
        ]);
        return $this->filter($emailAndFilter);
    }

    //find report from email by token
    public function emailReport(Request $request)
    {
        $notification = ReportNotificationModel::where('token', $request->token)->first();
        if ($notification === null) {
            return Inertia::render('Reports/MailReport', ['reports' => new Activity()]);
        } else {
            $filtered_reports = $this->filterByActivityDate($notification->date_from, $notification->date_to, $notification->user_id);
            return Inertia::render('Reports/MailReport', ['reports' => $filtered_reports->get(['id', 'activity_date', 'duration', 'description'])]);
        }
    }

    //print filtered report
    public function printReport(Request $request)
    {
        $filtered_reports = $this->filterByActivityDate(($request->from != "null") ? $request->from : null, ($request->to != "null") ? $request->to : null, Auth::user()->id);
        $pdf = PDF::loadView('report', [
            'reports' => $filtered_reports->get(['id', 'activity_date', 'duration', 'description'])]);
        // download pdf file
        return $pdf->download('report.pdf');
    }

    public function filterByActivityDate($date_from, $date_to, $user_id)
    {
        $filtered_reports = Activity::where('user_id', $user_id);
        if ($date_from) {
            $date_from_parsed = Carbon::parse($date_from)->toDateString();
            $filtered_reports->whereDate('activity_date', '>=', $date_from_parsed);
        }
        if ($date_to) {
            $date_to_parsed = Carbon::parse($date_to)->toDateString();
            $filtered_reports->whereDate('activity_date', '<=', $date_to_parsed);
        }
        return $filtered_reports;
    }
}
