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
use App\Managers\EmpresaGestion\EditarRenovacionDeEmpresaManager;
use App\Managers\EmpresaGestion\CrearPlanManager;
use App\Managers\EmpresaGestion\CrearEmpresaManager;
use App\Managers\EmpresaGestion\CrearServicioAEmpresaManager; 
use App\Repositorios\TipoDeServicioAEmpresaRepo;
use App\Repositorios\ServicioEmpresaRenovacionRepo;
use App\Repositorios\ServicioContratadoEmpresaRepo;
use App\Repositorios\PaisRepo;
use App\Managers\EmpresaGestion\PaisManager;






class Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers extends Controller
{

  protected $EmpresaConSociosoRepo;
  protected $MovimientoEstadoDeCuentaEmpresaRepo;
  protected $UserRepo;
  protected $UserEmpresaRepo;
  protected $VendedorEmpresaRepo;
  protected $TipoDeServicioAEmpresaRepo;
  protected $SucursalEmpresaRepo;
  protected $ServicioEmpresaRenovacionRepo;
  protected $ServicioContratadoEmpresaRepo;
  protected $PaisRepo;


  public function __construct(EmpresaConSociosoRepo                $EmpresaConSociosoRepo, 
                              MovimientoEstadoDeCuentaEmpresaRepo  $MovimientoEstadoDeCuentaEmpresaRepo,
                              UserRepo                             $UserRepo, 
                              UserEmpresaRepo                      $UserEmpresaRepo,
                              VendedorEmpresaRepo                  $VendedorEmpresaRepo,
                              TipoDeServicioAEmpresaRepo           $TipoDeServicioAEmpresaRepo,
                              SucursalEmpresaRepo                  $SucursalEmpresaRepo, 
                              ServicioEmpresaRenovacionRepo        $ServicioEmpresaRenovacionRepo,
                              ServicioContratadoEmpresaRepo        $ServicioContratadoEmpresaRepo,
                              PaisRepo                             $PaisRepo
                               )
  {
    $this->EmpresaConSociosoRepo               = $EmpresaConSociosoRepo;       
    $this->MovimientoEstadoDeCuentaEmpresaRepo = $MovimientoEstadoDeCuentaEmpresaRepo;
    $this->UserRepo                            = $UserRepo;
    $this->UserEmpresaRepo                     = $UserEmpresaRepo;
    $this->VendedorEmpresaRepo                 = $VendedorEmpresaRepo;
    $this->TipoDeServicioAEmpresaRepo          = $TipoDeServicioAEmpresaRepo;
    $this->SucursalEmpresaRepo                 = $SucursalEmpresaRepo;
    $this->ServicioEmpresaRenovacionRepo       = $ServicioEmpresaRenovacionRepo;
    $this->ServicioContratadoEmpresaRepo       = $ServicioContratadoEmpresaRepo;
    $this->PaisRepo                            = $PaisRepo;
   
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


     
       return ['Validacion'          =>  true,
               'Validacion_mensaje'  =>  'Se eliminó el estado de cuenta correctamente',
               'empresa'             =>  $Empresa, ];
     
  }



  public function get_planes_empresa()
  {
    $planes = $this->TipoDeServicioAEmpresaRepo->getServiciosActivosAEmpresas();

    return  ['Validacion'          => true,
             'Validacion_mensaje'  => 'Planes agregados corectamente',
             'planes'              =>  $planes];
  }



  public function crear_plan(Request $Request)
  {
       $manager           = new CrearPlanManager(null,$Request->all() );
       if(!$manager->isValid())
       {
         return  ['Validacion'          => false,
                  'Validacion_mensaje'  => 'No se pudó crear el plan: ' . $manager->getErrors()];
       } 

       $Propiedades = ['name','tipo','moneda','valor','cantidad_socios' ,'cantidad_sucursales'];

       $this->TipoDeServicioAEmpresaRepo->setEntidadDato($this->TipoDeServicioAEmpresaRepo->getEntidad(),$Request,$Propiedades); 

       $planes = $this->TipoDeServicioAEmpresaRepo->getServiciosActivosAEmpresas();

       return  ['Validacion'          => true,
                'Validacion_mensaje'  => 'Planes agregados corectamente',
                'planes'              =>  $planes];

       

  }

  public function editar_plan_empresa(Request $Request)
  {
       $Plan        = $Request->get('plan'); //me manda la data en array vue       
       $Entidad     = $this->TipoDeServicioAEmpresaRepo->find($Plan['id']); 
      
       
       //las porpiedades que se van a editar
       $Propiedades = ['name','tipo','moneda','valor','cantidad_socios' ,'cantidad_sucursales'];

       foreach($Propiedades as $Propiedad)
       {
        $Entidad->$Propiedad = $Plan[$Propiedad];
       }

       $Entidad->save();

       return ['Validacion'          => true,
               'Validacion_mensaje'  => 'Se editó correctamente ',
                'planes'             =>  $this->TipoDeServicioAEmpresaRepo->getServiciosActivosAEmpresas()];
  }


