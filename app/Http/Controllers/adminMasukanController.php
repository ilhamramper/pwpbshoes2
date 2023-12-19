<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masukan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\view;

class adminMasukanController extends Controller
{
    public function index(){
        $masukans = Masukan::paginate(10);
        return view('admin.masukan.masukan',compact('masukans'));
    }
    
    public function contack(){
        return view('user.contack');
    }
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'nama'             => 'required|min:1',
            'email'     => 'required|min:1',
            'subject'       => 'required|min:1',
            'laporan'        => 'required|min:1'
        ]);

        Masukan::create([

            'nama' => $request->nama,
            'email'     => $request->email,
            'subject'   => $request->subject,
            'laporan' => $request->laporan
             
        ]);

        //kembali ke halaman index
        return redirect()->route('contact')->with(['success' => 'Data Berhasil Disimpan!']);
    }

}
