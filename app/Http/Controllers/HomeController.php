<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', auth()->id())->select([
            'id', 'name', 'email'
        ])->first();

        return view('home', ['user' => $user]);
    }

    /**
     *  to get all messages
     * @return JsonResponse
     */
    public function messages()
    {
        $message = Messages::with('user')->get()->append('time');

        return response()->json($message);
    }

    /**
     * send messages
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function message(Request $request)
    {
        $message = Messages::create([
            'user_id'=> auth()->id(),
            'text'  => $request->text
        ]);

        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => 'Message created succesfully'
        ]);
    }
}
