<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\ImgHome;




class HomeWeb extends Model
{

    protected $table ='home_web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];



    public function imageneshome()
    {
      return $this->hasMany(ImgHome::class,'home_id','id')->where('estado','si');
    }

    

    
}