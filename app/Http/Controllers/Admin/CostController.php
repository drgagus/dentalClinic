<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costs = Cost::paginate(5);
        return view('admin.daftarservice', [
            'costs' => $costs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.forminputservice');
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
            'tindakan' => 'required|max:200',
            'harga' => 'required|integer',
            'doktergigi' => 'required|integer'
        ]);

        Cost::create([
            'tindakan' => $request -> tindakan,
            'harga' => $request -> harga,
            'doktergigi' => $request -> doktergigi,
            'diskon' => $request -> diskon
        ]);

        return redirect('/admin/service')->with('status', 'Jasa/trif baru berhasil ditambahkan');
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
        $service = Cost::findOrFail($id);
        return view('admin.formeditservice', [
            'service' => $service
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
            'tindakan' => 'required|max:200',
            'harga' => 'required|integer',
            'doktergigi' => 'required|integer'
        ]);

        Cost::where('id',$id)->update([
            'tindakan' => $request -> tindakan,
            'harga' => $request -> harga,
            'doktergigi' => $request -> doktergigi,
            'diskon' => $request -> diskon
        ]);

        return redirect('/admin/service')->with('status', 'Jasa/trif berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $cost = Cost::findOrFail($id);
        if (count($cost->dentaltreatments)):
            return redirect('/admin/service')->with('status', 'Gagal dihapus');
        else:
            Cost::destroy($id);
            return redirect('/admin/service')->with('status', 'Berhasil dihapus');
        endif;
    }
}
