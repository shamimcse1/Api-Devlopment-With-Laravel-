<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

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
    //    try
    //    {
    //     $response = Http::get('http://127.0.0.1:8000/api/index');
    //     $data = json_decode($response->body(), true);
    //     dd($data);
    //    }
    //    catch(\Illuminate\Http\Client\ConnectionException $e){

    //    }
        return view('home');
    }
}
