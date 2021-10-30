<?php

namespace App\Http\Controllers\Kasir;

use App\Models\Customer;
use App\Models\Cost;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Medicinerecord;
use App\Models\Dentaltreatment;
use App\Models\Dentalrecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dentalrecords = Dentalrecord::where('tanggalkunjungan', date('Y-m-d'))->get();
        return view('kasir.daftarpasien', [
            'dentalrecords' => $dentalrecords
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan',date('Y-m-d'))->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', 4)->firstOrFail();
        return view('kasir.detailpembayaran', [
            'patient' => $patient,
            'dentalrecord' => $dentalrecord,
            'dentaltreatments' => $dentaltreatments,
            'medicinerecords' => $medicinerecords
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan',date('Y-m-d'))->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', '<', 4)->firstOrFail();
        return view('kasir.forminputpembayaran', [
            'patient' => $patient,
            'dentalrecord' => $dentalrecord,
            'dentaltreatments' => $dentaltreatments,
            'medicinerecords' => $medicinerecords
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
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan',date('Y-m-d'))->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();

        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', '<', 4)->firstOrFail();

        foreach ($dentaltreatments as $dentaltreatment):
            $cost = Cost::findOrFail($dentaltreatment->cost_id);
            $jasadokter = ($cost->harga * $cost->doktergigi)/100 ;
            Dentaltreatment::where('id', $dentaltreatment->id)->update([
                'harga' => $cost->harga,
                'doktergigi' => $jasadokter
            ]);
        endforeach;

        foreach ($medicinerecords as $medicinerecord):
            $hargaobat = Medicine::findOrFail($medicinerecord->medicine_id)->harga;
            $totalhargaobat = $medicinerecord->jumlah * $hargaobat;
            Medicinerecord::where('id', $medicinerecord->id)->update([
                'harga' => $totalhargaobat
            ]);
        endforeach;

        Customer::where('patient_id',$dentalrecord->patient_id)->update([
            'selesai' => 4
        ]);

        return redirect('/kasir')->with('status', 'Pembayaran Telah Selesai');

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
