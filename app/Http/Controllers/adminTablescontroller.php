<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\view;

class adminTablescontroller extends Controller
{
    public function index(){
    $users = User::paginate(10);
    return view('admin.DataUser.datauser',compact('users'));
    }

    public function create(){
        $users = User::all();
        return view('admin.DataUser.create',compact('users'));
    }
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'id'             => 'required|min:1',
            'nama'     => 'required|min:1',
            'email'       => 'required|min:1',
            'password'        => 'required|min:1'
        ]);

        //upload image
        //buat data
        User::create([

            'id' => $request->id,
            'name'     => $request->nama,
            'email'   => $request->email,
            'password' => $request->password
             
        ]);

        //kembali ke halaman index
        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        //get post by ID
        $users = User::findOrFail($id);

        //render view with post
        return view('admin.DataUser.edit', compact('users'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'id'             => 'required|min:1',
            'nama'     => 'required|min:2',
            'email'          => 'required|min:1',
            'password'        => 'required|min:1'
        ]);

        //get data by id
    
        $users = User::findOrFail($id);
            $users->update([
                'id'                 => $request->id,
                'name'               => $request->nama,
                'email'              => $request->email,
                'password'            => $request->password,
            ]);
                return redirect()->route('user.index')->with(['success' => 'Data Berhasil Diubah!']);}
    

    public function destroy($id): RedirectResponse
    {
        //get data by ID
        
        $users = User::findOrFail($id);

        //delete data
        $users->delete();

        //kembali ke halaman index
        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
