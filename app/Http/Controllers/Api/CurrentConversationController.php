<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrentConversationController extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        auth()->user()->updateCurrentConversationId(
            $request->input('channelId')
        );
    }
}
