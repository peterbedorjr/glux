<?php

namespace App\Http\Controllers\Api;

use App\Events\MessagePublished;
use App\Models\Channel;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class ChannelMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        /* @var LengthAwarePaginator $messages */
        $messages = Channel::find($id)
            ->conversation
            ->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $conversationId = Conversation::find($id)->id;

        $message = new Message();
        $message->content = $request->input('message');
        $message->user_id = auth()->user()->id;
        $message->conversation_id = $conversationId;
        $message->save();

        $message = $message->where('id', $message->id)
            ->with('user')
            ->first();

        MessagePublished::dispatch([
            'message' => $message,
        ]);

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
