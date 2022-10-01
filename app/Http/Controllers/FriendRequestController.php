<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Message;
use App\FriendRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FriendRequestController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function sendFriendRequest(Request $request) {
        $friendRequest = FriendRequest::create([
            'from' => auth()->user()->username,
            'to' => $request->input('to'),
        ]);
    }
}