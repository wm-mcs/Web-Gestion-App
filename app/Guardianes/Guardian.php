<?php

namespace App\Guardianes;

class Guardian
{

    public function son_iguales($var1,$var2)
    {
      if($var1 == $var2)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

}