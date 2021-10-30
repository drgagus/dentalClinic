<?php

namespace App\Http\Controllers\Apotek;

use App\Models\Medicine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines = Medicine::orderBy('obat', 'asc')->paginate(5);
        return view('apotek/daftarobat', [
            'medicines' => $medicines
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
            'obat' => 'required',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer'
        ]);

        Medicine::create([
            'obat' => $request -> obat,
            'jumlah' => $request -> jumlah,
            'harga' => $request -> harga,
            'aktif' => $request -> aktif
        ]);
        
        return redirect('/apotek/obat')->with('status', 'Obat Baru Berhasil Ditambahkan.');
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
        $medicines = Medicine::orderBy('obat', 'asc')->paginate(5);
        $obat = Medicine::findOrFail($id);
        return view('apotek/formeditobat', [
            'obat' => $obat,
            'medicines' => $medicines
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
        $obat = Medicine::findOrFail($id);

        $request->validate([
            'obat' => 'required',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer'
        ]);
        
        Medicine::where('id', $id)->update([
            'obat' => $request -> obat,
            'jumlah' => $request -> jumlah,
            'harga' => $request -> harga,
            'aktif' => $request -> aktif
        ]);
        
        return redirect('/apotek/obat')->with('status', 'Obat berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
