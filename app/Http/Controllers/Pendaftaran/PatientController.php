<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Models\Dentalrecord;
use App\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::get();
        return view('pendaftaran.datapasien', [
            'patients' => $patients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pendaftaran.forminputpasien');
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
            'nomorrekammedis' => 'required|integer|unique:patients',
            'nik' => 'required|max:16|unique:patients',
            'nama' => 'required|max:50',
            'jeniskelamin' => 'required',
            'tempatlahir' => 'max:30',
            'tanggallahir' => 'required',
            'agama' => 'max:20',
            'pendidikan' => 'max:30',
            'pekerjaan' => 'max:30',
            'alamat' => 'max:100',
            'nomortelepon' => 'max:11'
        ]);

        Patient::create([
            'nomorrekammedis' => $request->nomorrekammedis,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jeniskelamin' => $request->jeniskelamin,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tanggallahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'nomortelepon' => $request->nomortelepon
        ]);

        $new_patient = patient::latest()->first();

        return redirect('/pendaftaran/pasien/'.$new_patient->id)->with('status', 'Data pasien baru berhasil diinput');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = patient::findOrFail($id);
        $dentalrecords = Dentalrecord::where('patient_id', $id)->get();
        $usia = $this->usia($patient->tanggallahir);
        return view('pendaftaran.detailpasien', [
            'patient' => $patient,
            'dentalrecords' => $dentalrecords,
            'usia' => $usia
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
        $patient = Patient::findOrFail($id);
        return view('pendaftaran.formeditpasien', [
            'patient' => $patient
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
        $pasien = Patient::findOrFail($id);
        $request->validate([
            'nomorrekammedis' => 'required|integer',
            'nik' => 'required|max:16',
            'nama' => 'required|max:50',
            'jeniskelamin' => 'required',
            'tempatlahir' => 'max:30',
            'tanggallahir' => 'required',
            'agama' => 'max:20',
            'pendidikan' => 'max:30',
            'pekerjaan' => 'max:30',
            'alamat' => 'max:100',
            'nomortelepon' => 'max:11',
        ]);

        Patient::where('id', $id)->update([
            'nomorrekammedis' => $request->nomorrekammedis,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jeniskelamin' => $request->jeniskelamin,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tanggallahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'nomortelepon' => $request->nomortelepon
        ]);

        return redirect('/pendaftaran/pasien/'.$id)->with('status', 'Data pasien berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $dentalrecords = Dentalrecord::where('patient_id', $id)->get();
        if (count($dentalrecords)):
            return redirect('/pendaftaran/pasien/'.$patient->id)->with('status', 'Data '.$patient->nama.' gagal dihapus');
        else:
            Patient::destroy($id);
            return redirect('/pendaftaran/pasien/'.$patient->id)->with('status', 'Data '.$patient->nama.' berhasil dihapus');
        endif;
        
    }

    public function usia ($tanggallahir)
    {
        $tgl_lahir= date('d', strtotime($tanggallahir));
		$bln_lahir= date('m', strtotime($tanggallahir));
		$thn_lahir= date('Y', strtotime($tanggallahir));
    
        $tgl_today = date('d');
		$bln_today= date('m');
		$thn_today = date('Y');

        if ($tgl_today >= $tgl_lahir) {
            $hari = $tgl_today - $tgl_lahir ; 
                if ($bln_today >= $bln_lahir) {
                    $bulan = $bln_today - $bln_lahir ;
                    $tahun = $thn_today - $thn_lahir ;
                }else if ($bln_today < $bln_lahir) {
                    $bulan = ($bln_today + 12 )  - $bln_lahir ;	
                    $tahun = ($thn_today - 1 ) - $thn_lahir ;
                }else{ 
                }
        }else if ($tgl_today < $tgl_lahir) {
            $hari = ($tgl_today + 30 )  - $tgl_lahir ;
                if (($bln_today-1) >= $bln_lahir) {
                    $bulan = ($bln_today-1) - $bln_lahir ;
                    $tahun = $thn_today - $thn_lahir ;
                }else if (($bln_today-1) < $bln_lahir) {
                    $bulan = ($bln_today+11) - $bln_lahir ;
                    $tahun = ($thn_today-1) - $thn_lahir ;
                }else{
                }
        }else{
        }

        $usia = [
                    'tahun' => $tahun.' Tahun ', 
                    'bulan' => $bulan.' Bulan ', 
                    'hari' => $hari. ' Hari'
                ];
        return $usia;
    }
}
