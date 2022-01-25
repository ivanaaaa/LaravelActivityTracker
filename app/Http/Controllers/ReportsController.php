<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Notifications\ReportNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade as PDF;

class ReportsController extends Controller
{

    //filter by date
    public function filter(Request $request)
    {
        $filtered_reports = Activity::where('user_id', Auth::user()->id);
        if ($request->date_from) {
            $date_from = Carbon::parse($request->date_from)->toDateString();
            $filtered_reports->whereDate('activity_date', '>=', $date_from);
        }
        if ($request->date_to) {
            $date_to = Carbon::parse($request->date_to)->toDateString();
            $filtered_reports->whereDate('activity_date', '<=', $date_to);
        }
        return Inertia::render('Reports/Reports', ['reports' => $filtered_reports->paginate(15)]);
//        return Redirect::route('reports',['reports' => $filtered_reports]);
    }


    //send email notification from report
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
        if($request->email_to)
        {
            Notification::route('mail', $notification['email_to'] )
                ->notify((new ReportNotification($notification['date_from'],$notification['date_to'],$token,Auth::user()->id)));
        }
        else
        {
            Auth::user()->notify((new ReportNotification($notification['date_from'],$notification['date_to'],$token,Auth::user()->id)));
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
                $filtered_reports->whereDate('activity_date', '>=', $date_from);
            }
            if ($notification->date_to) {
                $date_to = Carbon::parse($notification->date_to)->toDateString();
                $filtered_reports->whereDate('activity_date', '<=', $date_to);
            }
            return Inertia::render('Reports/MailReport', ['reports' => $filtered_reports->paginate(15)]);
        }
    }

    //print filtered report
    public function printReport(Request $request)
    {
        $filtered_reports = Activity::where('user_id', Auth::user()->id);
        if ($request->from != "null") {
            $date_from = Carbon::parse($request->from)->toDateString();
            $filtered_reports->whereDate('activity_date', '>=', $date_from);
        }
        if ($request->to != "null") {
            $date_to = Carbon::parse($request->to)->toDateString();
            $filtered_reports->whereDate('activity_date', '<=', $date_to);
        }
        $pdf=PDF::loadView('report',[
            'reports' => $filtered_reports->get(['id','activity_date','duration','description'])]);
        // download pdf file
        return $pdf->download('report.pdf');
    }
}
