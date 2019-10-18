<?php

namespace App\Http\Controllers\Backend;

use App\CancellationRequest;
use App\Http\Controllers\Controller;
use App\Mail\Backend\SendRequestApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class DashboardController.
 */
class RequestController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function requests()
    {
        $cancel_requests = CancellationRequest::where('approved', 0)->paginate(10);

        return view('backend.requests', compact('cancel_requests'));
    }

    public function approveRequest(Request $request){
        $cancel_request = CancellationRequest::findOrFail($request->request_id);
        $cancel_request->approved = 1;
        $saved = $cancel_request->save();
        if (!$saved){
            return response()->json([
                "success" => false,
                "status" => "Error",
            ], 200);
        }
        Mail::to($cancel_request->user->email)->send(new SendRequestApproved($cancel_request));
        return response()->json([
            "success" => true,
            "status" => "Success",
        ], 200);
    }
}
