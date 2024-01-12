<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceScanController extends Controller
{
    public function index()
    {
        return view('attendance_scan');
    }

    public function store(Request $request)
    {
        if (!Hash::check(date('Y-m-d'), $request->hash_value)) {
            return [
                'status' => 'fail',
                'message' => 'Your QR Code is invalid!',
            ];
        }

        $user = auth()->user();

        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $user->id,
                'date' => now()->format('Y-m-d')
            ]
        );

        if (!is_null($attendance->checkin_time) && !is_null($attendance->checkout_time)) {
            return [
                "status" => 'fail',
                "message" => "Already Checkin and Checkout for Today!",
            ];
        }

        if (is_null($attendance->checkin_time)) {
            $attendance->checkin_time = now();
            $message = "Succesfully Checkin at " . now();
        } else {
            if (is_null($attendance->checkout_time)) {
                $attendance->checkout_time = now();
                $message = "Succesfully Checkout at " . now();
            }
        }

        $attendance->update();

        return [
            'status' => 'success',
            'message' => $message,
        ];
    }
}
