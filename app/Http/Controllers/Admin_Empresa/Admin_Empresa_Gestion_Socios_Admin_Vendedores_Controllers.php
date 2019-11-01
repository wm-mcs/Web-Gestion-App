<?php

namespace App\Http\Controllers\Admin_Empresa;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Guardianes\Guardian;
use App\Repositorios\SocioRepo;
use App\Repositorios\TipoDeServicioRepo;
use App\Repositorios\ServicioContratadoSocioRepo;
use Carbon\Carbon;
use App\Repositorios\MovimientoEstadoDeCuentaEmpresaRepo;
use App\Repositorios\UserRepo;
use App\Repositorios\UserEmpresaRepo;
use App\Repositorios\VendedorEmpresaRepo;
use App\Repositorios\SucursalEmpresaRepo;
use App\Repositorios\CajaEmpresaRepo;
use App\Managers\EmpresaGestion\AgregarMovimientoALaEmpresaManager;
use App\Managers\EmpresaGestion\EliminarMovimientoALaEmpresaManager;





class Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers extends Controller
{

  protected $EmpresaConSociosoRepo;
  protected $MovimientoEstadoDeCuentaEmpresaRepo;
  protected $UserRepo;
  protected $UserEmpresaRepo;
  protected $VendedorEmpresaRepo;


  public function __construct(EmpresaConSociosoRepo                $EmpresaConSociosoRepo, 
                              MovimientoEstadoDeCuentaEmpresaRepo  $MovimientoEstadoDeCuentaEmpresaRepo,
                              UserRepo                             $UserRepo, 
                              UserEmpresaRepo                      $UserEmpresaRepo,
                              VendedorEmpresaRepo                  $VendedorEmpresaRepo
                               )
  {
    $this->EmpresaConSociosoRepo               = $EmpresaConSociosoRepo;       
    $this->MovimientoEstadoDeCuentaEmpresaRepo = $MovimientoEstadoDeCuentaEmpresaRepo;
    $this->UserRepo                            = $UserRepo;
    $this->UserEmpresaRepo                     = $UserEmpresaRepo;
    $this->VendedorEmpresaRepo                 = $VendedorEmpresaRepo;
   
  }


  public function get_panel_admin_de_empresa(Request $Request)
  {

    $Empresa = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

    return view( 'empresa_gestion_paginas.empresa_panel_admin'  , compact('Empresa'));

  }



  //movimiento que mueve el estado de cuenta a empresas
  public function ingresar_movimiento_a_empresa(Request $Request)
  {
     $User              = $Request->get('user_desde_middleware');     
     $Empresa           = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));
     

     $manager           = new AgregarMovimientoALaEmpresaManager(null,$Request->all() );
     if(!$manager->isValid())
     {
       return  ['Validacion'          => false,
                'Validacion_mensaje'  => 'No se pudó agregar éste movimiento: ' . $manager->getErrors()];
     } 

     $Valor      =  $Request->get('valor');
     $Moneda     =  $Request->get('moneda');
     $Tipo_saldo =  $Request->get('tipo_saldo');
     $Nombre     =  $Request->get('nombre');


          if($Tipo_saldo == 'acredor')
          {
            //Logica de estado de cuenta cuando compra
             $this->MovimientoEstadoDeCuentaEmpresaRepo
                  ->setEstadoDeCuentaCuando($Empresa->id, 
                                            $User->id,
                                            $Moneda,
                                            $Valor,
                                            $Nombre ,
                                            'acredor',
                                            Carbon::now('America/Montevideo'),
                                            null);
          }
             

            //si se paga ahora      
            if($Request->get('paga') == 'si') 
            {
                $this->MovimientoEstadoDeCuentaEmpresaRepo
                  ->setEstadoDeCuentaCuando($Empresa->id, 
                                            $User->id,
                                            $Moneda,
                                            $Valor,
                                            'Pago de '.$Nombre ,
                                            'deudor',
                                            Carbon::now('America/Montevideo'),
                                            null);
              
            }  



            return  ['Validacion'          => true,
                     'Validacion_mensaje'  => 'Se ingresó correctamente',
                     'empresa'             => $this->EmpresaConSociosoRepo->find($Empresa->id) ];
  }


  public function eliminar_estado_de_cuenta_empresa(Request $Request)
  {
      $User              = $Request->get('user_desde_middleware');     
     
      $estado_de_cuenta  = json_decode(json_encode($Request->get('estado_de_cuenta')));   

       $manager           = new EliminarMovimientoALaEmpresaManager(null,$Request->all() );
       if(!$manager->isValid())
       {
         return  ['Validacion'          => false,
                  'Validacion_mensaje'  => 'No se pudó agregar éste movimiento: ' . $manager->getErrors()];
       } 

     //elimino a la entidad
      $Entidad = $this->MovimientoEstadoDeCuentaEmpresaRepo->find($estado_de_cuenta->id);
      $this->MovimientoEstadoDeCuentaEmpresaRepo->AnularEsteEstadoDeCuenta($Entidad,$User->id,Carbon::now('America/Montevideo'));

      $Empresa           = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id')); 


     
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se eliminó el estado de cuenta correctamente',
               'empresa'             =>  $Empresa, ];
     
  }











}