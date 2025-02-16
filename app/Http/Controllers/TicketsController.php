<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use App\Models\Payments;
use App\Models\Schedules;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketsController extends Controller
{
    /**
     * Display tickets
     *
     * @return \Illuminate\Http\Response
     */
    public function available(Request $request)
    {
        $pickup_id = $request->pickup_id;
        $arrival_time = $request->arrival_time;  
        $destination_id = $request->destination_id;
        $locations = Locations::orderBy('name')->get();

        if ($pickup_id && $arrival_time && $destination_id) {
            $schedules = Schedules::select(
                'schedules.*',
                DB::raw('(schedules.available_seats - COALESCE(SUM(payments.seats_purchased), 0)) as remaining_seats')
            )
                ->leftJoin('payments', 'payments.schedule_id', '=', 'schedules.id')
                ->groupBy('schedules.id')
                ->havingRaw('(schedules.available_seats - COALESCE(SUM(payments.seats_purchased), 0)) > 0')->where('pickup_id', $pickup_id)
                ->whereDate('arrival_time', $arrival_time)
                ->where('destination_id', $destination_id)
                ->get();
        } else {
            $schedules = Schedules::select(
                'schedules.*',
                DB::raw('(schedules.available_seats - COALESCE(SUM(payments.seats_purchased), 0)) as remaining_seats')
            )
                ->leftJoin('payments', 'payments.schedule_id', '=', 'schedules.id')
                ->groupBy('schedules.id')
                ->havingRaw('(schedules.available_seats - COALESCE(SUM(payments.seats_purchased), 0)) > 0')->get();
        }

        return view('pages.tickets.check.index', compact('locations', 'schedules', 'pickup_id', 'arrival_time', 'destination_id'));
    }

    /**
     * Check tickets
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        return redirect()->route('tickets.available', ['pickup_id' => $request->pickup_id, 'arrival_time' => $request->arrival_time, 'destination_id' => $request->destination_id]);
    }

    /**
     * payment tickets
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $validate = $request->validate([
            'schedule_id' => 'required',
            'seats_purchased' => 'required',
            'amount' => 'required',
            'passenger_name' => 'required'
        ]);

        $random_bytes = random_bytes(20);
        Payments::create([
            'user_id' => Auth::user()->id,
            'schedule_id' => $validate['schedule_id'],
            'seats_purchased' => $validate['seats_purchased'],
            'amount' => $validate['amount'],
            'transaction_id' => bin2hex($random_bytes),
            'status' => 'confirmed',
            'passenger_name' => $validate['passenger_name'],
        ]);

        return redirect()->route('tickets.history');
    }

    /**
     * Display the history tickets
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $destination_id = $request->destination_id;
        $locations = Locations::orderBy('name')->get();
        if ($destination_id) {
            $payments = Payments::select('schedules.destination_id', 'schedules.departure_time', 'payments.*')
                ->join('schedules', 'schedules.id', '=', 'payments.schedule_id')
                ->where('user_id', Auth::user()->id)
                ->where('schedules.destination_id', $destination_id)->get();
        } else {
            $payments = Payments::select('schedules.destination_id', 'schedules.departure_time', 'payments.*')
                ->join('schedules', 'schedules.id', '=', 'payments.schedule_id')
                ->where('user_id', Auth::user()->id)->get();
        }
        return view('pages.tickets.history.index', compact('payments', 'locations', 'destination_id'));
    }

    /**
     * find history tickets
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findHistory(Request $request)
    {
        return redirect()->route('tickets.history', ['destination_id' => $request->destination_id]);
    }

    public function invoice($id)
    {
        $payment = Payments::with('schedule', 'user')->find($id);
        return view('pages.tickets.invoices.index', compact('payment'));
    }


    /**
     * Report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Report()
    {
        $payments =  Payments::select(
            'payments.schedule_id',
            'schedules.pickup_id',
            'schedules.arrival_time',
            'schedules.destination_id',
            'schedules.departure_time',
            'schedules.available_seats',
            DB::raw('SUM(payments.seats_purchased) as total_seats_purchased')
        )
        ->join('schedules', 'schedules.id', '=', 'payments.schedule_id')
        ->groupBy('payments.schedule_id', 'schedules.pickup_id', 'schedules.arrival_time', 'schedules.destination_id', 'schedules.departure_time', 'schedules.available_seats')
        ->get();

        // return response()->json($payments);
        return view('pages.tickets.report.index', compact('payments'));
    }
}
