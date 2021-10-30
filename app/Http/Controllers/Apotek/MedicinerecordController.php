<?php

namespace App\Http\Controllers\Apotek;

use Auth;
use App\Models\Customer;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Dentaltreatment;
use App\Models\Dentalrecord;
use App\Models\Medicinerecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicinerecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dentalrecords = Dentalrecord::where('tanggalkunjungan', date('Y-m-d'))->get();
        return view('apotek.daftarpasien', [
            'dentalrecords' => $dentalrecords
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $medicines = Medicine::where('aktif', 1)->get();
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan',date('Y-m-d'))->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', '=', 2)->firstOrFail();
        return view('apotek.forminputmedicinerecord', [
            'patient' => $patient,
            'dentalrecord' => $dentalrecord,
            'dentaltreatments' => $dentaltreatments,
            'medicines' => $medicines
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $dentalrecordid = $request -> dentalrecordid;
        $dentalrecord = Dentalrecord::findOrFail($dentalrecordid);
        $patientid = $dentalrecord->patient_id;
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', '=', 2)->firstOrFail();
        for ($i = 1; $i < 7 ; $i++):
            $obat = 'obat'.$i ;
            $jumlah = 'jumlah'.$i ;
            $obatid=$request->$obat;
            $jumlahobat=$request->$jumlah;
            if ($obatid)
            {
                $request->validate([
                    'jumlah'.$i => 'required|integer'
                ]);
            }
                if ($obatid)
                {
                    Medicinerecord::create([
                        'dentalrecord_id' => $dentalrecordid,
                        'medicine_id' => $obatid,
                        'jumlah' => $jumlahobat,
                        'user_id' => Auth::user()->id
                    ]);

                    $medicine = Medicine::findOrFail($obatid);
                    $oldstock = $medicine->jumlah;
                    $newstock = $oldstock - $jumlahobat;
                    Medicine::where('id',$obatid)->update([
                        'jumlah' => $newstock,
                        ]);
                }    
        endfor;
        Customer::where('patient_id',$patientid)->update([
            'selesai' => 3
        ]);
        return redirect('/apotek')->with('status', 'Obat Pasien Telah Diinput');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan', date('Y-m-d'))->firstOrFail();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id); 
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', 3)->firstOrFail();
        return view('apotek.detailmedicinerecord', [
            'dentalrecord' => $dentalrecord,
            'medicinerecords' => $medicinerecords,
            'dentaltreatments' => $dentaltreatments,
            'patient' => $patient
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
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan', date('Y-m-d'))->firstOrFail();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id); 
        $medicines = Medicine::where('aktif', 1)->get();
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', '=', 3)->firstOrFail();
        return view('apotek.formeditmedicinerecord', [
            'dentalrecord' => $dentalrecord,
            'medicinerecords' => $medicinerecords,
            'dentaltreatments' => $dentaltreatments,
            'patient' => $patient,
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
        $dentalrecord = Dentalrecord::findOrFail($id);
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $customer = Customer::where('patient_id', $dentalrecord->patient_id)->where('selesai', '=', 3)->firstOrFail();

        foreach ($medicinerecords as $medicinerecord):
            $request->validate([
                'obat'.$medicinerecord->id => 'required',
                'jumlah'.$medicinerecord->id => 'required'
            ]);

            $medicinerecordid = 'medicinerecord_id'.$medicinerecord->id;
            $obat = 'obat'.$medicinerecord->id;
            $jumlah = 'jumlah'.$medicinerecord->id;
            Medicinerecord::where('id', $request->$medicinerecordid)->update([
                'medicine_id' => $request -> $obat, 
                'jumlah' => $request -> $jumlah
            ]);
            $oldstock = $medicinerecord->jumlah;
            $medicine = Medicine::findOrFail($request->$obat);
            $selisih = $oldstock - $request->$jumlah;
            $newstock = $medicine->jumlah + $selisih;
            Medicine::where('id', $request->$obat)->update([
                'jumlah' => $newstock
            ]);
            
        endforeach;
        return redirect('/apotek/pasien/'.$dentalrecord->id.'#home')->with('status', 'Obat pasien berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicinerecord = Medicinerecord::findOrFail($id);
        $customer = Customer::where('patient_id', $medicinerecord->dentalrecord->patient_id)->where('selesai', '=', 3)->firstOrFail();
        $medicine = Medicine::findOrFail($medicinerecord->medicine_id);
        $newstock = $medicine->jumlah + $medicinerecord->jumlah;
        Medicinerecord::destroy($id);
        Medicine::where('id', $medicinerecord->medicine_id)->update([
            'jumlah' => $newstock
        ]);
        return redirect('/apotek/pasien/'.$medicinerecord->dentalrecord_id.'#home')->with('status', 'Obat '.$medicine->obat.' pasien berhasil dihapus');
    }

    public function add($id)
    {
        $medicines = Medicine::where('aktif', 1)->get();
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan', date('Y-m-d'))->firstOrFail();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id); 
        $customer = Customer::where('patient_id', $patient->id)->where('selesai', '=', 3)->firstOrFail();
        return view('apotek.formaddmedicinerecord', [
            'dentalrecord' => $dentalrecord,
            'medicinerecords' => $medicinerecords,
            'dentaltreatments' => $dentaltreatments,
            'patient' => $patient,
            'medicines' => $medicines
        ]);
    }

    public function addstore(Request $request)
    {
        $request->validate([
            'obat' => 'required',
            'jumlah' => 'required'
        ]);

        Medicinerecord::create([
            'dentalrecord_id' => $request->dentalrecord_id,
            'medicine_id' => $request->obat,
            'jumlah' => $request->jumlah,
            'user_id' => Auth::user()->id
        ]);

        $medicine = Medicine::findOrFail($request->obat);
        $newstock = $medicine->jumlah - $request->jumlah;
        Medicine::where('id', $request->obat)->update([
            'jumlah' => $newstock
        ]);

        return redirect('/apotek/pasien/'.$request->dentalrecord_id.'#home')->with('status', 'Obat '.$medicine->obat.' pasien berhasil ditambahkan');

    }
}
