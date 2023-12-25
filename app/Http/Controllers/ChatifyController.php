<?php

namespace App\Http\Controllers;

use App\Models\Chatify;
use Illuminate\Http\Request;

class ChatifyController extends Controller
{

    public function getUnreadMessages(Request $request)
    {
        if ($request->ajax()) {
            $pesan = Chatify::with('user')->where('to_id', auth()->id())->where('seen', 0)->get();
            return response()->json(['unreadMessages' => $pesan]);

        }
    }

}
