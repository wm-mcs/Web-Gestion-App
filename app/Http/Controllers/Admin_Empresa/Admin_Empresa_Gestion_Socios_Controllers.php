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
use App\Managers\EmpresaGestion\CrearSocioModalManager;
use App\Managers\EmpresaGestion\CrearSucursalManager;
use App\Repositorios\TipoDeServicioRepo;
use App\Repositorios\ServicioContratadoSocioRepo;
use Carbon\Carbon;
use App\Repositorios\MovimientoEstadoDeCuentaSocioRepo;
use App\Repositorios\UserRepo;
use App\Repositorios\UserEmpresaRepo;
use App\Repositorios\VendedorEmpresaRepo;
use App\Repositorios\SucursalEmpresaRepo;




class Admin_Empresa_Gestion_Socios_Controllers extends Controller
{

  protected $EmpresaConSociosoRepo;
  protected $Guardian;
  protected $SocioRepo;
  protected $TipoDeServicioRepo;
  protected $ServicioContratadoSocioRepo;
  protected $MovimientoEstadoDeCuentaSocioRepo;
  protected $UserRepo;
  protected $UserEmpresaRepo;
  protected $VendedorEmpresaRepo;
  protected $SucursalEmpresaRepo;

  public function __construct(EmpresaConSociosoRepo             $EmpresaConSociosoRepo, 
                              Guardian                          $Guardian,
                              SocioRepo                         $SocioRepo, 
                              TipoDeServicioRepo                $TipoDeServicioRepo,
                              ServicioContratadoSocioRepo       $ServicioContratadoSocioRepo,
                              MovimientoEstadoDeCuentaSocioRepo $MovimientoEstadoDeCuentaSocioRepo,
                              UserRepo                          $UserRepo, 
                              UserEmpresaRepo                   $UserEmpresaRepo,
                              VendedorEmpresaRepo               $VendedorEmpresaRepo,
                              SucursalEmpresaRepo               $SucursalEmpresaRepo  )
  {
    $this->EmpresaConSociosoRepo             = $EmpresaConSociosoRepo;
    $this->Guardian                          = $Guardian;
    $this->SocioRepo                         = $SocioRepo;
    $this->TipoDeServicioRepo                = $TipoDeServicioRepo;
    $this->ServicioContratadoSocioRepo       = $ServicioContratadoSocioRepo;
    $this->MovimientoEstadoDeCuentaSocioRepo = $MovimientoEstadoDeCuentaSocioRepo;
    $this->UserRepo                          = $UserRepo;
    $this->UserEmpresaRepo                   = $UserEmpresaRepo;
    $this->VendedorEmpresaRepo               = $VendedorEmpresaRepo;
    $this->SucursalEmpresaRepo               = $SucursalEmpresaRepo;
  }

  public function getPropiedades()
  {
    return ['name','user_id','rut','razon_social','email','celular','direccion','factura_con_iva','estado'];
  }

  //home admin User
  public function get_admin_empresas_gestion_socios(Request $Request)
  { 
    $Empresas = $this->EmpresaConSociosoRepo->getEntidadActivasPaginadas( $Request, 20);

    

    //mostrar marcas de la a a la z (orden)

    return view('admin.empresas_gestion_socios.empresa_gestion_socios_home', compact('Empresas','Empresa'));
  }

  //get Crear admin User
  public function get_admin_empresas_gestion_socios_crear()
  {  
    
    return view('admin.empresas_gestion_socios.empresa_gestion_socios_home_crear',compact('Empresa'));
  }

  //set Crear admin User
  public function set_admin_empresas_gestion_socios_crear(Request $Request)
  {     


      //propiedades para crear
      $Propiedades = $this->getPropiedades();

      //traigo la entidad
      $Entidad     = $this->EmpresaConSociosoRepo->getEntidad();

      //grabo todo las propiedades
      $this->EmpresaConSociosoRepo->setEntidadDato($Entidad,$Request,$Propiedades);     

      //para la imagen
      $this->EmpresaConSociosoRepo->setImagen( null ,$Request , 'img', 'Empresa/',  $Entidad->id.'-logo_empresa_socios'   ,'.png',250);

     return redirect()->route('get_admin_empresas_gestion_socios')->with('alert', 'Creado Correctamente');
    
  }

  //get edit admin marca
  public function get_admin_empresas_gestion_socios_editar($id)
  {
    $Empresa         = $this->EmpresaConSociosoRepo->find($id);

    $UsersEmpresa    = $this->UserEmpresaRepo->getEntidad()->where('empresa_id',$Empresa->id )->get();

    $VendedorEmpresa = $this->VendedorEmpresaRepo->getEntidad()->where('empresa_id',$Empresa->id )->get();

    return view('admin.empresas_gestion_socios.empresa_gestion_socios_home_editar',compact('Empresa','UsersEmpresa','VendedorEmpresa'));
  }

