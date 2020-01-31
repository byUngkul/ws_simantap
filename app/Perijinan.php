<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Perijinan extends Model
{
    public function getIjin($param)
    {
        $allData = DB::connection('mysql_dua')
                            ->table('perijinan')
                            ->where('no_identitas', $param)->get();
        return $allData;
    }
}
