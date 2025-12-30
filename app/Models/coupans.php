<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class coupans extends Model

{

    protected $table = 'coupans';

    protected $fillable = ['coupans_code', 'user_id', 'type', 'amount', 'start_date', 'end_date', 'status'];





    use HasFactory;

    function users()
    {

        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
