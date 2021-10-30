<?php

namespace App\Http\Controllers\Dentist;

use Auth;
use App\Models\Customer;
use App\Models\Cost;
use App\Models\Diag;
use App\Models\Patient;
use App\Models\Dentalrecord;
use App\Models\Dentaltreatment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DentaltreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $userid = Auth::user()->id;
        $costs = Cost::get();
        $diags = Diag::get();
        $dentalrecord = Dentalrecord::where('id', $id)->where('tanggalkunjungan', date('Y-m-d'))->where('user_id', $userid)->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        $customer = Customer::where('patient_id',$dentalrecord->patient_id)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        return view('dentist.forminputdentaltreatment', [
            'dentalrecord' => $dentalrecord,
            'dentaltreatments' => $dentaltreatments,
            'patient' => $patient,
            'diags' => $diags,
            'costs' => $costs
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
        $userid = Auth::user()->id;
        $dentalrecordid = $request->dentalrecordid;
        $dentalrecord = Dentalrecord::where('id', $dentalrecordid)->where('tanggalkunjungan', date('Y-m-d'))->where('user_id', $userid)->firstOrFail();
        $customer = Customer::where('patient_id',$dentalrecord->patient_id)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        $patientid = $dentalrecord->patient_id;

        if (request()->file('before')):
            if (request()->file('after')):
                $request->validate([
                    'gigi' => 'required',
                    'diag_id' => 'required',
                    'tindakan' => 'required',
                    'cost_id' => 'required',
                    'after' => 'image|mimes:jpg,jpeg,png|max:2048',
                    'before' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);
                $imgaf = request()->file('after');
                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->extension()}");
                $imgbf = request()->file('before');
                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->extension()}");
                Dentaltreatment::create([
                    'dentalrecord_id' => $dentalrecord->id,
                    'gigi' => $request -> gigi,
                    'diag_id' => $request -> diag_id,
                    'imagebefore' => $image1,
                    'imageafter' => $image2,
                    'tindakan' => $request -> tindakan,
                    'cost_id' => $request -> cost_id
                ]);
                return redirect('/dentist/pasien/'.$dentalrecordid.'#home')->with('status', 'Perawatan selesai');
            else:
                $request->validate([
                    'gigi' => 'required',
                    'diag_id' => 'required',
                    'tindakan' => 'required',
                    'cost_id' => 'required',
                    'before' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);
                $imgbf = request()->file('before');
                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->extension()}");
                Dentaltreatment::create([
                    'dentalrecord_id' => $dentalrecord->id,
                    'gigi' => $request -> gigi,
                    'diag_id' => $request -> diag_id,
                    'imagebefore' => $image1,
                    'tindakan' => $request -> tindakan,
                    'cost_id' => $request -> cost_id
                ]);
                return redirect('/dentist/pasien/'.$dentalrecordid.'#home')->with('status', 'Perawatan selesai');
            endif;
        elseif(request()->file('after')):
            $request->validate([
                'gigi' => 'required',
                'diag_id' => 'required',
                'tindakan' => 'required',
                'cost_id' => 'required',
                'after' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);
            $imgaf = request()->file('after');
            $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->extension()}");
            Dentaltreatment::create([
                'dentalrecord_id' => $dentalrecord->id,
                'gigi' => $request -> gigi,
                'diag_id' => $request -> diag_id,
                'imageafter' => $image2,
                'tindakan' => $request -> tindakan,
                'cost_id' => $request -> cost_id
            ]);
            return redirect('/dentist/pasien/'.$dentalrecordid.'#home')->with('status', 'Perawatan selesai');
        else:
            $request->validate([
                'gigi' => 'required',
                'diag_id' => 'required',
                'tindakan' => 'required',
                'cost_id' => 'required'
            ]);
            Dentaltreatment::create([
                'dentalrecord_id' => $dentalrecord->id,
                'gigi' => $request -> gigi,
                'diag_id' => $request -> diag_id,
                'tindakan' => $request -> tindakan,
                'cost_id' => $request -> cost_id
            ]);
            return redirect('/dentist/pasien/'.$dentalrecordid.'#home')->with('status', 'Perawatan selesai');


        endif;
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
        $userid = Auth::user()->id;
        $costs = Cost::get();
        $diags = Diag::get();
        $tindakan = Dentaltreatment::findOrFail($id);
        $dentalrecord = Dentalrecord::where('id', $tindakan->dentalrecord_id)->where('tanggalkunjungan', date('Y-m-d'))->where('user_id', $userid)->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->where('id','!=', $id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        $customer = Customer::where('patient_id',$dentalrecord->patient_id)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        return view('dentist.formeditdentaltreatment', [
            'tindakan' => $tindakan,
            'dentaltreatments' => $dentaltreatments,
            'dentalrecord' => $dentalrecord,
            'patient' => $patient,
            'diags' => $diags,
            'costs' => $costs
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
        $dentaltreatment = Dentaltreatment::findOrFail($id);
        $patientid = $dentaltreatment->dentalrecord->patient->id;
        $customer = Customer::where('patient_id',$patientid)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        if (request()->file('before')):
            if (request()->file('after')):
                $request->validate([
                    'gigi' => 'required',
                    'diag_id' => 'required',
                    'tindakan' => 'required',
                    'cost_id' => 'required',
                    'after' => 'image|mimes:jpg,jpeg,png|max:2048',
                    'before' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);
                echo 'before and after';
                $imgaf = request()->file('after');
                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->extension()}");
                $imgbf = request()->file('before');
                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->extension()}");
                \Storage::delete($dentaltreatment->imagebefore);
                \Storage::delete($dentaltreatment->imageafter);
                Dentaltreatment::where('id',$id)->update([
                    'gigi' => $request -> gigi,
                    'diag_id' => $request -> diag_id,
                    'imagebefore' => $image1,
                    'imageafter' => $image2,
                    'tindakan' => $request -> tindakan,
                    'cost_id' => $request -> cost_id
                ]);
                return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id.'#home')->with('status', 'Perawatan telah diubah');
            else:
                $request->validate([
                    'gigi' => 'required',
                    'diag_id' => 'required',
                    'tindakan' => 'required',
                    'cost_id' => 'required',
                    'before' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);
                echo 'before';
                $imgbf = request()->file('before');
                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->extension()}");
                \Storage::delete($dentaltreatment->imagebefore);
                Dentaltreatment::where('id',$id)->update([
                    'gigi' => $request -> gigi,
                    'diag_id' => $request -> diag_id,
                    'imagebefore' => $image1,
                    'tindakan' => $request -> tindakan,
                    'cost_id' => $request -> cost_id
                ]);
                return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id.'#home')->with('status', 'Perawatan telah diubah');
            endif;
        elseif(request()->file('after')):
            $request->validate([
                'gigi' => 'required',
                'diag_id' => 'required',
                'tindakan' => 'required',
                'cost_id' => 'required',
                'after' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);
            echo 'after';
            $imgaf = request()->file('after');
            $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->extension()}");
            \Storage::delete($dentaltreatment->imageafter);
            Dentaltreatment::where('id',$id)->update([
                'gigi' => $request -> gigi,
                'diag_id' => $request -> diag_id,
                'imageafter' => $image2,
                'tindakan' => $request -> tindakan,
                'cost_id' => $request -> cost_id
            ]);
            return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id.'#home')->with('status', 'Perawatan telah diubah');
        else:
            $request->validate([
                'gigi' => 'required',
                'diag_id' => 'required',
                'tindakan' => 'required',
                'cost_id' => 'required'
            ]);
            Dentaltreatment::where('id',$id)->update([
                'gigi' => $request -> gigi,
                'diag_id' => $request -> diag_id,
                'tindakan' => $request -> tindakan,
                'cost_id' => $request -> cost_id
            ]);
            return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id.'#home')->with('status', 'Perawatan telah diubah');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dentaltreatment = Dentaltreatment::findOrFail($id);
        $patientid = $dentaltreatment->dentalrecord->patient->id;
        $customer = Customer::where('patient_id',$patientid)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        if ($dentaltreatment->imagebefore):
            if ($dentaltreatment->imageafter):
                \Storage::delete($dentaltreatment->imagebefore);
                \Storage::delete($dentaltreatment->imageafter);
                Dentaltreatment::destroy($id);
                return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id)->with('status', 'Perawatan telah dihapus');
            else:
                \Storage::delete($dentaltreatment->imagebefore);
                Dentaltreatment::destroy($id);
                return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id)->with('status', 'Perawatan telah dihapus');
            endif;
        elseif(($dentaltreatment->imageafter)):
            \Storage::delete($dentaltreatment->imageafter);
            Dentaltreatment::destroy($id);
            return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id)->with('status', 'Perawatan telah dihapus');
        else:
            Dentaltreatment::destroy($id);
            return redirect('/dentist/pasien/'.$dentaltreatment->dentalrecord->id)->with('status', 'Perawatan telah dihapus');
        endif;
    }
}
