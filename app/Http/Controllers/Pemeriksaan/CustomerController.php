<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Models\Customer;
use App\Models\Patient;
use App\Models\User;
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
        return view('pemeriksaan.daftarpasien', [
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
        $customer = Customer::findOrFail($id);
        return view('pemeriksaan.detailpemeriksaan', [
            'customer' => $customer
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
        $customer = Customer::where('id', $id)->where('selesai', '<', 2)->firstOrFail();
        $users = User::where('dentist', 1)->get();
        return view('pemeriksaan.formpemeriksaanumum', [
            'customer' => $customer,
            'users' => $users
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
        $customer = Customer::where('id', $id)->where('selesai', '<', 2)->firstOrFail();
        $request->validate([
            'keluhanutama' => 'required',
            'tinggibadan' => 'max:5',
            'beratbadan' => 'max:5',
            'tekanandarah' => 'required|max:7',
            'pernafasan' => 'max:3',
            'detakjantung' => 'max:3',
            'suhutubuh' => 'max:5',
            'user_id' => 'required'
        ]);

        Customer::where('id',$id)->update([
            'keluhanutama' => $request->keluhanutama,
            'tinggibadan' => $request->tinggibadan,
            'beratbadan' => $request->beratbadan,
            'tekanandarah' => $request->tekanandarah,
            'pernafasan' => $request->pernafasan,
            'detakjantung' => $request->detakjantung,
            'suhutubuh' => $request->suhutubuh,
            'selesai' => 1,
            'user_id' => $request->user_id
        ]);


        return redirect('/pemeriksaan')->with('status', 'Pemeriksaan berhasil diinput');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('id', $id)->where('selesai', '<', 2)->firstOrFail();
        Customer::where('id',$id)->update([
            'keluhanutama' => '',
            'tinggibadan' => '',
            'beratbadan' => '',
            'tekanandarah' => '',
            'pernafasan' => '',
            'detakjantung' => '',
            'suhutubuh' => '',
            'selesai' => 0,
            'user_id' => null
        ]);
        return redirect('/pemeriksaan')->with('status', 'Pemeriksaan berhasil dihapus');

    }
}
