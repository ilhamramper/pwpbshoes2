<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminIndexController extends Controller
{
    public function index(){
    return view('admin.index');
    }
}
