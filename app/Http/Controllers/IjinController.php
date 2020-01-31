<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class IjinController extends Controller
{
    public function getAllijin(Request $request)
    {
        $allData = DB::connection('mysql_dua')
                    ->table('perijinan')
                    ->join('jenis_perijinan', 'perijinan.id_jenis_ijin', '=', 'jenis_perijinan.id_jenis_ijin')
                    ->where('no_identitas', $request->nik)
                    ->where('status_proses', 'Selesai')
                    ->get();
        
        foreach ($allData as $key => $dt) {
            $data[] = [
                'id_register' => $dt->id_register,
                'nama_pemohon' => $dt->nama_pemohon,
                'penanggung_jawab' => $dt->penanggung_jawab,
                'no_sertifikat' => $dt->no_sertifikat,
                'jenis_ijin' => $dt->deskripsi,
                'alamat' => $dt->alamat,
                'tgl_daftar' => date('d/m/Y', strtotime($dt->tgl_create)),
                'no_telepon' => $dt->telpon,
                'email' => $dt->email,
            ];
        }

        $jml_data = count($allData);
        return response()->json(['respon_code' => 'OK', 'tot_data' => $jml_data, 'result' => $data]);
        // return response()->json(['respon_code' => 'OK', 'tot_data' => $jml_data, 'result' => $allData]);
    }
}
