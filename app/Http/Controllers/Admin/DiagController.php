<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Diag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diags = Diag::orderBy('diagnosa', 'asc')->paginate(5);
        return view('admin/daftardiagnosa', [
            'diags' => $diags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'diagnosa' => 'required'
        ]);

        Diag::create([
            'diagnosa' => $request -> diagnosa
        ]);
        
        return redirect('/admin/diagnosa')->with('status', 'Diagnosa Baru Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diagnosa = Diag::findOrFail($id);
        $diags = Diag::orderBy('diagnosa', 'asc')->paginate(5);
        return view('admin/formeditdiagnosa', [
            'diags' => $diags,
            'diagnosa' => $diagnosa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required'
        ]);

        Diag::where('id',$id)->update([
            'diagnosa' => $request -> diagnosa
        ]);
        
        return redirect('/admin/diagnosa')->with('status', 'Diagnosa berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diag = Diag::findOrFail($id);
        if (count($diag->dentaltreatments)):
            return redirect('/admin/diagnosa')->with('status', 'Gagal dihapus');
        else:
            Diag::destroy($id);
            return redirect('/admin/diagnosa')->with('status', 'Berhasil dihapus');
        endif;
    }
}
