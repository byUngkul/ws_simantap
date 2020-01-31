<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class UserController extends Controller
{
    public function login(Request $request)
    {        
        $user = DB::connection('mysql')->select('select * from s_users where s_noidentitas = '.$request->nik .' and s_nip = '. $request->nip);
        if ($user)
            return response()->json(['respon_code' => 'OK', 'result' =>  'Login sukses'], 200);
        else
            return response()->json(['respon_code' => 'FAILD', 'result' => 'NIP Anda belum terdaftar, silahkan daftarkan NIP Anda di Kantor Perijinan setempat.']);
    }

    public function securty_code_confirm(Request $request)
    {
        $user = DB::connection('mysql')->table('s_users')
                                    ->where('s_noidentitas', $request->nik)
                                    ->where('s_nip', $request->nip)
                                    ->where('s_password', md5($request->pass_code));
        if ($user) {
            $user->update(['s_api_token' => Str::random(40)]);
            $user = DB::connection('mysql')->table('s_users')
                            ->where('s_noidentitas', $request->nik)
                            ->where('s_nip', $request->nip)
                            ->where('s_password', md5($request->pass_code))->first();
            // var_dump($user->s_iduser); die;
            return response()->json(['respon_code' => 'OK', 'result' =>  'Proses registrasi Anad telah berhasil.', 'api_token' => $user->s_api_token], 200);
        } else {
            return response()->json(['respon_code' => 'FAILD', 'result' => 'Kode registerasi Anda salah, silahkan coba lagi.']);
        }
    }
}
