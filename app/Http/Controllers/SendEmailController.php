<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Branchs;
use App\Models\Department;
use App\Models\mail as ModelsMail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index(Request $request){
        $branch = Branchs::get();
        $department = Department::get();
        $data = ModelsMail::with("department")->with("branch")->get();
        return view('mail.index', compact('data','department', 'branch'));
    }
    public function formCreate(Request $request){
        return view('mail.form_create');
    }
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            ModelsMail::create($data);
            DB::commit();
            return response()->json([
                'message' => "Create created successfully.",
                'status'=>"success"
            ]);
        } catch (\Throwable $exp) {
            DB::rollback();
            return response()->json(['errors' => $exp]);
        }
    }
    public function send(Request $request){
        // $request->validate([
        //     'title'=>'required',
        //     'email'=>'required|email',
        //     'body'=>'required',
        //     'footer'=>'required',
        // ]);
        // dd($request->all());
        // try{
            // Send Email
            $emailData = [
                'message' => 'This is a test email message.'
            ];
            Mail::to($request->email)->send(new SendEmail($emailData));
            DB::commit();
            Toastr::success('Email was sent successfully.','Success');
    }
}