  //creo empresa
  public function crear_empresa_nueva(Request $Request)
  {
       $manager           = new CrearEmpresaManager(null,$Request->all() );
       if(!$manager->isValid())
       {
         return  ['Validacion'          => false,
                  'Validacion_mensaje'  => 'No se pudó crear: ' . $manager->getErrors()];
       } 


       //crear la empresa 
       $Empresa = $this->EmpresaConSociosoRepo->CrearEmpresaComoVendedor( $Request->get('empresa_name'), 
                                                                          $Request->get('empresa_email'), 
                                                                          $Request->get('empresa_celular'), 
                                                                          $Request->get('factura_con_iva'), 
                                                                          $Request->get('rut'), 
                                                                          $Request->get('razon_social')
                                                                        );  

       //creo al usuario
       $Usuario_creado = $this->UserRepo->setUserCuandoCreoEmpresa($Request->get('user_name'), 
                                                                   $Request->get('user_email'), 
                                                                   $Request->get('user_celular'));

       
       //creo la sucursal
       $Sucursal = $this->SucursalEmpresaRepo->crearSucursalAlCrearEmpresa('Principal',$Empresa->id);


       //asocio al uusario como empresa
       $this->UserEmpresaRepo->setAsociarEmpresaYUser( $Empresa->id, 
                                                       $Usuario_creado->id,
                                                       3,
                                                       $Usuario_creado,
                                                       $Sucursal->id);



       $UsuaioAuth = Auth::user();


       //asocio al uusario vendedor como usuario también
       $this->UserEmpresaRepo->setAsociarEmpresaYUser( $Empresa->id, 
                                                       $UsuaioAuth->id,
                                                       3,
                                                       $UsuaioAuth,
                                                       $Sucursal->id);


       //asocio al vendedor que es el user auth 
       $this->VendedorEmpresaRepo->setAsociarEmpresaYVendedor($Empresa->id,$UsuaioAuth->id,4,$UsuaioAuth); 

       //le marco el id de vendedor
       $this->EmpresaConSociosoRepo->setAtributoEspecifico($Empresa, 'vendedor_user_id',$UsuaioAuth->id );



       //Busco el tipo de plan de la empresa
       $Plan = $this->TipoDeServicioAEmpresaRepo->find($Request->get('plan_id'));

       //creo el serivicio de renovación
       $this->ServicioEmpresaRenovacionRepo->setServicioRenovacion($Empresa->id,$Plan,Carbon::now('America/Montevideo')); 

       $Fecha_vencimiento = Carbon::now('America/Montevideo')->addDays(15)->endOfDay();

       //creo el servicio en si
       $this->ServicioContratadoEmpresaRepo->setServicioAEmpresa($Empresa,$Plan,$Fecha_vencimiento);


       $empresas = $this->EmpresaConSociosoRepo->getEntidadActivas();
       return  ['Validacion'          => true,
                'Validacion_mensaje'  => 'Se agregó correctamente la empresa',
                'empresas'            =>  $empresas];





  }

  public function editar_servicio_renovacion_empresa(Request $Request)
  {


    $manager     = new EditarRenovacionDeEmpresaManager(null,$Request->all());
    if(!$manager->isValid())
    {
      return  ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se puedó editar: ' . $manager->getErrors()];
    }

    $Servicio_renovacion = $this->ServicioEmpresaRenovacionRepo->find($Request->get('servicio_renovacion_id'));
    $this->ServicioEmpresaRenovacionRepo->setAtributoEspecifico($Servicio_renovacion, 'se_renueva_automaticamente', $Request->get('se_renueva_automaticamente'));

    $this->ServicioEmpresaRenovacionRepo->ActualizarCache($Request->get('empresa_id'));

    

     return  ['Validacion'          => true,
              'Validacion_mensaje'  => 'Se editó correctamente- En breve lo verás reflejado',
              'empresa'             => $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'))  ];
  }

  public function agregar_servicio_a_empresa(Request $Request)
  {
    $manager     = new CrearServicioAEmpresaManager(null,$Request->all());
    if(!$manager->isValid())
    {
      return  ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se pudó crear: ' . $manager->getErrors()];
    }

    $User              = $Request->get('user_desde_middleware'); 

    $Empresa           = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));
    $Servicio          = $this->TipoDeServicioAEmpresaRepo->find($Request->get('tipo_servicio_id'));
    $Fecha_vencimiento = $Request->get('fecha_vencimiento');


    $ServicioAEmrpesa = $this->ServicioContratadoEmpresaRepo->setServicioAEmpresa($Empresa, $Servicio, $Fecha_vencimiento);

    $this->ServicioEmpresaRenovacionRepo->setServicioRenovacion($Empresa->id, $Servicio, Carbon::now('America/Montevideo'));


    //estado de cuenta 
    $this->MovimientoEstadoDeCuentaEmpresaRepo->setEstadoDeCuentaCuando($Empresa->id , 
                                                                        $User->id, 
                                                                        $ServicioAEmrpesa->moneda, 
                                                                        $ServicioAEmrpesa->valor, 
                                                                        'Cargos por: '.$ServicioAEmrpesa->name, 
                                                                        'acredor', 
                                                                        Carbon::now('America/Montevideo'), 
                                                                        $ServicioAEmrpesa->id); 


