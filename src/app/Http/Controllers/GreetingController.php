<?php

namespace App\Http\Controllers;

use App\Models\Greeting;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    public function index()
    {
        $greetings = Greeting::latest()->get();
        return view('greeting', compact('greetings'));
    }

    public function store(Request $request)
    {
        Greeting::create([
            'name'    => $request->input('name'),
            'message' => $request->input('message'),
        ]);
        return redirect('/greeting');
    }
}
