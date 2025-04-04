<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $messages += Message::where('sender', $user);
        $messages += Message::where('recipient', $user);

        return json_encode([
            $messages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($messageId)
    {
        $user = Auth::user()->id;
        $message = Message::find($messageId);
        if ($message->sender != $user && $message->reciever != $user){
            return response()->json([
                'error' => [
                    'code' => "INAPROPRIATE_REQUEST",
                    'message' => 'Nincs joga az elem megtakintésére!'
                ]
            ],403);
        }
        if (!empty($message)){
            
            return response()->json($message);
        }
        else {
            return response()->json([
                'error' => [
                    'code' => "INVALID_REQUEST",
                    'message' => 'Az elem nem létezik!'
                ]
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $message = new Message;
        $message->sender = Auth::user()->id();
        $message->subject = $request->input('subject');
        $message->message = $request->input('message');
        $message->recipient = $request->input('recipient');
        $message->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($messageId)
    {
        $user = User::find(Auth::user()->id);
        $message = Message::find($messageId);
        if ($message->sender == $user->id){
            $message->delete();
        }
        if ($message->recipient == $user->id){
            $message->delete();
        }
    }
}
