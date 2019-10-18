<?php

namespace App\Http\Controllers\Frontend\User;

use App\CancellationRequest;
use App\Http\Controllers\Controller;
use App\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user_searches = UserSearch::where('user_id', Auth::id())->paginate(12);
        return view('frontend.user.dashboard', compact('user_searches'));
    }

    public function requestCancel(Request $request){
        if (isset($request->user_id) && isset($request->agreement_id)){
            $cancel_request = new CancellationRequest();
            $cancel_request->user_id = $request->user_id;
            $cancel_request->agreement_id = $request->agreement_id;

            $cancel_request->save();

            return response()->json([
                "success" => true,
                "status" => "Success",
            ], 200);

        }
        return response()->json([
            "success" => false,
            "status" => "Error",
        ], 200);
    }
}
