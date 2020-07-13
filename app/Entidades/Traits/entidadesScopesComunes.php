<?php

namespace App\Entidades\Traits;



trait entidadesScopesComunes{
    

   

     




    /* S c o p e s */
    public function scopeName($query, $name)
    {        
        if (trim($name) !="")
        {                        
           $query->where('name', "LIKE","%$name%"); 
        }        
    }

    public function scopeActive($query)
    {                               
        $query->where('estado', "si");                 
    }

}    