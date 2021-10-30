<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('ceo', null)->where('admin', null)->get();
        return view('admin.daftaruser', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.forminputuser');
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
            'name' => 'required|max:30',
            'username' => 'required|max:20|min:4|unique:users',
            'password' => 'required|max:20|min:4|confirmed:password_confirmation'
        ]);

        User::create([
            'name' => $request -> name,
            'username' => $request -> username,
            'pendaftaran' => $request -> pendaftaran,
            'pemeriksaan' => $request -> pemeriksaan,
            'dentist' => $request -> dentist,
            'apotek' => $request -> apotek,
            'kasir' => $request -> kasir,
            'password' => Hash::make($request -> password)
        ]);

        return redirect('/admin/user')->with('status', 'User Baru Berhasil Ditambahkan.');
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
        $user = User::findOrFail($id);
        if ($user->CEO == 1 or $user->admin == 1) {
            abort(401);
        }

        return view('admin.formedituser', [
            'user' => $user
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
        $user = User::findOrFail($id);
        if ($user->CEO == 1 or $user->admin == 1) {
            abort(401);
        }

        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|max:20|min:4'
        ]);

        User::where('id', $id)->update([
            'name' => $request -> name,
            'username' => $request -> username,
            'pendaftaran' => $request -> pendaftaran,
            'pemeriksaan' => $request -> pemeriksaan,
            'dentist' => $request -> dentist,
            'apotek' => $request -> apotek,
            'kasir' => $request -> kasir
        ]);

        return redirect('/admin/user')->with('status', 'User Berhasil Diubah.');
    }

    public function resetpassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->CEO == 1 or $user->admin == 1) {
            abort(401);
        }

        $request->validate([
            'password' => 'required'
        ]);
        
        $password = Auth::user()->password;
        $passwordreset = $request->password;
            if (Hash::check($passwordreset, $password)):
                User::where('id', $id)->update([
                    'password' => Hash::make('1234')
                ]);
                return redirect('/admin/user')->with('status', 'Password '.$user->name.' Berhasil Direset.');
            else:
                return redirect('/admin/user')->with('status', 'Password Admin Salah. Password '.$user->name.' Gagal Direset');
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
        $user = User::findOrFail($id);
        if ($user->CEO == 1 or $user->admin == 1) {
            abort(401);
        }
    }
}
