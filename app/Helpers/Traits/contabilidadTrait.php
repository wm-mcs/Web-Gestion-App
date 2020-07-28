<?php 
namespace App\Helpers\Traits;




trait contabilidadTrait{



	/**
	 *  @param $SaldoQueViene string
	 */
    public function DevolverTipoDeSaldoOpuesto($SaldoQueViene)
    {
       if($SaldoQueViene == 'deudor')
          {
            $Saldo = 'acredor';
          }
          else
          {
            $Saldo = 'deudor';
          }

          return $Saldo;
    }

    /**
     *  valor de IVA en Uruguay
     */
    public function getValorDeIVA()
    {
      return 22;
    }

    /**
     * 
     */
    public function DarmeEsteValorMasIVA($valor)
    {
      $calculo = ( (float) $valor )* (1 + $this->getValorDeIVA()/100 );
      return round($calculo,2);
    }

    /**
     * $es_con_iva = a 'si', 'no'
     */
    public function getValorSiEsConIVAONO($es_con_iva,$valor)
    {
       if($es_con_iva == 'si')
       {
        return $this->DarmeEsteValorMasIVA($valor);
       }
       else
       {
        return $valor;
       }
    }

}