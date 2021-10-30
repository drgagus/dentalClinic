<?php

namespace App\Http\Controllers\CEO;

use App\Models\User;
use App\Models\Medicinerecord;
use App\Models\Dentalrecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function formmedicine()
    {
        return view('ceo.formincomemedicine');
    }
    
    public function postmedicine(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required'
        ]);

        $dentalrecords = Dentalrecord::get();
        return view('ceo.incomemedicine', [
            'dentalrecords' => $dentalrecords,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan
        ]);
    }

    public function formincome()
    {
        return view('ceo.formincomeservice');
    }
    public function postincome(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required'
        ]);

        $dentalrecords = Dentalrecord::get();
        return view('ceo.incomeservice', [
            'dentalrecords' => $dentalrecords,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan
        ]);
    }
    
    public function formincomedentist()
    {
        $dentists = User::where('dentist', 1)->get();
        return view('ceo.formincomeservicedentist' ,[
            'dentists' => $dentists
        ]);
    }
    public function postincomedentist(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required'
        ]);
        $user = User::findOrFail($request->user_id);
        $dentalrecords = Dentalrecord::where('user_id', $request->user_id)->get();
        return view('ceo.incomeservicedentist', [
            'dentalrecords' => $dentalrecords,
            'user' => $user,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan
        ]);
    }
}