  //set edit admin marca
  public function set_admin_empresas_gestion_socios_editar($id,Request $Request)
  {
    $Entidad = $this->EmpresaConSociosoRepo->find($id);    

    //propiedades para crear
    $Propiedades = $this->getPropiedades();    

    //grabo todo las propiedades
    $this->EmpresaConSociosoRepo->setEntidadDato($Entidad,$Request,$Propiedades);

    //para la imagen
    $this->EmpresaConSociosoRepo->setImagen( null ,$Request , 'img', 'Empresa/',  $Entidad->id.'-logo_empresa_socios'   ,'.png',250);

    return redirect()->route('get_admin_empresas_gestion_socios')->with('alert', 'Editado Correctamente');  
  }



  //Panel de gestio de empresa
  public function get_empresa_panel_de_gestion(Request $Request)
  {
       $User            =  $Request->get('user_desde_middleware');  
       $UserEmpresa     =  $Request->get('user_empresa_desde_middleware');     
       $Empresa         =  $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id); 
      

       return view('empresa_gestion_paginas.home', compact('Empresa')); 
  }


  //me devulve los oscios activos
  public function get_socios_activos(Request $Request)   
  {
       $User               = $Request->get('user_desde_middleware'); 
       $UserEmpresa        = $Request->get('user_empresa_desde_middleware'); 
       $Socios             = $this->SocioRepo->getSociosBusqueda($UserEmpresa->empresa_id,null,30);
       return ['socios' => $Socios];     
  }

  //es el panel del socio para editar
  public function get_socio_panel(Request $Request)
  {
       $User            = $Request->get('user_desde_middleware'); 
       $Socio           = $Request->get('socio_desde_middleware'); 
       $UserEmpresa     = $Request->get('user_empresa_desde_middleware'); 
       $Empresa         = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id); 

       return view('empresa_gestion_paginas.socio_panel', compact('Socio','Empresa'));      
  }

  //devulve el socio
  public function get_socio(Request $Request)
  {
       $User            = $Request->get('user_desde_middleware');
       $Socio           = $Request->get('socio_desde_middleware'); 

          return ['Validacion'           => true,
                  'Validacion_mensaje'   => 'Socio agregado correctamente',
                  'Socio'                => $Socio 
                 ];
       
      
  }


  
  //Post para crear socio desde modal
  public function post_crear_socio_desde_modal(Request $Request)
  { 
        $User    = $Request->get('user_desde_middleware');
        $entidad = '';
        $manager = new CrearSocioModalManager($entidad,$Request->all());
        $Validacion = false;


    if ($manager->isValid())
    {
     
       $Socio                   = $this->SocioRepo
                                       ->getEntidad();


       $Socio->empresa_id       = $User->empresa_gestion_id;
       $Socio->factura_con_iva  = 'no';
       $Socio->estado           = 'si';

       $Propiedades = ['name','email','celular','cedula'];

       $this->SocioRepo->setEntidadDato($Socio,$Request,$Propiedades);  

       $Validacion = true;



       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se creo correctamente '. $Socio->name,
               'Socio'               => $this->SocioRepo->find($Socio->id),
               'Socios'              => $this->SocioRepo->getEntidadActivas()];



      
    }
    else
    {
      return  ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'No se puede crear el socio en este momento: ' . $manager->getErrors()];
    }

    
  }

  //para editar al socio desde el modal
  public function post_editar_socio_desde_modal(Request $Request)
  {
        $User       = $Request->get('user_desde_middleware'); 

        $entidad    = '';
        $manager    = new CrearSocioModalManager($entidad,$Request->all());
        $Validacion = true;
        $Socio      = $this->SocioRepo->find($Request->get('id'));
    

       $Propiedades = ['estado','name','email','celular','cedula','direccion','rut','razon_social','mutualista','nota'];

       $this->SocioRepo->setEntidadDato($Socio,$Request,$Propiedades); 

       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se editó correctamente a '. $Socio->name,
               'Socio'               => $this->SocioRepo->find($Socio->id)];
       
    
   
  }

  public function get_tipo_servicios($empresa_id)
  {
    $Validacion  = false;
    $User        = Auth::user();  
    

     if($this->Guardian->son_iguales($User->empresa_gestion_id, $empresa_id) || $User->role == 'adminMcos522' )
     { 

       $Validacion = true;

       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se cargó correctamente',
               'servicios'           => $this->TipoDeServicioRepo->getServiciosActivosDeEmpresa($empresa_id)];

     }
     else
     {
       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Algo anda mal'];
     }   
  }


  //agrega un nuevo tipo de servicio ( Tipo Clase o Tipo Mensual )
  public function set_nuevo_servicio(Request $Request)
  {
       $User        = $Request->get('user_desde_middleware');   
     
       $Empresa     = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));
   
       $Entidad     = $this->TipoDeServicioRepo->getEntidad(); 

       $Propiedades = ['name','tipo','empresa_id'];

       $Entidad->estado = 'si';
       $Entidad->moneda = '$';
       $Entidad->valor  = 0;

       $this->TipoDeServicioRepo->setEntidadDato($Entidad,$Request,$Propiedades); 

       $Validacion = true;

       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se creo correctamente ',
               'empresa'             => $Empresa];    
  }


  //borrar un servicio
  public function delet_servicio(Request $Request)
  {
     
     $User        = $Request->get('user_desde_middleware');     
     $Entidad     = $this->TipoDeServicioRepo->find($Request->get('id')); 
     $Empresa     = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

     $this->TipoDeServicioRepo->destruir_esta_entidad($Entidad);

     $Validacion   = true;

     return  [ 'Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se borró correctamente ',
               'empresa'             => $Empresa];

      
  }




  //editar un servicio
  public function editar_servicio(Request $Request)
  {
       $User        = $Request->get('user_desde_middleware'); 
       $Validacion  = true;
       $Servicio    = $Request->get('servicio'); //me manda la data en array vue       
       $Entidad     = $this->TipoDeServicioRepo->find($Servicio['id']); 
       $Empresa     = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));
       
       //las porpiedades que se van a editar
       $Propiedades = ['name','tipo','valor','moneda'];

       foreach($Propiedades as $Propiedad)
       {
        $Entidad->$Propiedad = $Servicio[$Propiedad];
       }

       $Entidad->save();

       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se editó correctamente ',
               'empresa'             => $Empresa];
  }

  //agrega servicio a socio
  public function agregar_servicio_a_socio(Request $Request)
  {
     $Validacion  = true;
     $User        = $Request->get('user_desde_middleware');  
     $Socio       = $Request->get('socio_desde_middleware'); 

    
       
       //las porpiedades que se van a editar
       $Propiedades = ['name','tipo','moneda','fecha_vencimiento'];


       //veo si son mas de uno
       if($Request->get('cantidad_de_servicios') > 1)
       {
          $Cantidad = 0; 

          while($Cantidad < (int)$Request->get('cantidad_de_servicios'))
          {
            $Cantidad          = $Cantidad + 1;
            $Entidad           = $this->ServicioContratadoSocioRepo->getEntidad();
            $Entidad->socio_id = $Request->get('socio_id');
            $Entidad->estado   = 'si' ;
            $Entidad->valor    = round($Request->get('valor')/$Request->get('cantidad_de_servicios'));
            $this->ServicioContratadoSocioRepo->setEntidadDato($Entidad,$Request,$Propiedades);

             //Logica de estado de cuenta cuando compra
             $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Entidad->socio_id, 
                                            $Entidad->moneda,
                                            $Entidad->valor,
                                            'Compra de '.$Entidad->name . ' ' . $Entidad->id ,
                                            'acredor',
                                            Carbon::now('America/Montevideo'),
                                            $Entidad->id);
            //si se paga ahora      
            if($Request->get('paga') == 'si') 
            {
                $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Entidad->socio_id, 
                                            $Entidad->moneda,
                                            $Entidad->valor,
                                            'Pago de '.$Entidad->name . ' ' . $Entidad->id ,
                                            'deudor',
                                            Carbon::now('America/Montevideo'),
                                            $Entidad->id);
            }     
          }

       }
       else
       {
          $Entidad           = $this->ServicioContratadoSocioRepo->getEntidad();
          $Entidad->socio_id = $Socio->id;
          $Entidad->estado   = 'si' ;
          $Entidad->valor    = round($Request->get('valor'));      

          $this->ServicioContratadoSocioRepo->setEntidadDato($Entidad,$Request,$Propiedades);


             //Logica de estado de cuenta cuando compra
             $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Socio->id, 
                                            $Entidad->moneda,
                                            $Entidad->valor,
                                            'Compra de '.$Entidad->name . ' ' . $Entidad->id ,
                                            'acredor',
                                            Carbon::now('America/Montevideo'),
                                            $Entidad->id);


            //si se paga ahora      
            if($Request->get('paga') == 'si') 
            {
                $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Socio->id, 
                                            $Entidad->moneda,
                                            $Entidad->valor,
                                            'Pago de '.$Entidad->name . ' ' . $Entidad->id ,
                                            'deudor',
                                            Carbon::now('America/Montevideo'),
                                            $Entidad->id);
            }           

       }

       

       //Logica d emoviemiento de caja     


     if($Validacion)
     {
       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se creó correctamente ',
               'Socio'               => $this->SocioRepo->find($Socio->id),];
     }
    
  }


  //editar servicio a socio
  public function editar_servicio_a_socio(Request $Request)
  {      
     $User              = $Request->get('user_desde_middleware');
     $Servicio_a_editar = json_decode(json_encode($Request->get('servicio_a_editar')));
     $Socio             = $Request->get('socio_desde_middleware');    

       
           $Validacion  = true;

           $Servicio = $this->ServicioContratadoSocioRepo->find($Servicio_a_editar->id);
       
           //las porpiedades que se van a editar
           $Propiedades = ['name','tipo','moneda','fecha_vencimiento','esta_consumido'];


           $this->ServicioContratadoSocioRepo->setEntidadDatoObjeto($Servicio,$Servicio_a_editar,$Propiedades );
           $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'fecha_vencimiento',$Servicio_a_editar->fecha_vencimiento_formateada );

           $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'fecha_consumido',$Servicio_a_editar->fecha_consumido_formateada );

     if($Validacion)
     {
       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se editó correctamente ',
               'Socio'               =>  $Socio];
     }
  }

  //obtengo servicios
  public function get_servicios_de_socio(Request $Request)
  {

     $Validacion        = true;
     $User              = $Request->get('user_desde_middleware'); 
     $Socio             = $this->SocioRepo->find($Request->get('socio_id'));

    if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se cargó correctamente',
               'servicios'           =>  $this->ServicioContratadoSocioRepo->getServiciosContratadosASocios($Request->get('socio_id'))];
     }
  }

  //borra el servicio del socio
  public function borrar_servicio_de_socio(Request $Request)
  {
     $Validacion   = true;
     $User         = $Request->get('user_desde_middleware'); 
     $Servicio     = $this->ServicioContratadoSocioRepo->find($Request->get('servicio_id'));
     $Socio        = $Request->get('socio_desde_middleware'); 


      

      $this->ServicioContratadoSocioRepo->destruir_esta_entidad_de_manera_logica($Servicio);

      //borrar los estados de cuenta
      $Estados_de_cuenta = $this->MovimientoEstadoDeCuentaSocioRepo->getEstadoDeCuentasDelSocioDeUnServicioEnParticular($Socio->id,$Request->get('servicio_id'));

      

      foreach ($Estados_de_cuenta as $Estado) {
        $this->MovimientoEstadoDeCuentaSocioRepo->destruir_esta_entidad_de_manera_logica($Estado);
      }

      //borrar los moviemiento de caja si es que hubo         


     if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se eliminó correctamente',
               'Socio'               =>  $Socio];
     }
     
  }

  //indica que el servicio tipo calse ya fué usado
  public function indicar_que_se_uso_el_servicio_hoy(Request $Request)
  {

     $Validacion        = true;
     $User              = $Request->get('user_desde_middleware');  
     $Servicio_a_editar = json_decode(json_encode($Request->get('servicio_a_editar')));     
     $Socio             = $Request->get('socio_desde_middleware'); 
     $Servicio          = $this->ServicioContratadoSocioRepo->find($Servicio_a_editar->id);
     
     //las porpiedades que se van a editar  
     $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'fecha_consumido', Carbon::now('America/Montevideo') );

     $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'esta_consumido', 'si' );

     $Empresa            = $this->EmpresaConSociosoRepo->find($Socio->empresa_id);

    if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se consumió la clase correctamente',
               'Socio'               =>  $Socio,
               'Empresa'             =>  $Empresa];
     }
     
  }

  //elimina el estado de cuenta
  public function eliminar_estado_de_cuenta(Request $Request)
  {
     $Validacion = true;
     $User              = $Request->get('user_desde_middleware');  
     $estado_de_cuenta  = json_decode(json_encode($Request->get('estado_de_cuenta')));     
     $Socio             = $Request->get('socio_desde_middleware'); 

          //elimino a la entidad
          $Entidad = $this->MovimientoEstadoDeCuentaSocioRepo->find($estado_de_cuenta->id);
          

          $this->MovimientoEstadoDeCuentaSocioRepo->destruir_esta_entidad_de_manera_logica($Entidad);

          $Socio = $this->SocioRepo->find($estado_de_cuenta->socio_id);


     


     if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se eliminó el estado de cuentacorrectamente',
               'Socio'               =>  $Socio];
     }
     
       
  }



  public function get_user_rol_panel_gestion(Request $Request)
  {
      $Users = $this->UserRepo->getUserSegunRole($Request->get('role'));

       return ['Validacion'          =>  true,
               'Validacion_mensaje'  =>  'Se cargaron los usuarios correctamente',
               'Usuarios'            =>  $Users];

  }


  public function set_user_a_empresa(Request $Request)
  {
     //gerarqui para validar si se crea 3 = user dueño
      $Gerarquia = 3;

      //Envio user para validar
      $User          = $this->UserRepo->find( $Request->get('user_id'));
      $Sucursal_id   = $Request->get('sucursal_id');

      //creo el usuario
      $Validacion = $this->UserEmpresaRepo->setAsociarEmpresaYUser($Request->get('empresa_id'), $Request->get('user_id'),$Gerarquia,$User,$Sucursal_id ); 
      //traigo la empresa
      $Empresa      = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));
      $UsersEmpresa = $this->UserEmpresaRepo->getUsuariosDeEstaEmpresa($Empresa->id); 

      return [ 'Validacion'               =>  $Validacion['Validacion'],
               'Validacion_mensaje'       =>  $Validacion['Validacion_mensaje'],
               'UsersEmpresa'             =>  $UsersEmpresa     ];

  }

    public function delete_user_a_empresa(Request $Request)
    {
      $User     = $this->UserEmpresaRepo->find($Request->get('user_id'));
      $Empresa  = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

      $this->UserEmpresaRepo->destruir_esta_entidad($User);
      $UsersEmpresa = $this->UserEmpresaRepo->getUsuariosDeEstaEmpresa($Empresa->id); 
      return [ 'Validacion'               =>  true,
               'Validacion_mensaje'       =>  'Usuario desvinculado correctamente',
               'UsersEmpresa'             =>  $UsersEmpresa     ];
    }

  public function set_vendedor_a_empresa(Request $Request)
  {
        //gerarqui para validar si se crea
        $Gerarquia = 4;

        //Envio user para validar
        $User = $this->UserRepo->find( $Request->get('user_id'));
      
        //creo el usuario
        $Validacion = $this->VendedorEmpresaRepo->setAsociarEmpresaYVendedor($Request->get('empresa_id'), $Request->get('user_id'),$Gerarquia,$User ); 

        //traigo la empresa
        $Empresa      = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

        $UsersEmpresa = $this->VendedorEmpresaRepo->getVendedoresDeEstaEmpresa($Empresa->id);

        return [ 'Validacion'               =>  $Validacion['Validacion'],
                 'Validacion_mensaje'       =>  $Validacion['Validacion_mensaje'],
                 'UsersEmpresa'             =>  $UsersEmpresa     ];
      

      
  }
    public function delete_vendedor_a_empresa(Request $Request)
    {
      $User     = $this->VendedorEmpresaRepo->find($Request->get('user_id'));
      $Empresa  = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

      $this->VendedorEmpresaRepo->destruir_esta_entidad($User);

      $UsersEmpresa = $this->VendedorEmpresaRepo->getVendedoresDeEstaEmpresa($Empresa->id);

      return [ 'Validacion'               =>  true,
               'Validacion_mensaje'       =>  'Vendedor desvinculado correctamente',
               'UsersEmpresa'             =>  $UsersEmpresa     ];
    }

  public function crear_sucursal(Request $Request)
  {
    $manager = new CrearSucursalManager('',$Request->all());

    if($manager->isValid())
    {
      $Validacion_mensaje = 'Sucursal creada correctamente';

      $this->SucursalEmpresaRepo->crearSucursal($Request);
    }
    else
    {
      $Validacion_mensaje = $manager->getErrors();
    }

    return [   'Validacion'               =>  $manager->isValid(),
               'Validacion_mensaje'       =>  $Validacion_mensaje,
               'empresa'                  =>  $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'))     ];
  }

  public function editar_sucursal(Request $Request)
  {
    $manager = new CrearSucursalManager('',$Request->all());

    if($manager->isValid())
    {
      $Validacion_mensaje = 'Sucursal ediatada correctamente';

      $this->SucursalEmpresaRepo->editarSucursal($Request);
    }
    else
    {
      $Validacion_mensaje = $manager->getErrors();
    }

    return [   'Validacion'               =>  $manager->isValid(),
               'Validacion_mensaje'       =>  $Validacion_mensaje,
               'empresa'                  =>  $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'))     ];
  }

  //caja crear registro
  public function crear_registro_de_caja(Request $Request)
  {
    
  }



  
}