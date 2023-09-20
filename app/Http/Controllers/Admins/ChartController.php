<?php

namespace App\Http\Controllers\Admins;

use App\Events\FormSubmitted;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $users = User::whereNot("emp_status", null)->get();
        return view('charts.index', compact("users"));
    }

    public function broadcast(Request $request)
    {
        broadcast(new FormSubmitted($request->get('message')))->toOthers();

        return view('charts.broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        return view('charts.receive', ['message' => $request->get('message')]);
    }
}