    if($Request->get('paga') == 'si')
    {
      $this->MovimientoEstadoDeCuentaEmpresaRepo->setEstadoDeCuentaCuando($Empresa->id , 
                                                                        $User->id, 
                                                                        $ServicioAEmrpesa->moneda, 
                                                                        $ServicioAEmrpesa->valor, 
                                                                        'Pago de cargos por: '.$ServicioAEmrpesa->name, 
                                                                        'deudor', 
                                                                        Carbon::now('America/Montevideo'), 
                                                                        $ServicioAEmrpesa->id); 

    } 

    return  ['Validacion'          => true,
             'Validacion_mensaje'  => 'Se creó correctamente',
             'empresa'             => $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'))];


  }


  public function editar_servicio_a_empresa(Request $Request)
  {
     $User              = $Request->get('user_desde_middleware');
     $Servicio_a_editar = json_decode(json_encode($Request->get('servicio_a_editar')));
     

       
           $Validacion  = true;

           $Servicio = $this->ServicioContratadoEmpresaRepo->find($Servicio_a_editar->id);
       
           //las porpiedades que se van a editar
           $Propiedades = ['name','tipo','moneda','fecha_vencimiento'];


           $this->ServicioContratadoEmpresaRepo->setEntidadDatoObjeto($Servicio,$Servicio_a_editar,$Propiedades );
           $this->ServicioContratadoEmpresaRepo->setAtributoEspecifico($Servicio,'fecha_vencimiento',$Servicio_a_editar->fecha_vencimiento_formateada );

           


           //actualizo cache socio
           $this->ServicioContratadoEmpresaRepo->ActualizarCache($Request->get('empresa_id'));

     if($Validacion)
     {
       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se editó correctamente ',
               'empresa'             => $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'))];
     }
  }

  public function borrar_servicio_de_empresa(Request $Request)
  {
     $Validacion   = true;
     $User         = $Request->get('user_desde_middleware'); 
     $Servicio     = $this->ServicioContratadoEmpresaRepo->find($Request->get('servicio_id'));
     


      $this->ServicioContratadoEmpresaRepo->destruir_esta_entidad_de_manera_logica($Servicio);

      //borrar los estados de cuenta
      $Estados_de_cuenta = $this->MovimientoEstadoDeCuentaEmpresaRepo->getMovimientosDeEstadoDeCuentaDeEsteServicio($Request->get('empresa_id'),$Request->get('servicio_id'));

      foreach ($Estados_de_cuenta as $Estado)
      {      
        
        $this->MovimientoEstadoDeCuentaEmpresaRepo->AnularEsteEstadoDeCuenta($Estado,$User->id,Carbon::now('America/Montevideo'));  
          

      }


      //actualizo cache socio
      $this->ServicioContratadoEmpresaRepo->ActualizarCache($Request->get('empresa_id'));

     if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se eliminó correctamente',
               'empresa'             =>  $this->EmpresaConSociosoRepo->find($Request->get('empresa_id')) ];
     }
  }


  public function crear_pais(Request $Request)
  {
       $manager           = new PaisManager(null,$Request->all() );


       

       if(!$manager->isValid())
       {
         return  ['Validacion'          => false,
                  'Validacion_mensaje'  => 'No se pudo crear: ' . $manager->getErrors()];

       } 



       $Propiedades      = ['name','code','currencyCode','estado'];

       $Entidad          = $this->PaisRepo->getEntidad();
       $Entidad->borrado = 'no';

       $Entidad          = $this->PaisRepo->setEntidadDato($Entidad,$Request,$Propiedades);
       $this->PaisRepo->setImagenDesdeVue($Request->get('imagen'), 'Paises/', str_replace(' ' ,'-', $Request->get('name')),'.png', 100);

       
 
       $Paises           = $this->PaisRepo->getEntidadActivas();



       return  ['Validacion'          => true,
                'Validacion_mensaje'  => 'Se creo correctamente el país',
                'Paises'              =>  $Paises];
  }

  public function editar_pais(Request $Request)
  {
       $manager           = new PaisManager(null,$Request->all() );
       if(!$manager->isValid())
       {
         return  ['Validacion'          => false,
                  'Validacion_mensaje'  => 'No se pudo editar: ' . $manager->getErrors()];
       } 
  }

  //api public paises
  public function get_paises(Request $Request)
  {
    
    if(Auth::guest())
    {
      //crear un tokrn y guardarlo en la base de datos
      //crear un tokrn y guardarlo en la base de datos
    }
    else
    {

    }

    $Paises = $this->PaisRepo->getEntidadActivas();

    

    return  ['Validacion'          => true,
             'Validacion_mensaje'  => 'Países cargados correctamente',
             'Paises'              => $Paises, 
             'Header'              => $Request->header()];
    
   


  }













}