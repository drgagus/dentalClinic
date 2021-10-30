<?php

namespace App\Http\Controllers\Akun;

use Hash;
use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('akun/detailakun');
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
        //
    }

    public function editpassword()
    {
        return view('akun/formeditpassword');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|max:20|min:4|confirmed:password_confirmation'
        ]);

        $id = Auth::user()->id;
        $new_password = $request->password;
        $old_password = $request->old_password;
        $current_password = Auth::user()->password;

        if (Hash::check($old_password, $current_password)){
            if (Hash::check($new_password, $current_password)){
                return redirect('/akun/password')->with('status', 'Password Baru Sama Dengan Password Lama!');
            }else{
                user::where('id', $id)->update([
                    'password' => Hash::make($new_password)
                ]);
                return redirect('/akun')->with('status', 'Password Berhasil Diganti');
            }
        }else{
            return redirect('/akun/password')->with('status', 'Password Lama Salah!');
        }

    }
    
    public function editname()
    {
        return view('akun/formeditname');
    }

    public function updatename(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'password' => 'required'
        ]);

        $id = Auth::user()->id;

        $new_name = $request->name;
        $password = $request->password;
        $old_name = Auth::user()->name;
        $current_password = Auth::user()->password;

        if ($new_name == $old_name){
            return redirect('/akun/name')->with('status', 'Nama Baru Sama Dengan Nama Lama!');
        }else{
                if (Hash::check($password, $current_password)){
                    user::where('id', $id)->update([
                        'name' => $new_name
                    ]);
                    return redirect('/akun')->with('status', 'Nama Berhasil Diganti');
                }else{
                    return redirect('/akun/name')->with('status', 'Password Salah!');
                }
        }
    }
}
