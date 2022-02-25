<?php

namespace App\Http\Controllers;

use App\Models\Inquire;
use App\Events\MessageSent;
use App\Models\ReplyInquire;
use Illuminate\Http\Request;
use App\Http\Resources\Inquire\InquireCollection;

class MessageController extends Controller
{
    public function list()
    {
        $user = auth()->user();
        $data = Inquire::where('user_id', $user->id)->get();
        $data = new InquireCollection($data);
        return view('frontend.messages', ['data' => $data]);
    }

    public function adminList()
    {
        $data = Inquire::get();
        $data = new InquireCollection($data);
        return view('frontend.messages', ['data' => $data]);
    }

    public function storeReply(Request $request)
    {
        $user = auth()->user();
        $inquire = ReplyInquire::create([
            'message' => $request->input('message'),
            'inquire_id' => $request->input('inquire_id'),
            'user_id' => $user->id
        ]);

        return 'successfully sent';
    }

    public function adminStoreReply(Request $request)
    {
        $user = auth()->user();
        ReplyInquire::create([
            'message' => $request->input('message'),
            'inquire_id' => $request->input('inquire_id'),
            'user_id' => 1
        ]);

        return 'successfully sent';
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $inquire = Inquire::create([
            'message' => $request->input('message'),
            'product_id' => $request->input('product_id'),
            'user_id' => $user->id,
            'unseen' => '1'
        ]);

        broadcast(new MessageSent($inquire))->toOthers();

        return 'successfully sent';
    }

    public function adminInquires()
    {
        $data = Inquire::get();
        return new InquireCollection($data);
    }
}
