<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Models\Customer;
use App\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return view('pendaftaran.daftarpasien', [
            'customers' => $customers
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
            'patient_id' => 'required|unique:customers'
        ]);

        $patient = Patient::findOrFail($request->patient_id);
        $usia = $this->usia($patient->tanggallahir);
        Customer::create([
            'patient_id' => $request->patient_id,
            'usia' => $usia,
            'selesai' => 0,
            'tanggalkunjungan' => now()
        ]);

        return redirect('/pendaftaran')->with('status', 'Pasien baru berhasil ditambahkan');        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer->selesai == 0):
            Customer::destroy($id);
            return redirect('/pendaftaran')->with('status', 'Pasien berhasil dihapus');
        else:
            return redirect('/pendaftaran')->with('status', 'Pasien gagal dihapus');
        endif;       

    }

    public function truncate()
    {
        Customer::truncate();
        return redirect('/pendaftaran')->with('status', 'Daftar Pasien Telah Dikosongkan.');
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

        $usia = $tahun.' Tahun '.$bulan.' Bulan '.$hari.' Hari';
        return $usia;
    }
}
