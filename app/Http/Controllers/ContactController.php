<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contack;
use App\Models\masukan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\view;

class ContactController extends Controller
{
    public function contact()
    {
        $contacks = contack::paginate(1);
        return view('user.contact',compact('contacks'));
    }
    //masukan
   
}
