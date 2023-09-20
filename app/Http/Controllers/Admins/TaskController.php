<?php

namespace App\Http\Controllers\Admins;

use App\Events\FormSubmitted;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Task;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class TaskController extends Controller
{
    public function index (){
        return view('sender');
    }
    public function save_task(Request $request) {
 
        $task = new Task();
        $task->title = $request['title'];
        $task->description = $request['description'];
        $title = $request->title;


        $message = new Message();
        $message->from = Auth::user()->id;
        $id = $message->from;
        $message->message = $title;
        $message->save();

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );


        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        
        $data = ['from' => $id];
        $pusher->trigger('my-channel', 'my-event', $data);


        if($task->save()) {
            Toastr::success('Task Added Successfully.','Success');
            return redirect()->back();
            DB::commit();
            // return response()->json(['status' => true, 'message' => 'Task Added Successfully']);
        }
    }
}
