<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\view;
use App\Models\contack;
class contackController extends Controller
{
    public function index(){
        $contacks = contack::paginate(10);
        return view('admin.contack.contack',compact('contacks'));
    }

    public function create(){
        $contacks = contack::all();
        return view('admin.contack.create',compact('contacks'));
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'email'     => 'required|min:1',
            'nomor'       => 'required|min:1',
            'lokasi'        => 'required|min:1'
        ]);

        //upload image
        //buat data
        contack::create([

            'email' => $request->email,
            'nomor'     => $request->nomor,
            'lokasi'   => $request->lokasi
             
        ]);

        //kembali ke halaman index
        return redirect()->route('contack.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        //get post by ID
        $contacks = contack::findOrFail($id);

        //render view with post
        return view('admin.contack.edit', compact('contacks'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'email'     => 'required|min:2',
            'nomor'          => 'required|min:1',
            'lokasi'        => 'required|min:1'
        ]);

        //get data by id
    
        $contacks = contack::findOrFail($id);
            $contacks->update([
                'email'               => $request->email,
                'nomor'              => $request->nomor,
                'lokasi'            => $request->lokasi,
            ]);
                return redirect()->route('contack.index')->with(['success' => 'Data Berhasil Diubah!']);}

    public function destroy($id): RedirectResponse
    {
        //get data by ID
        
        $contacks = contack::findOrFail($id);

        //delete data
        $contacks->delete();

        //kembali ke halaman index
        return redirect()->route('contack.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    
}
