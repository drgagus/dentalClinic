<?php

namespace App\Http\Controllers\Dentist;

use Auth;
use App\Models\Cost;
use App\Models\Den;
use App\Models\Diag;
use App\Models\Medicine;
use App\Models\Medicinerecord;
use App\Models\Customer;
use App\Models\Patient;
use App\Models\Dentaltreatment;
use App\Models\Dentalrecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DentalrecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::where('selesai', 1)->where('user_id', Auth::user()->id)->get();
        $dentalrecords = Dentalrecord::where('tanggalkunjungan', date('Y-m-d'))->where('user_id', Auth::user()->id)->get();
        return view('dentist.daftarpasien', [
            'customers' => $customers,
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
        // $dens = Den::orderBy('gigi', 'asc')->get();
        $diags = Diag::get();
        $costs = Cost::get();
        $medicines = Medicine::where('aktif', 1)->get();
        $customer = Customer::where('id',$id)->where('selesai', 1)->where('user_id',Auth::user()->id)->firstOrfail();
        $patient = Patient::findOrFail($customer->patient_id);
        return view('dentist.forminputdentalrecord', [
            'patient' => $patient,
            'customer' => $customer,
            'medicines' => $medicines,
            // 'dens' => $dens,
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
        $patientid = $request->patient_id;
        $patient = Patient::findOrFail($request->patient_id);
        $usia = $this->usia($patient->tanggallahir);
        $customer = Customer::where('patient_id',$patientid)->where('selesai', 1)->where('user_id',Auth::user()->id)->firstOrfail();

            if ($request->tindakan1 or $request->gigi1 or $request->diag_id1):

                if ($request->tindakan2 or $request->gigi2 or $request->diag_id2):
                    $request->validate([
                        'patient_id' => 'required',
                        'keluhanutama' => 'required|max:255',
                        'tinggibadan' => 'max:5',
                        'beratbadan' => 'max:5',
                        'tekanandarah' => 'max:7',
                        'pernafasan' => 'max:3',
                        'detakjantung' => 'max:3',
                        'suhutubuh' => 'max:4',
                        'pemeriksaansubjektif' => 'max:1000',
                        'pemeriksaanobjektif' => 'max:1000',
                        'diagnosa' => 'max:500',
                        'informedconsent' => 'image|mimes:jpg,jpeg,png|max:2048',
                        'pengobatan' => 'max:100',
                        'gigi1' => 'required',
                        'diag_id1' => 'required',
                        'tindakan1' => 'required',
                        'cost_id1' => 'required',
                        'before1' => 'image|mimes:jpg,jpeg,png|max:2048',
                        'after1' => 'image|mimes:jpg,jpeg,png|max:2048',
                        'gigi2' => 'required',
                        'diag_id2' => 'required',
                        'tindakan2' => 'required',
                        'cost_id2' => 'required',
                        'before2' => 'image|mimes:jpg,jpeg,png|max:2048',
                        'after2' => 'image|mimes:jpg,jpeg,png|max:2048'
                    ]);
                    if (request()->file('informedconsent')):
                        $imginf = request()->file('informedconsent');
                        $imginformed = $imginf->storeAs("images/informedconsent", "ID{$patientid}-{$imginf->getMtime()}-informedconsent.{$imginf->getClientOriginalExtension()}");
                        // awal dentalrecord+informedconsent+tindakan1+tindakan2
                        if (request()->file('before1')):
                            if (request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                if (request()->file('before2')):
                                    if (request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    else:
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    endif;
                                elseif(request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'informedconsent' => $imginformed,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'imagebefore' => $image1,
                                        'imageafter' => $image2,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                            else:
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                if (request()->file('before2')):
                                    if (request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    else:
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    endif;
                                elseif(request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'informedconsent' => $imginformed,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'imagebefore' => $image1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                            endif;
                        elseif(request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                if (request()->file('before2')):
                                    if (request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    else:
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    endif;
                                elseif(request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'informedconsent' => $imginformed,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'informedconsent' => $imginformed,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'imageafter' => $image2,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                        else:
                            if (request()->file('before2')):
                                if (request()->file('after2')):
                                    $imgaf = request()->file('after2');
                                    $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                    $imgbf = request()->file('before2');
                                    $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'informedconsent' => $imginformed,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'imagebefore' => $image11,
                                        'imageafter' => $image12,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    $imgbf = request()->file('before2');
                                    $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'informedconsent' => $imginformed,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'imagebefore' => $image11,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                            elseif(request()->file('after2')):
                                    $imgaf = request()->file('after2');
                                    $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'informedconsent' => $imginformed,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'imageafter' => $image12,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                            else:
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'informedconsent' => $imginformed,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi2,
                                    'diag_id' => $request -> diag_id2,
                                    'tindakan' => $request -> tindakan2,
                                    'cost_id' => $request -> cost_id2
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                            endif;
                        endif;
                        // akhir dentalrecord+informedconsent+tindakan1+tindakan2
                    else:
                    // awal dentalrecord+tindakan1+tindakan2
                        if (request()->file('before1')):
                            if (request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                if (request()->file('before2')):
                                    if (request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    else:
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    endif;
                                elseif(request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'imagebefore' => $image1,
                                        'imageafter' => $image2,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                            else:
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                if (request()->file('before2')):
                                    if (request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    else:
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    endif;
                                elseif(request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imagebefore' => $image1,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'imagebefore' => $image1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                            endif;
                        elseif(request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                if (request()->file('before2')):
                                    if (request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    else:
                                        $imgbf = request()->file('before2');
                                        $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imagebefore' => $image11,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                    endif;
                                elseif(request()->file('after2')):
                                        $imgaf = request()->file('after2');
                                        $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                        Dentalrecord::create([
                                            'patient_id' => $request -> patient_id,
                                            'tanggalkunjungan' => now(),
                                            'usiatahun' => $usia['tahun'],
                                            'usiabulan' => $usia['bulan'],
                                            'usiahari' => $usia['hari'],
                                            'keluhanutama' => $request -> keluhanutama,
                                            'tinggibadan' => $request -> tinggibadan,
                                            'beratbadan' => $request -> beratbadan,
                                            'tekanandarah' => $request -> tekanandarah,
                                            'pernafasan' => $request -> pernafasan,
                                            'detakjantung' => $request -> detakjantung,
                                            'suhutubuh' => $request -> suhutubuh,
                                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                            'diagnosa' => $request -> diagnosa,
                                            'pengobatan' => $request -> pengobatan,
                                            'user_id' => Auth::user()->id
                                        ]);
                                        Customer::where('patient_id',$patient->id)->update([
                                            'selesai' => 2
                                        ]);
                                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi1,
                                            'diag_id' => $request -> diag_id1,
                                            'imageafter' => $image2,
                                            'tindakan' => $request -> tindakan1,
                                            'cost_id' => $request -> cost_id1
                                        ]);
                                        Dentaltreatment::create([
                                            'dentalrecord_id' => $dentalrecord->id,
                                            'gigi' => $request -> gigi2,
                                            'diag_id' => $request -> diag_id2,
                                            'imageafter' => $image12,
                                            'tindakan' => $request -> tindakan2,
                                            'cost_id' => $request -> cost_id2
                                        ]);
                                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'imageafter' => $image2,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                        else:
                            if (request()->file('before2')):
                                if (request()->file('after2')):
                                    $imgaf = request()->file('after2');
                                    $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                    $imgbf = request()->file('before2');
                                    $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'imagebefore' => $image11,
                                        'imageafter' => $image12,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                else:
                                    $imgbf = request()->file('before2');
                                    $image11 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'imagebefore' => $image11,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                                endif;
                            elseif(request()->file('after2')):
                                    $imgaf = request()->file('after2');
                                    $image12 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                                    Dentalrecord::create([
                                        'patient_id' => $request -> patient_id,
                                        'tanggalkunjungan' => now(),
                                        'usiatahun' => $usia['tahun'],
                                        'usiabulan' => $usia['bulan'],
                                        'usiahari' => $usia['hari'],
                                        'keluhanutama' => $request -> keluhanutama,
                                        'tinggibadan' => $request -> tinggibadan,
                                        'beratbadan' => $request -> beratbadan,
                                        'tekanandarah' => $request -> tekanandarah,
                                        'pernafasan' => $request -> pernafasan,
                                        'detakjantung' => $request -> detakjantung,
                                        'suhutubuh' => $request -> suhutubuh,
                                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                        'diagnosa' => $request -> diagnosa,
                                        'pengobatan' => $request -> pengobatan,
                                        'user_id' => Auth::user()->id
                                    ]);
                                    Customer::where('patient_id',$patient->id)->update([
                                        'selesai' => 2
                                    ]);
                                    $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi1,
                                        'diag_id' => $request -> diag_id1,
                                        'tindakan' => $request -> tindakan1,
                                        'cost_id' => $request -> cost_id1
                                    ]);
                                    Dentaltreatment::create([
                                        'dentalrecord_id' => $dentalrecord->id,
                                        'gigi' => $request -> gigi2,
                                        'diag_id' => $request -> diag_id2,
                                        'imageafter' => $image12,
                                        'tindakan' => $request -> tindakan2,
                                        'cost_id' => $request -> cost_id2
                                    ]);
                                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                            else:
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi2,
                                    'diag_id' => $request -> diag_id2,
                                    'tindakan' => $request -> tindakan2,
                                    'cost_id' => $request -> cost_id2
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                            endif;
                        endif;
                    // akhir dentalrecord+tindakan1+tindakan2
                    endif;
                else:
                    $request->validate([
                        'patient_id' => 'required',
                        'keluhanutama' => 'required|max:255',
                        'tinggibadan' => 'max:5',
                        'beratbadan' => 'max:5',
                        'tekanandarah' => 'max:7',
                        'pernafasan' => 'max:3',
                        'detakjantung' => 'max:3',
                        'suhutubuh' => 'max:4',
                        'pemeriksaansubjektif' => 'max:1000',
                        'pemeriksaanobjektif' => 'max:1000',
                        'diagnosa' => 'max:500',
                        'informedconsent' => 'image|mimes:jpg,jpeg,png|max:2048',
                        'pengobatan' => 'max:100',
                        'gigi1' => 'required',
                        'diag_id1' => 'required',
                        'tindakan1' => 'required',
                        'cost_id1' => 'required',
                        'before1' => 'image|mimes:jpg,jpeg,png|max:2048',
                        'after1' => 'image|mimes:jpg,jpeg,png|max:2048'
                    ]);

                    if (request()->file('informedconsent')):
                        $imginf = request()->file('informedconsent');
                        $imginformed = $imginf->storeAs("images/informedconsent", "ID{$patientid}-{$imginf->getMtime()}-informedconsent.{$imginf->getClientOriginalExtension()}");
                        if (request()->file('before1')):
                            if (request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'informedconsent' => $imginformed,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'imagebefore' => $image1,
                                    'imageafter' => $image2,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                            else:
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'informedconsent' => $imginformed,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'imagebefore' => $image1,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                            endif;
                        elseif(request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'informedconsent' => $imginformed,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'imageafter' => $image2,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                        else:
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'informedconsent' => $imginformed,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi1,
                                'diag_id' => $request -> diag_id1,
                                'tindakan' => $request -> tindakan1,
                                'cost_id' => $request -> cost_id1
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                        endif;
                            
                    else:
                        if (request()->file('before1')):
                            if (request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'imagebefore' => $image1,
                                    'imageafter' => $image2,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                            else:
                                $imgbf = request()->file('before1');
                                $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-1-before.{$imgbf->getClientOriginalExtension()}");
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'imagebefore' => $image1,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                            endif;
                        elseif(request()->file('after1')):
                                $imgaf = request()->file('after1');
                                $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-1-after.{$imgaf->getClientOriginalExtension()}");
                                Dentalrecord::create([
                                    'patient_id' => $request -> patient_id,
                                    'tanggalkunjungan' => now(),
                                    'usiatahun' => $usia['tahun'],
                                    'usiabulan' => $usia['bulan'],
                                    'usiahari' => $usia['hari'],
                                    'keluhanutama' => $request -> keluhanutama,
                                    'tinggibadan' => $request -> tinggibadan,
                                    'beratbadan' => $request -> beratbadan,
                                    'tekanandarah' => $request -> tekanandarah,
                                    'pernafasan' => $request -> pernafasan,
                                    'detakjantung' => $request -> detakjantung,
                                    'suhutubuh' => $request -> suhutubuh,
                                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                    'diagnosa' => $request -> diagnosa,
                                    'pengobatan' => $request -> pengobatan,
                                    'user_id' => Auth::user()->id
                                ]);
                                Customer::where('patient_id',$patient->id)->update([
                                    'selesai' => 2
                                ]);
                                $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                                Dentaltreatment::create([
                                    'dentalrecord_id' => $dentalrecord->id,
                                    'gigi' => $request -> gigi1,
                                    'diag_id' => $request -> diag_id1,
                                    'imageafter' => $image2,
                                    'tindakan' => $request -> tindakan1,
                                    'cost_id' => $request -> cost_id1
                                ]);
                                return redirect('/dentist')->with('status', 'Perawatan selesai');
                        else:
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi1,
                                'diag_id' => $request -> diag_id1,
                                'tindakan' => $request -> tindakan1,
                                'cost_id' => $request -> cost_id1
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                        endif;
                    endif;

                endif;

            elseif ($request->tindakan2 or $request->gigi2 or $request->diag_id2):
                $request->validate([
                    'patient_id' => 'required',
                    'keluhanutama' => 'required|max:255',
                    'tinggibadan' => 'max:5',
                    'beratbadan' => 'max:5',
                    'tekanandarah' => 'max:7',
                    'pernafasan' => 'max:3',
                    'detakjantung' => 'max:3',
                    'suhutubuh' => 'max:4',
                    'pemeriksaansubjektif' => 'max:1000',
                    'pemeriksaanobjektif' => 'max:1000',
                    'diagnosa' => 'max:500',
                    'informedconsent' => 'image|mimes:jpg,jpeg,png|max:2048',
                    'pengobatan' => 'max:100',
                    'gigi2' => 'required',
                    'diag_id2' => 'required',
                    'tindakan2' => 'required',
                    'cost_id2' => 'required',
                    'before2' => 'image|mimes:jpg,jpeg,png|max:2048',
                    'after2' => 'image|mimes:jpg,jpeg,png|max:2048'
                ]);

                if (request()->file('informedconsent')):
                    $imginf = request()->file('informedconsent');
                    $imginformed = $imginf->storeAs("images/informedconsent", "ID{$patientid}-{$imginf->getMtime()}-informedconsent.{$imginf->getClientOriginalExtension()}");
                    // awal dentalrecord+informedconsent+tindakan2

                    if (request()->file('before2')):
                        if (request()->file('after2')):
                            $imgaf = request()->file('after2');
                            $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                            $imgbf = request()->file('before2');
                            $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'informedconsent' => $imginformed,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi2,
                                'diag_id' => $request -> diag_id2,
                                'imagebefore' => $image1,
                                'imageafter' => $image2,
                                'tindakan' => $request -> tindakan2,
                                'cost_id' => $request -> cost_id2
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                        else:
                            $imgbf = request()->file('before2');
                            $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'informedconsent' => $imginformed,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi2,
                                'diag_id' => $request -> diag_id2,
                                'imagebefore' => $image1,
                                'tindakan' => $request -> tindakan2,
                                'cost_id' => $request -> cost_id2
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                        endif;
                    elseif(request()->file('after2')):
                            $imgaf = request()->file('after1');
                            $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'informedconsent' => $imginformed,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi2,
                                'diag_id' => $request -> diag_id2,
                                'imageafter' => $image2,
                                'tindakan' => $request -> tindakan2,
                                'cost_id' => $request -> cost_id2
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                    else:
                        Dentalrecord::create([
                            'patient_id' => $request -> patient_id,
                            'tanggalkunjungan' => now(),
                            'usiatahun' => $usia['tahun'],
                            'usiabulan' => $usia['bulan'],
                            'usiahari' => $usia['hari'],
                            'keluhanutama' => $request -> keluhanutama,
                            'tinggibadan' => $request -> tinggibadan,
                            'beratbadan' => $request -> beratbadan,
                            'tekanandarah' => $request -> tekanandarah,
                            'pernafasan' => $request -> pernafasan,
                            'detakjantung' => $request -> detakjantung,
                            'suhutubuh' => $request -> suhutubuh,
                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                            'diagnosa' => $request -> diagnosa,
                            'informedconsent' => $imginformed,
                            'pengobatan' => $request -> pengobatan,
                            'user_id' => Auth::user()->id
                        ]);
                        Customer::where('patient_id',$patient->id)->update([
                            'selesai' => 2
                        ]);
                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                        Dentaltreatment::create([
                            'dentalrecord_id' => $dentalrecord->id,
                            'gigi' => $request -> gigi2,
                            'diag_id' => $request -> diag_id2,
                            'tindakan' => $request -> tindakan2,
                            'cost_id' => $request -> cost_id2
                        ]);
                        return redirect('/dentist')->with('status', 'Perawatan selesai');


                    endif;

                    // akhir dentalrecord+informedconsent+tindakan2
                else:
                    // awal dentalrecord+tindakan2
                    if (request()->file('before2')):
                        if (request()->file('after2')):
                            $imgaf = request()->file('after2');
                            $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                            $imgbf = request()->file('before2');
                            $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi2,
                                'diag_id' => $request -> diag_id2,
                                'imagebefore' => $image1,
                                'imageafter' => $image2,
                                'tindakan' => $request -> tindakan2,
                                'cost_id' => $request -> cost_id2
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                        else:
                            $imgbf = request()->file('before2');
                            $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-2-before.{$imgbf->getClientOriginalExtension()}");
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi2,
                                'diag_id' => $request -> diag_id2,
                                'imagebefore' => $image1,
                                'tindakan' => $request -> tindakan2,
                                'cost_id' => $request -> cost_id2
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                        endif;
                    elseif(request()->file('after2')):
                            $imgaf = request()->file('after2');
                            $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-2-after.{$imgaf->getClientOriginalExtension()}");
                            Dentalrecord::create([
                                'patient_id' => $request -> patient_id,
                                'tanggalkunjungan' => now(),
                                'usiatahun' => $usia['tahun'],
                                'usiabulan' => $usia['bulan'],
                                'usiahari' => $usia['hari'],
                                'keluhanutama' => $request -> keluhanutama,
                                'tinggibadan' => $request -> tinggibadan,
                                'beratbadan' => $request -> beratbadan,
                                'tekanandarah' => $request -> tekanandarah,
                                'pernafasan' => $request -> pernafasan,
                                'detakjantung' => $request -> detakjantung,
                                'suhutubuh' => $request -> suhutubuh,
                                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                                'diagnosa' => $request -> diagnosa,
                                'pengobatan' => $request -> pengobatan,
                                'user_id' => Auth::user()->id
                            ]);
                            Customer::where('patient_id',$patient->id)->update([
                                'selesai' => 2
                            ]);
                            $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                            Dentaltreatment::create([
                                'dentalrecord_id' => $dentalrecord->id,
                                'gigi' => $request -> gigi2,
                                'diag_id' => $request -> diag_id2,
                                'imageafter' => $image2,
                                'tindakan' => $request -> tindakan2,
                                'cost_id' => $request -> cost_id2
                            ]);
                            return redirect('/dentist')->with('status', 'Perawatan selesai');
                    else:
                        Dentalrecord::create([
                            'patient_id' => $request -> patient_id,
                            'tanggalkunjungan' => now(),
                            'usiatahun' => $usia['tahun'],
                            'usiabulan' => $usia['bulan'],
                            'usiahari' => $usia['hari'],
                            'keluhanutama' => $request -> keluhanutama,
                            'tinggibadan' => $request -> tinggibadan,
                            'beratbadan' => $request -> beratbadan,
                            'tekanandarah' => $request -> tekanandarah,
                            'pernafasan' => $request -> pernafasan,
                            'detakjantung' => $request -> detakjantung,
                            'suhutubuh' => $request -> suhutubuh,
                            'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                            'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                            'diagnosa' => $request -> diagnosa,
                            'pengobatan' => $request -> pengobatan,
                            'user_id' => Auth::user()->id
                        ]);
                        Customer::where('patient_id',$patient->id)->update([
                            'selesai' => 2
                        ]);
                        $dentalrecord = Dentalrecord::where('patient_id',$patientid)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->firstOrfail();
                        Dentaltreatment::create([
                            'dentalrecord_id' => $dentalrecord->id,
                            'gigi' => $request -> gigi2,
                            'diag_id' => $request -> diag_id2,
                            'tindakan' => $request -> tindakan2,
                            'cost_id' => $request -> cost_id2
                        ]);
                        return redirect('/dentist')->with('status', 'Perawatan selesai');
                    endif;
                    // akhir dentalrecord+tindakan2
                endif;

            else:
                $request->validate([
                    'patient_id' => 'required',
                    'keluhanutama' => 'required|max:255',
                    'tinggibadan' => 'max:5',
                    'beratbadan' => 'max:5',
                    'tekanandarah' => 'max:7',
                    'pernafasan' => 'max:3',
                    'detakjantung' => 'max:3',
                    'suhutubuh' => 'max:4',
                    'pemeriksaansubjektif' => 'max:1000',
                    'pemeriksaanobjektif' => 'max:1000',
                    'diagnosa' => 'max:500',
                    'informedconsent' => 'image|mimes:jpg,jpeg,png|max:2048',
                    'pengobatan' => 'max:100'
                ]);

                if (request()->file('informedconsent')):
                    $imginf = request()->file('informedconsent');
                    $imginformed = $imginf->storeAs("images/informedconsent", "ID{$patientid}-{$imginf->getMtime()}-informedconsent.{$imginf->getClientOriginalExtension()}");
                    // awal dentalrecord+informedconsent
                    Dentalrecord::create([
                        'patient_id' => $request -> patient_id,
                        'tanggalkunjungan' => now(),
                        'usiatahun' => $usia['tahun'],
                        'usiabulan' => $usia['bulan'],
                        'usiahari' => $usia['hari'],
                        'keluhanutama' => $request -> keluhanutama,
                        'tinggibadan' => $request -> tinggibadan,
                        'beratbadan' => $request -> beratbadan,
                        'tekanandarah' => $request -> tekanandarah,
                        'pernafasan' => $request -> pernafasan,
                        'detakjantung' => $request -> detakjantung,
                        'suhutubuh' => $request -> suhutubuh,
                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                        'diagnosa' => $request -> diagnosa,
                        'informedconsent' => $imginformed,
                        'pengobatan' => $request -> pengobatan,
                        'user_id' => Auth::user()->id
                    ]);
                    Customer::where('patient_id',$patient->id)->update([
                        'selesai' => 2
                    ]);
                    return redirect('/dentist')->with('status', 'Perawatan selesai');

                    // akhir dentalrecord+informedconsent
                else:
                    // awal dentalrecord saja
                    Dentalrecord::create([
                        'patient_id' => $request -> patient_id,
                        'tanggalkunjungan' => now(),
                        'usiatahun' => $usia['tahun'],
                        'usiabulan' => $usia['bulan'],
                        'usiahari' => $usia['hari'],
                        'keluhanutama' => $request -> keluhanutama,
                        'tinggibadan' => $request -> tinggibadan,
                        'beratbadan' => $request -> beratbadan,
                        'tekanandarah' => $request -> tekanandarah,
                        'pernafasan' => $request -> pernafasan,
                        'detakjantung' => $request -> detakjantung,
                        'suhutubuh' => $request -> suhutubuh,
                        'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                        'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                        'diagnosa' => $request -> diagnosa,
                        'pengobatan' => $request -> pengobatan,
                        'user_id' => Auth::user()->id
                    ]);
                    Customer::where('patient_id',$patient->id)->update([
                        'selesai' => 2
                    ]);
                    return redirect('/dentist')->with('status', 'Perawatan selesai');
                    // akhir dentalrecord saja
                endif;


            endif;



                // if (request()->file('before1')):
                //     if (request()->file('after1')):
                //         $imgaf = request()->file('after1');
                //         $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-{$i}-after.{$imgaf->getClientOriginalExtension()}");
                //         $imgbf = request()->file('before1');
                //         $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-{$i}-before.{$imgbf->getClientOriginalExtension()}");
                //     else:
                //         $imgbf = request()->file('before1');
                //         $image1 = $imgbf->storeAs("images/before", "ID{$patientid}-{$imgbf->getMtime()}-{$i}-before.{$imgbf->getClientOriginalExtension()}");
                //     endif;
                // elseif(request()->file('after1')):
                //         $imgaf = request()->file('after1');
                //         $image2 = $imgaf->storeAs("images/after", "ID{$patientid}-{$imgaf->getMtime()}-{$i}-after.{$imgaf->getClientOriginalExtension()}");
                // else:
                //     // tidak ada image before and after
                // endif;
    
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $dens = Den::orderBy('gigi', 'asc')->get();
        $diags = Diag::get();
        $costs = Cost::get();
        $medicines = Medicine::where('aktif', 1)->get();
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        return view('dentist.detaildentalrecord', [
            'patient' => $patient,
            'dentalrecord' => $dentalrecord,
            'dentaltreatments' => $dentaltreatments,
            'medicines' => $medicines,
            'diags' => $diags,
            'costs' => $costs
            // 'dens' => $dens
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
        $diags = Diag::get();
        $costs = Cost::get();
        $medicines = Medicine::where('aktif', 1)->get();
        $dentalrecord = Dentalrecord::where('id',$id)->where('tanggalkunjungan',date('Y-m-d'))->where('user_id',Auth::user()->id)->firstOrfail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id',$dentalrecord->id)->get();
        $patient = Patient::findOrFail($dentalrecord->patient_id);
        $customer = Customer::where('patient_id',$patient->id)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        return view('dentist.formeditdentalrecord', [
            'patient' => $patient,
            'dentalrecord' => $dentalrecord,
            'dentaltreatments' => $dentaltreatments,
            'medicines' => $medicines,
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
        $dentalrecord = Dentalrecord::where('id', $id)->where('tanggalkunjungan', date('Y-m-d'))->where('user_id', Auth::user()->id)->firstOrFail();
        $customer = Customer::where('patient_id',$dentalrecord->patient_id)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();
        $patientid = $dentalrecord->patient_id;
        if (request()->file('informedconsent')):
            $request->validate([
                'keluhanutama' => 'required|max:255',
                'tinggibadan' => 'max:5',
                'beratbadan' => 'max:5',
                'tekanandarah' => 'max:7',
                'pernafasan' => 'max:3',
                'detakjantung' => 'max:3',
                'suhutubuh' => 'max:4',
                'pemeriksaansubjektif' => 'max:1000',
                'pemeriksaanobjektif' => 'max:1000',
                'diagnosa' => 'max:500',
                'informedconsent' => 'image|mimes:jpg,jpeg,png|max:2048',
                'pengobatan' => 'max:100'
            ]);

            if ($dentalrecord->informedconsent):
                $imginf = request()->file('informedconsent');
                $imginformed = $imginf->storeAs("images/informedconsent", "ID{$patientid}-{$imginf->getMtime()}-informedconsent.{$imginf->getClientOriginalExtension()}");
                // awal dentalrecord+informedconsent
                Dentalrecord::where('id',$id)->update([
                    'keluhanutama' => $request -> keluhanutama,
                    'tinggibadan' => $request -> tinggibadan,
                    'beratbadan' => $request -> beratbadan,
                    'tekanandarah' => $request -> tekanandarah,
                    'pernafasan' => $request -> pernafasan,
                    'detakjantung' => $request -> detakjantung,
                    'suhutubuh' => $request -> suhutubuh,
                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                    'diagnosa' => $request -> diagnosa,
                    'informedconsent' => $imginformed,
                    'pengobatan' => $request -> pengobatan
                ]);
                \Storage::delete($dentalrecord->informedconsent);
                return redirect('/dentist/pasien/'.$dentalrecord->id)->with('status', 'Dental record berhasil diubah');
            else:
                $imginf = request()->file('informedconsent');
                $imginformed = $imginf->storeAs("images/informedconsent", "ID{$patientid}-{$imginf->getMtime()}-informedconsent.{$imginf->getClientOriginalExtension()}");
                // awal dentalrecord+informedconsent
                Dentalrecord::where('id',$id)->update([
                    'keluhanutama' => $request -> keluhanutama,
                    'tinggibadan' => $request -> tinggibadan,
                    'beratbadan' => $request -> beratbadan,
                    'tekanandarah' => $request -> tekanandarah,
                    'pernafasan' => $request -> pernafasan,
                    'detakjantung' => $request -> detakjantung,
                    'suhutubuh' => $request -> suhutubuh,
                    'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                    'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                    'diagnosa' => $request -> diagnosa,
                    'informedconsent' => $imginformed,
                    'pengobatan' => $request -> pengobatan
                ]);
                return redirect('/dentist/pasien/'.$dentalrecord->id)->with('status', 'Dental record berhasil diubah');
            endif;
            // akhir dentalrecord+informedconsent
        else:
            $request->validate([
                'keluhanutama' => 'required|max:255',
                'tinggibadan' => 'max:5',
                'beratbadan' => 'max:5',
                'tekanandarah' => 'max:7',
                'pernafasan' => 'max:3',
                'detakjantung' => 'max:3',
                'suhutubuh' => 'max:4',
                'pemeriksaansubjektif' => 'max:1000',
                'pemeriksaanobjektif' => 'max:1000',
                'diagnosa' => 'max:500',
                'pengobatan' => 'max:100'
            ]);

            Dentalrecord::where('id',$id)->update([
                'keluhanutama' => $request -> keluhanutama,
                'tinggibadan' => $request -> tinggibadan,
                'beratbadan' => $request -> beratbadan,
                'tekanandarah' => $request -> tekanandarah,
                'pernafasan' => $request -> pernafasan,
                'detakjantung' => $request -> detakjantung,
                'suhutubuh' => $request -> suhutubuh,
                'pemeriksaansubjektif' => $request -> pemeriksaansubjektif,
                'pemeriksaanobjektif' => $request -> pemeriksaanobjektif,
                'diagnosa' => $request -> diagnosa,
                'pengobatan' => $request -> pengobatan
            ]);
            return redirect('/dentist/pasien/'.$dentalrecord->id)->with('status', 'Dental record berhasil diubah');
            // akhir dentalrecord saja
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
        $dentalrecord = Dentalrecord::where('id', $id)->where('tanggalkunjungan', date('Y-m-d'))->where('user_id', Auth::user()->id)->firstOrFail();
        $dentaltreatments = Dentaltreatment::where('dentalrecord_id', $dentalrecord->id)->get();
        $medicinerecords = Medicinerecord::where('dentalrecord_id', $dentalrecord->id)->get();
        $customer = Customer::where('patient_id',$dentalrecord->patient_id)->where('selesai', 2)->where('user_id',Auth::user()->id)->firstOrfail();

        if (count($dentaltreatments)):
            foreach ($dentaltreatments as $dentaltreatment):
                if ($dentaltreatment->imagebefore):
                    if ($dentaltreatment->imageafter):
                        \Storage::delete($dentaltreatment->imagebefore);
                        \Storage::delete($dentaltreatment->imageafter);
                        Dentaltreatment::destroy($dentaltreatment->id);
                    else:
                        \Storage::delete($dentaltreatment->imagebefore);
                        Dentaltreatment::destroy($dentaltreatment->id);
                    endif;
                elseif(($dentaltreatment->imageafter)):
                    \Storage::delete($dentaltreatment->imageafter);
                    Dentaltreatment::destroy($dentaltreatment->id);
                else:
                    Dentaltreatment::destroy($dentaltreatment->id);
                endif;
            endforeach;
        endif;

        if (count($medicinerecords)):
            foreach ($medicinerecords as $medicinerecord):
                Medicinerecord::destroy($medicinerecord->id);
            endforeach;
        endif;

        if($dentalrecord->informedconsent):
            \Storage::delete($dentalrecord->informedconsent);
        endif;
        Dentalrecord::destroy($id);
        Customer::where('patient_id',$dentalrecord->patient_id)->update([
            'selesai' => 1
        ]);
        return redirect('/dentist')->with('status', 'Dental record telah dihapus');

    }

    public function usia($tanggallahir)
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

        $usia = ['tahun'=>$tahun,'bulan'=>$bulan,'hari'=>$hari];
        return $usia;
    }

    public function records($id)
    {
        $patient = Patient::findOrFail($id);
        $usia = $this->usia($patient->tanggallahir);
        $customer = Customer::where('patient_id', $patient->id)->firstOrFail();
        $dentalrecords = Dentalrecord::where('patient_id', $patient->id)->get();
        return view('dentist.dentalrecord', [
            'patient' => $patient,
            'dentalrecords' => $dentalrecords,
            'usia' => $usia
        ]);
    }
}
