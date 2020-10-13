<?php

namespace App\Http\Controllers\Admin_Empresa;


use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Guardianes\Guardian;
use App\Repositorios\SocioRepo;
use App\Managers\EmpresaGestion\CrearSocioModalManager;
use App\Managers\EmpresaGestion\CrearSucursalManager;
use App\Managers\EmpresaGestion\IngresarMovimientoCajaManager; 
use App\Repositorios\TipoDeServicioRepo;
use App\Repositorios\ServicioContratadoSocioRepo;
use Carbon\Carbon;
use App\Repositorios\MovimientoEstadoDeCuentaSocioRepo;
use App\Repositorios\UserRepo;
use App\Repositorios\UserEmpresaRepo;
use App\Repositorios\VendedorEmpresaRepo;
use App\Repositorios\SucursalEmpresaRepo;
use App\Repositorios\CajaEmpresaRepo;
use App\Managers\EmpresaGestion\AnularCajaManager;
use App\Managers\EmpresaGestion\CrearTipoServicioManager; 
use App\Managers\EmpresaGestion\AgregarAlSocioUnServicioManager;
use App\Managers\EmpresaGestion\AgregarAlSocioMovimientoManager;
use App\Managers\EmpresaGestion\EditarRenovacionDeSocioManager; 
use App\Managers\EmpresaGestion\RenovarDeFormaAutomaticaManager;
use App\Managers\EmpresaGestion\EmpresaRenovacionModalManager; 
use App\Repositorios\ServicioSocioRenovacionRepo;
use Illuminate\Support\Facades\Cache;
use App\Helpers\HelpersGenerales;
use App\Repositorios\AccesoClienteRepo;



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
  protected $CajaEmpresaRepo;
  protected $ServicioSocioRenovacionRepo;
  protected $AccesoClienteRepo;

  public function __construct(EmpresaConSociosoRepo             $EmpresaConSociosoRepo, 
                              Guardian                          $Guardian,
                              SocioRepo                         $SocioRepo, 
                              TipoDeServicioRepo                $TipoDeServicioRepo,
                              ServicioContratadoSocioRepo       $ServicioContratadoSocioRepo,
                              MovimientoEstadoDeCuentaSocioRepo $MovimientoEstadoDeCuentaSocioRepo,
                              UserRepo                          $UserRepo, 
                              UserEmpresaRepo                   $UserEmpresaRepo,
                              VendedorEmpresaRepo               $VendedorEmpresaRepo,
                              SucursalEmpresaRepo               $SucursalEmpresaRepo,
                              CajaEmpresaRepo                   $CajaEmpresaRepo,
                              ServicioSocioRenovacionRepo       $ServicioSocioRenovacionRepo,
                              AccesoClienteRepo                 $AccesoClienteRepo  )
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
    $this->CajaEmpresaRepo                   = $CajaEmpresaRepo;
    $this->ServicioSocioRenovacionRepo       = $ServicioSocioRenovacionRepo;
    $this->AccesoClienteRepo                 = $AccesoClienteRepo;
  }

  public function getPropiedades()
  {
      return ['name','rut','razon_social','email','celular','direccion','factura_con_iva','estado','codigo_pais_whatsapp','mensaje_aviso_especial','tiempo_luego_consulta_control_access'];
  }


  //La pagina de inicio
  public function get_home()
  {
      $User = Auth::user();
      
      if($User->role == 10) //admin
      {
        $Empresas = $this->EmpresaConSociosoRepo->getEntidadActivas();
      }
      elseif($User->role == 4) //vendedor
      {
        $Id_de_empresas = $this->VendedorEmpresaRepo->getEmpresasDeEsteVendedor($User->id);
        $Empresas       = $this->EmpresaConSociosoRepo->getEntidadesConEstosId($Id_de_empresas);
      }
      elseif($User->role <= 3) //dueño
      {
        $Id_de_empresas = $this->UserEmpresaRepo->getEmpresasDeEsteUsuario($User->id);
        $Empresas       = $this->EmpresaConSociosoRepo->getEntidadesConEstosId($Id_de_empresas);       
      }

      return view('empresa_gestion_paginas.home_general', compact('Empresas'));
  }

  /**
   *  La página del control de acceso
   *  */ 
  public function get_control_access_view(Request $Request)
  {
      $UserEmpresa     = $Request->get('user_empresa_desde_middleware'); 
      $Empresa         = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id); 

      return view('empresa_gestion_paginas.control_de_acceso', compact('Empresa'));
  }


  /**
   * verifico que el socio sea de la empresa
   */
  public function control_acceso_socio(Request $Request)
  {
    $UserEmpresa  = $Request->get('user_empresa_desde_middleware'); 
    $Celular      = $Request->get('celular');
    $Socio        = $this->SocioRepo->getSociosBusqueda($UserEmpresa->empresa_id,$Celular );

    if($Socio->count() > 0 )
    {
      $Socio = $Socio->first();
      $this->AccesoClienteRepo->setAcceso($UserEmpresa->empresa_id,$Socio,$Celular,Carbon::now('America/Montevideo'));
      return HelpersGenerales::formateResponseToVue(true,'Se consigío un socio',$Socio);
    }

    return HelpersGenerales::formateResponseToVue(false,'El celular '.$Celular . ' no lo tenemos en la base de datos de nuestros clientes.');    
  }


  
  /**
   * Me manda a la página dónde están los movimientos
   */  
  public function movimientos_de_accesos_view(Request $Request)
  {
      $UserEmpresa     = $Request->get('user_empresa_desde_middleware'); 
      $Empresa         = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id); 

      return view('empresa_gestion_paginas.control_de_acceso_movimientos', compact('Empresa'));
  }

  /**
   * 
   */
  public function get_control_acceso_movimientos(Request $Request)
  {
    $Empresa_id    = $Request->get('user_empresa_desde_middleware')->empresa_id; 
    $ids_ya_usados = $Request->get('ids_ya_usados');
    $array_keys    = [['empresa_id' => $Empresa_id ]];

    $Data = $this->AccesoClienteRepo->getEntidadesMenosIdsYConFiltros($array_keys , $ids_ya_usados, 40);

    return HelpersGenerales::formateResponseToVue(true,'Ok',$Data ); 
  }

  //home admin User
  public function get_admin_empresas_gestion_socios(Request $Request)
  { 
      $Empresas = $this->EmpresaConSociosoRepo
                      ->getEntidad()
                      ->orderBy('id','desc')
                      ->get();
      
      $Empresa  = '';    

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
      /*$Socios          =  $this->SocioRepo->getSociosBusqueda($Empresa->id , null, 40);*/
      $Sucursal        =  $Request->get('sucursal_desde_middleware'); 

      $Actualizar_automaticamente = Cache::remember('ActualizarEmpresaSocios'.$Empresa->id, 3200, function() use($Empresa,$User,$Sucursal) {
          $Hoy                         = Carbon::now('America/Montevideo');
          $Hoy_objet                   = Carbon::now('America/Montevideo')->format('d/m/Y H:i:s');



          $Array_resultados = [];

          //primer me fijo se está activo esto
          if($Empresa->actualizar_servicios_socios_automaticamente != 'si')  
          {
              $Array_resultados = 'no renueva' ;
              return  $Array_resultados ;
          }     

          foreach($this->SocioRepo->getSociosBusqueda($Empresa->id, null,null) as $Socio)
          {

              $Servicios_renovacion  = $this->ServicioSocioRenovacionRepo->getServiciosDeRenovacionDelSocioActivos($Socio->id); 

              //primero me fijo que el socio no tenga deudas
              if(($Socio->saldo_de_estado_de_cuenta_pesos < 0 || $Socio->saldo_de_estado_de_cuenta_dolares < 0))
              {
                  array_push($Array_resultados, json_decode(json_encode([ 'Socio'      => $Socio->name, 
                                                        'Acutualizo' => 'no', 
                                                        'Razon'      => 'debia plata',
                                                        'Fecha'      =>  $Hoy_objet] )  ) );
              }
              else
              {
                  //luego me fijo si tiene servicios de renovacion
                  if($Servicios_renovacion->count() == 0) 
                  {
                      array_push($Array_resultados, json_decode(json_encode([ 'Socio'      => $Socio->name, 
                                                                  'Acutualizo' => 'no', 
                                                                  'Razon'      => 'no tenía servicio con renovación marcada en si',
                                                                  'Fecha'      =>  $Hoy_objet ] )  ) );
                  }

                  //luego segun los servicio de renovacion busco los servicio contratados que tiene por id de tipo de servicio
                  foreach ($Servicios_renovacion as $Servicio_para_renovar)
                  {


                    //busco los servicios del socio
                    $Servicio =  $this->ServicioContratadoSocioRepo->getServiciosDeEsteSocioYConEsteTipoId($Socio->id,$Servicio_para_renovar->tipo_servicio_id); 

                    if($Servicio != null)
                    {
                      
                          //debería buscar servicio a socio y ver si en un mes hay alguno disponible
                          if(Carbon::now('America/Montevideo') > Carbon::parse($Servicio->fecha_vencimiento) || Carbon::now('America/Montevideo')->addDays(2) > Carbon::parse($Servicio->fecha_vencimiento))
                          {
                            //creo el nuevo servicio
                            $Nuevo_servicio = $this->ServicioContratadoSocioRepo->setServicioASocio($Socio->id, 
                                                                                                  $Sucursal->id, 
                                                                                                  $Servicio->tipo_de_servicio, 
                                                                                                  Carbon::parse($Servicio->fecha_vencimiento)->addMonth());

                            //Logica de estado de cuenta cuando compra
                            $this->MovimientoEstadoDeCuentaSocioRepo->setEstadoDeCuentaCuando($Socio->id, 
                                                                                            $User->id,
                                                                                            $Nuevo_servicio->moneda,
                                                                                            $Nuevo_servicio->valor,
                                                                                            'Compra de '.$Nuevo_servicio->name . ' ' . $Nuevo_servicio->id ,
                                                                                            'acredor',
                                                                                            Carbon::now('America/Montevideo'),
                                                                                            $Nuevo_servicio->id);

                            //ajusto el servicio de renovación
                            $this->ServicioSocioRenovacionRepo->setServicioRenovacion($Socio->id,
                                                                                        $Socio->empresa_id,
                                                                                        $Nuevo_servicio->tipo_de_servicio, 
                                                                                        Carbon::now('America/Montevideo')       );

                            array_push($Array_resultados, json_decode(json_encode([ 'Socio'      => $Socio->name, 
                                                            'Acutualizo'  => 'si', 
                                                            'Razon'       => 'Se renovó correctamente' ,
                                                                    'Fecha'      =>  $Hoy_objet] ) )  );
                          }
                          else
                          {
                            array_push($Array_resultados, json_decode(json_encode([ 'Socio'      => $Socio->name, 
                                                                  'Acutualizo'  => 'no', 
                                                                  'Razon'       => 'Aun tenía servicios disponibles',
                                                                    'Fecha'      =>  $Hoy_objet ])  )  );
                          }
                    }



                    

                  }
              }
                  


            
      }

      return $Array_resultados;

      }); 


      
    

      return view('empresa_gestion_paginas.home', compact('Empresa')); 
  }


  //me devulve los oscios activos
  public function get_socios_activos(Request $Request)   
  {      
       $UserEmpresa        = $Request->get('user_empresa_desde_middleware'); 
       $Socios             = $this->SocioRepo->getSociosBusqueda($UserEmpresa->empresa_id,null,null);  
       return [
       'Validacion'  => true,
       'Socios'      => $Socios];     
  }

  public function get_socios_inactivos(Request $Request)   
  {      
       $UserEmpresa        = $Request->get('user_empresa_desde_middleware'); 
       $Socios             = $this->SocioRepo->getSociosInactivos($UserEmpresa->empresa_id);

       if($Socios->count() > 0)
       {
         $Mensaje = "Socios inactivos cargados correctamente";
       }
       else{
        $Mensaje = "No hay socios inactivos";
       }
       return [
       'Validacion'         => true,
       'Validacion_mensaje' => $Mensaje,
       'Socios'             => $Socios];     
  }


  


  public function buscar_socios_activos(Request $Request)
  {
       $User               = $Request->get('user_desde_middleware'); 
       $UserEmpresa        = $Request->get('user_empresa_desde_middleware'); 
       $Socios             = $this->SocioRepo->getSociosBusqueda($UserEmpresa->empresa_id,$Request->get('busqueda'),null);

       return [ 
                'Validacion'  => true,
                'Socios'      => $Socios
              ];  
  }

  //es el panel del socio para editar
  public function get_socio_panel(Request $Request)
  {
       $User            = $Request->get('user_desde_middleware'); 
       $Socio_id        = $Request->get('socio_desde_middleware')->id; 
       $UserEmpresa     = $Request->get('user_empresa_desde_middleware'); 
       $Empresa         = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id); 

       return view('empresa_gestion_paginas.socio_panel', compact('Socio_id','Empresa'));      
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
        $UserEmpresa     = $Request->get('user_empresa_desde_middleware');


    if ($manager->isValid())
    {

       $ExisteElSocio = $this->SocioRepo->ExisteElSocio($UserEmpresa->empresa_id,$Request->get('celular'));

       if($ExisteElSocio)
       {
        return  ['Validacion'          => false,
                 'Validacion_mensaje'  => 'Ya existe un socio con ese celular'];
       }


     
       $Socio                   = $this->SocioRepo
                                       ->getEntidad();


       $Socio->empresa_id       = $UserEmpresa->empresa_id; 
       $Socio->factura_con_iva  = 'no';
       $Socio->estado           = 'si';

       $Propiedades = ['name','celular','cedula','email'];



       $this->SocioRepo->setEntidadDato($Socio,$Request,$Propiedades);  

       $Validacion = true;



       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se creó correctamente '. $Socio->name,
               'Socio'               => $this->SocioRepo->find($Socio->id),
               'Socios'              => $this->SocioRepo->getSociosDeEstaEmpresa($UserEmpresa->empresa_id)];



      
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
    

       $Propiedades = ['estado','name','email','celular','cedula','direccion','rut','razon_social','mutualista','nota','celular_internacional'];

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

       $manager     = new CrearTipoServicioManager(null,$Request->all());
        if(!$manager->isValid())
        {
          return  ['Validacion'          => false,
                   'Validacion_mensaje'  => 'No se pudo crear el servicio: ' . $manager->getErrors()];
        }

       $Propiedades = ['name','tipo','empresa_id','moneda','valor','cantidad_clases'];

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

     $this->TipoDeServicioRepo->destruir_esta_entidad_de_manera_logica($Entidad);

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
       $Propiedades = ['name','tipo','valor','moneda','cantidad_clases'];

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
     $Sucursal    = $Request->get('sucursal_desde_middleware');  


        $manager     = new AgregarAlSocioUnServicioManager(null,$Request->all());
        if(!$manager->isValid())
        {
          return  ['Validacion'          => false,
                   'Validacion_mensaje'  => 'No se pudo agregar el servicio: ' . $manager->getErrors()];
        }

    
       
       //las porpiedades que se van a editar
       $Propiedades = ['name','tipo','moneda','fecha_vencimiento','tipo_servicio_id'];


       //veo si son mas de uno
       if($Request->get('cantidad_de_servicios') > 1)
       {
          $Cantidad = 0; 

          while($Cantidad < (int)$Request->get('cantidad_de_servicios'))
          {
            $Cantidad                    = $Cantidad + 1;
            $Entidad                     = $this->ServicioContratadoSocioRepo->getEntidad();
            $Entidad->socio_id           = $Request->get('socio_id');
            $Entidad->estado             = 'si' ;
            $Entidad->sucursal_emitio_id = $Sucursal->id;
            $Entidad->creado_por         = $User->first_name;
            $Entidad->valor              = round($Request->get('valor')/$Request->get('cantidad_de_servicios'));
            $this->ServicioContratadoSocioRepo->setEntidadDato($Entidad,$Request,$Propiedades);

             //Logica de estado de cuenta cuando compra
             $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Entidad->socio_id, 
                                            $User->id,
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
                                            $User->id,
                                            $Entidad->moneda,
                                            $Entidad->valor,
                                            'Pago de '.$Entidad->name . ' ' . $Entidad->id ,
                                            'deudor',
                                            Carbon::now('America/Montevideo'),
                                            $Entidad->id);
                //Movimiento de caja
                $this->CajaEmpresaRepo->InresarMovimientoDeCaja( $Request->get('empresa_id'), 
                                                                 $Sucursal->id, 
                                                                 $User->id, 
                                                                 'deudor', 
                                                                 $Entidad->moneda, 
                                                                 $Entidad->valor, 
                                                                 'Venta de servicio a socio '. $Socio->name, 
                                                                 Carbon::now('America/Montevideo'), 
                                                                 'Venta Servicio ',
                                                                 $Entidad ) ;
            }         
             
          }

           

       }
       else
       {
          $Entidad                     = $this->ServicioContratadoSocioRepo->getEntidad();
          $Entidad->socio_id           = $Socio->id;
          $Entidad->estado             = 'si' ;
          $Entidad->valor              = round($Request->get('valor'));     
          $Entidad->sucursal_emitio_id = $Sucursal->id; 
          $Entidad->creado_por         = $User->first_name;

          $Entidad = $this->ServicioContratadoSocioRepo->setEntidadDato($Entidad,$Request,$Propiedades);

          
          //ajusto el servicio de renovación
          $this->ServicioSocioRenovacionRepo->setServicioRenovacion($Socio->id,
                                                                    $Socio->empresa_id,
                                                                    $Entidad->tipo_de_servicio, 
                                                                    Carbon::now('America/Montevideo')       );


             //Logica de estado de cuenta cuando compra
             $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Socio->id, 
                                            $User->id,
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
                                            $User->id, 
                                            $Entidad->moneda,
                                            $Entidad->valor,
                                            'Pago de '.$Entidad->name . ' ' . $Entidad->id ,
                                            'deudor',
                                            Carbon::now('America/Montevideo'),
                                            $Entidad->id);

                //Movimiento de caja
                $this->CajaEmpresaRepo->InresarMovimientoDeCaja( $Request->get('empresa_id'), 
                                                                 $Sucursal->id, 
                                                                 $User->id, 
                                                                 'deudor', 
                                                                 $Entidad->moneda, 
                                                                 $Entidad->valor, 
                                                                 'Venta de servicio a socio '. $Socio->name,
                                                                 Carbon::now('America/Montevideo'), 
                                                                 'Venta Servicio',
                                                                 $Entidad ) ;



            } 

             



       }

       
     //actualiza la session
     $this->SucursalEmpresaRepo->actualizarSucursalSession($Sucursal->id);
          
     $Sucursal = $this->SucursalEmpresaRepo->find($Sucursal->id);

     //actualizo cache socio
     $this->ServicioContratadoSocioRepo->ActualizarCache($Socio->id);

     if($Validacion)
     {
       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se creó correctamente ',
               'Socio'               => $this->SocioRepo->find($Socio->id),
               'sucursal'            => $Sucursal ];
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

           $Servicio->editado_por = $User->first_name;
           $Servicio->editado_at  = Carbon::now('America/Montevideo');
       
           //las porpiedades que se van a editar
           $Propiedades = ['name','tipo','moneda','fecha_vencimiento','esta_consumido'];


           $this->ServicioContratadoSocioRepo->setEntidadDatoObjeto($Servicio,$Servicio_a_editar,$Propiedades );
           $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'fecha_vencimiento',$Servicio_a_editar->fecha_vencimiento_formateada );

           $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'fecha_consumido',$Servicio_a_editar->fecha_consumido_formateada );


           //actualizo cache socio
           $this->ServicioContratadoSocioRepo->ActualizarCache($Socio->id);

     if($Validacion)
     {
       return ['Validacion'          => $Validacion,
               'Validacion_mensaje'  => 'Se editó correctamente ',
               'Socio'               => $Socio];
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
     $Sucursal     = $Request->get('sucursal_desde_middleware'); 

      $this->ServicioContratadoSocioRepo->destruir_esta_entidad_de_manera_logica($Servicio);

      //borrar los estados de cuenta
      $Estados_de_cuenta = $this->MovimientoEstadoDeCuentaSocioRepo->getEstadoDeCuentasDelSocioDeUnServicioEnParticular($Socio->id,$Request->get('servicio_id'));

      foreach ($Estados_de_cuenta as $Estado)
      {
       
        if($Estado->tipo_saldo == 'deudor')
        {
          $Tipo_saldo = 'acredor';
        }
        else
        {
          $Tipo_saldo = 'deudor';
        }

        
        $this->MovimientoEstadoDeCuentaSocioRepo->AnularEsteEstadoDeCuenta($Estado,$User->id,Carbon::now('America/Montevideo')); 
       

          //me fijo se el estado es deudor (es decir que pagó) 
          if($Estado->tipo_saldo == 'deudor')
          {
           $Caja = $this->CajaEmpresaRepo->InresarMovimientoDeCaja(     $Request->get('empresa_id'), 
                                                                 $Sucursal->id, 
                                                                 $User->id, 
                                                                 'acredor', 
                                                                 $Estado->moneda, 
                                                                 $Estado->valor, 
                                                                 'Anulación de estado de cuenta de socio '. $Socio->name,               
                                                                 Carbon::now('America/Montevideo'),
                                                                  'Anulacion Estado De Cuenta',
                                                                  null
                                                                 ); 
            //indico que es un movimiento anulador
           $this->CajaEmpresaRepo->setAtributoEspecifico($Caja,'estado_del_movimiento','anulador');
          }
          

      }

      //borrar los moviemiento de caja si es que hubo         
      $MovimeintosDeCaja = $this->CajaEmpresaRepo->getMovimeintosDeEstaSecursalYServicio($Request->get('servicio_id'),$Sucursal->id);

      //actualiza la session
      $this->SucursalEmpresaRepo->actualizarSucursalSession($Sucursal->id);

      $Sucursal = $this->SucursalEmpresaRepo->find($Sucursal->id);

      //actualizo cache socio
      $this->ServicioContratadoSocioRepo->ActualizarCache($Socio->id);

     if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se eliminó correctamente',
               'Socio'               =>  $Socio,
               'sucursal'            =>  $Sucursal ];
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
     $Sucursal          = $Request->get('sucursal_desde_middleware'); 
     
     //las porpiedades que se van a editar  
     $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'fecha_consumido', Carbon::now('America/Montevideo') );

     //indico la sucursal donde se usó
     $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'sucursal_uso_id', $Sucursal->id );

     $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'quien_marco_que_se_uso', $User->first_name );

     $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'esta_consumido', 'si' );

     $Empresa            = $this->EmpresaConSociosoRepo->find($Socio->empresa_id);

     //actualizo cache socio
     $this->ServicioContratadoSocioRepo->ActualizarCache($Socio->id);

    if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se consumió la clase correctamente',
               'Socio'               =>  $Socio,
               'Socios'              =>  $this->SocioRepo->getSociosBusqueda($Empresa->id,null,30) ];
     }
     
  }

  //elimina el estado de cuenta
  public function eliminar_estado_de_cuenta(Request $Request)
  {
     $Validacion = true;
     $User              = $Request->get('user_desde_middleware');  
     $estado_de_cuenta  = json_decode(json_encode($Request->get('estado_de_cuenta')));     
     $Socio             = $Request->get('socio_desde_middleware'); 
     $Sucursal          = $Request->get('sucursal_desde_middleware'); 

          //elimino a la entidad
          $Entidad = $this->MovimientoEstadoDeCuentaSocioRepo->find($estado_de_cuenta->id);
          

          $this->MovimientoEstadoDeCuentaSocioRepo->AnularEsteEstadoDeCuenta($Entidad,$User->id,Carbon::now('America/Montevideo')); 

          


          //me fijo si el estado es deudor (es decir que pagó) 
          if($Entidad->tipo_saldo == 'deudor')
          {
           $Caja = $this->CajaEmpresaRepo->InresarMovimientoDeCaja($Request->get('empresa_id'), 
                                                                   $Sucursal->id, 
                                                                   $User->id, 
                                                                   'acredor', 
                                                                   $Entidad->moneda, 
                                                                   $Entidad->valor, 
                                                                   'Anulación de estado de cuenta de socio '. $Socio->name,
                                                                   Carbon::now('America/Montevideo'),
                                                                   'Anulacion Estado De Cuenta',
                                                                   null);

           //indico que es un movimiento anulador
           $this->CajaEmpresaRepo->setAtributoEspecifico($Caja,'estado_del_movimiento','anulador');

           //actualiza la session
           $this->SucursalEmpresaRepo->actualizarSucursalSession($Sucursal->id);
          }


     


     if($Validacion)
     {
       return ['Validacion'          =>  $Validacion,
               'Validacion_mensaje'  =>  'Se eliminó el estado de cuentacorrectamente',
               'Socio'               =>  $this->SocioRepo->find($Socio->id), 
               'sucursal'            =>  $this->SucursalEmpresaRepo->find($Sucursal->id)];
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

        //le marco el id de vendedor
        $this->EmpresaConSociosoRepo->setAtributoEspecifico($Empresa, 'vendedor_user_id', $Request->get('user_id') );

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



  //cambiar de sucursal
  public function cambiar_de_sucursal(Request $Request)
  {
      $Sucursal = $Request->get('sucursal_desde_middleware');
      
      return [ 'Validacion'               =>  true,
               'Validacion_mensaje'       =>  'Se cambió la sucursal correctamente',
               'Sucursal'                 => $Sucursal   ];

  }

  //obtiene los movimientos de caja
  public function get_movimientos_de_caja_de_sucursal(Request $Request)
  {
    $User              = $Request->get('user_desde_middleware'); 
    $Sucursal          = $Request->get('sucursal_desde_middleware');

    
    /**
     * Desde el front envio esto ..['arqueo','inicial','entre_fechas']
     */
    $TipoDeConsulta = $Request->get('tipo_de_consulta');
    
      
     if($TipoDeConsulta == 'arqueo')
     {
        $Fecha_inicio = Carbon::parse($Request->get('fecha_de_arqueo'))->startOfDay();
        $Fecha_fin    = Carbon::parse($Request->get('fecha_de_arqueo'))->endOfDay();
     }
     elseif($TipoDeConsulta == 'entre_fechas')
     {
       $Fecha_inicio      = Carbon::parse($Request->get('fecha_inicio'))->startOfDay();
       $Fecha_fin         = Carbon::parse($Request->get('fecha_fin'))->endOfDay();
     }
     elseif($TipoDeConsulta == 'inicial')
     {
       $Fecha_fin         = Carbon::now('America/Montevideo');
       $Fecha_inicio      = Carbon::now('America/Montevideo')->subDays(30)->startOfDay();
     }
     else
     {
       $Fecha_fin         = Carbon::now('America/Montevideo');
       $Fecha_inicio      = Carbon::now('America/Montevideo')->subDays(30)->startOfDay();   
     }

     $Fecha_saldo         = $Fecha_fin->format('Y-m-d');

     $Pesos               = $this->CajaEmpresaRepo->getMovimientoYSaldoEntreFechas($Sucursal->id,'$',$Fecha_inicio,$Fecha_fin);

     $Dolares             = $this->CajaEmpresaRepo->getMovimientoYSaldoEntreFechas($Sucursal->id,'U$S',$Fecha_inicio,$Fecha_fin);
    

    return  ['Validacion'                    =>  true,
               'Validacion_mensaje'          =>  'Movimientos de caja cargados correctamente',
               'movimientos_de_caja_pesos'   =>  $Pesos['Movimientos'],
               'movimientos_de_caja_dolares' =>  $Dolares['Movimientos'],
               'Saldo_pesos'                 =>  $Pesos['Saldo'],
               'Saldo_dolares'               =>  $Dolares['Saldo'],
               'Fecha_saldo'                 =>  $Fecha_saldo,
               'Fecha_inicio'                =>  $Fecha_inicio->format('Y-m-d'),
               'Fecha_fin'                   =>  $Fecha_fin->format('Y-m-d')  ];
  }

 

  //ingresar de caja
  public function ingresar_movimiento_caja(Request $Request)
  {
    $User              = $Request->get('user_desde_middleware'); 
    $Sucursal          = $Request->get('sucursal_desde_middleware');
    $manager           = new IngresarMovimientoCajaManager(null, $Request->all() );

    if($manager->isValid())
    {
      $detalle = $Request->get('nombre'); 
      $this->CajaEmpresaRepo->InresarMovimientoDeCaja($Request->get('empresa_id'), 
                                                      $Sucursal->id, 
                                                      $User->id, 
                                                      $Request->get('tipo_saldo'), 
                                                      $Request->get('moneda'), 
                                                      $Request->get('valor'), 
                                                      $detalle, 
                                                      Carbon::now('America/Montevideo'), 
                                                      $Request->get('nombre'));

      //actualiza la session
      $this->SucursalEmpresaRepo->actualizarSucursalSession($Sucursal->id);

      return  ['Validacion'          => true,
               'Validacion_mensaje'  => 'Se ingresó correctamente: ' . $detalle,
               'sucursal'            => $this->SucursalEmpresaRepo->find($Sucursal->id)   ];
    } 
    else
    {
      return  ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se puedo ingresar el movimiento: ' . $manager->getErrors()];
    }
  }

  //eliminar movimiento de caja
  public function eliminar_estado_de_caja(Request $Request)
  {
    $User           = $Request->get('user_desde_middleware'); 
    $Sucursal       = $Request->get('sucursal_desde_middleware');
    $Caja_a_anular  = $this->CajaEmpresaRepo->find( $Request->get('caja_id') );   

    $manager  = new AnularCajaManager(null,$Request->all());

    if(!$manager->isValid())
    {
      return  ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se pudó anular: ' . $manager->getErrors()];
    }

    //verifico d enuevo que no esté anulada ya
    if($Caja_a_anular->estado_del_movimiento != 'anulado'  && $Caja_a_anular->estado_del_movimiento != 'anulador' )
    {
       $CajaAnulador = $this->CajaEmpresaRepo->InresarMovimientoDeCaja($Request->get('empresa_id'), 
                                                      $Sucursal->id, 
                                                      $User->id, 
                                                      $this->CajaEmpresaRepo->DevolverTipoDeSaldoOpuesto($Caja_a_anular->tipo_saldo), 
                                                      $Caja_a_anular->moneda, 
                                                      $Caja_a_anular->valor, 
                                                      $this->CajaEmpresaRepo->getDetalleAlAnular($Caja_a_anular), 
                                                      Carbon::now('America/Montevideo'),
                                                      'Anulacion');

       //indico que se anuló
       $this->CajaEmpresaRepo->setAtributoEspecifico($Caja_a_anular,'estado_del_movimiento','anulado');

       //indico que es un movimiento anulador
       $this->CajaEmpresaRepo->setAtributoEspecifico($CajaAnulador,'estado_del_movimiento','anulador');

       //actualiza la session
       $this->SucursalEmpresaRepo->actualizarSucursalSession($Sucursal->id);

       return  ['Validacion'          => true,
                'Validacion_mensaje'  => 'Se anuló correctamente',
                'sucursal'            => $this->SucursalEmpresaRepo->find($Sucursal->id) ];

    }
    else
    {
      return  ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se puedo anular ésto debido a que previamente ya fue anulado. '];
    }

  }



  public function ingresar_movimiento_a_socio(Request $Request)
  {
     $User              = $Request->get('user_desde_middleware');       
     $Socio             = $Request->get('socio_desde_middleware'); 
     $Sucursal          = $Request->get('sucursal_desde_middleware'); 

     $manager           = new AgregarAlSocioMovimientoManager(null,$Request->all() );
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
             $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Socio->id, 
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
                $this->MovimientoEstadoDeCuentaSocioRepo
                  ->setEstadoDeCuentaCuando($Socio->id, 
                                            $User->id,
                                            $Moneda,
                                            $Valor,
                                            'Pago de '.$Nombre ,
                                            'deudor',
                                            Carbon::now('America/Montevideo'),
                                            null);
                //Movimiento de caja
                $this->CajaEmpresaRepo->InresarMovimientoDeCaja( $Request->get('empresa_id'), 
                                                                 $Sucursal->id, 
                                                                 $User->id, 
                                                                 'deudor', 
                                                                $Moneda, 
                                                                 $Valor, 
                                                                 'Cobro a socio '. $Socio->name . ' por concepto de ' . $Nombre, 
                                                                 Carbon::now('America/Montevideo'), 
                                                                 $Nombre,
                                                                 null ) ;

              //actualiza la session
              $this->SucursalEmpresaRepo->actualizarSucursalSession($Sucursal->id);
            }  



            return  ['Validacion'          => true,
                     'Validacion_mensaje'  => 'Se ingresó correctamente. En minutos ya lo verás reflejado.',
                     'Socio'               =>  $this->SocioRepo->find($Socio->id), 
                     'sucursal'            => $this->SucursalEmpresaRepo->find($Sucursal->id) ];



 

  }

  public function editar_servicio_renovacion(Request $Request)
  {
    $Socio       = $Request->get('socio_desde_middleware'); 

    $manager     = new EditarRenovacionDeSocioManager(null,$Request->all());
    if(!$manager->isValid())
    {
      return  ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se puedó editar: ' . $manager->getErrors()];
    }

    $Servicio_renovacion = $this->ServicioSocioRenovacionRepo->find($Request->get('servicio_renovacion_id'));
    $this->ServicioSocioRenovacionRepo->setAtributoEspecifico($Servicio_renovacion, 'se_renueva_automaticamente', $Request->get('se_renueva_automaticamente'));

    $Socio = $this->SocioRepo->find($Servicio_renovacion->socio_id); 

     return  ['Validacion'          => true,
              'Validacion_mensaje'  => 'Se editó correctamente- En breve lo verás reflejado',
              'Socio'               => $Socio  ];

  }

  public function cargar_servicios_recuerrentes_a_socio(Request $Request)
  {
    $Socio                 = $Request->get('socio_desde_middleware');
    $Servicios_renovacion  = $this->ServicioSocioRenovacionRepo->getServiciosDeRenovacionDelSocioActivos($Socio->id);   
    $Sucursal              = $Request->get('sucursal_desde_middleware'); 
    $User                  = $Request->get('user_desde_middleware');  
    $Hoy                   = Carbon::now('America/Montevideo');

     //primero me fijo el manager 
     $manager           = new RenovarDeFormaAutomaticaManager(null,$Request->all() );
     if(!$manager->isValid())
     {
       return  ['Validacion'          => false,
                'Validacion_mensaje'  => 'No se pudo renovar automáticamente: ' . $manager->getErrors()];
     } 

    //primero me fijo que el socio no tenga deudas
     if(($Socio->saldo_de_estado_de_cuenta_pesos < 0 || $Socio->saldo_de_estado_de_cuenta_dolares < 0))
     {
        return  ['Validacion'          => false,
                'Validacion_mensaje'  => 'El socio ' . $Socio->name . ' tiene deuda. Por esa razón no se puede renovar.'];
     }
         


    //luego me fijo si tiene servicios de renovacion
    if($Servicios_renovacion->count() == 0) 
    {
      return ['Validacion'          => false,
              'Validacion_mensaje'  => 'No tiene servicios renovables.'];
    }

    //luego segun los servicio de renovacion busco los servicio contratados que tiene por id de tipo de servicio
    foreach ($Servicios_renovacion as $Servicio_para_renovar)
    {
     //busco los servicios del socio
     $Servicio =  $this->ServicioContratadoSocioRepo->getServiciosDeEsteSocioYConEsteTipoId( $Socio->id,$Servicio_para_renovar->tipo_servicio_id); 

     //debería buscar servicio a socio y ver si en un mes hay alguno disponible
     if(Carbon::now('America/Montevideo') > Carbon::parse($Servicio->fecha_vencimiento) || Carbon::now('America/Montevideo')->addDays(3) > Carbon::parse($Servicio->fecha_vencimiento))
     {
       //creo el nuevo servicio
       $Nuevo_servicio = $this->ServicioContratadoSocioRepo->setServicioASocio($Socio->id, 
                                                                             $Sucursal->id, 
                                                                             $Servicio->tipo_de_servicio, 
                                                                             Carbon::parse($Servicio->fecha_vencimiento)->addMonth());

       //Logica de estado de cuenta cuando compra
       $this->MovimientoEstadoDeCuentaSocioRepo->setEstadoDeCuentaCuando($Socio->id, 
                                                                        $User->id,
                                                                        $Nuevo_servicio->moneda,
                                                                        $Nuevo_servicio->valor,
                                                                        'Compra de '.$Nuevo_servicio->name . ' ' . $Nuevo_servicio->id ,
                                                                        'acredor',
                                                                        Carbon::now('America/Montevideo'),
                                                                        $Nuevo_servicio->id);

        //ajusto el servicio de renovación
        $this->ServicioSocioRenovacionRepo->setServicioRenovacion($Socio->id,
                                                                    $Socio->empresa_id,
                                                                    $Nuevo_servicio->tipo_de_servicio, 
                                                                    Carbon::now('America/Montevideo')       );
     }
     else
     {
       return ['Validacion'          => false,
               'Validacion_mensaje'  => 'No se puede agregar porque aún tiené algún servicio disponible'];
     }

     

    }

    return ['Validacion'          => true,
            'Validacion_mensaje'  => 'Se renovó correctamente el servicio a ' . $Socio->name,
            'Socios'              =>  $this->SocioRepo->getSociosBusqueda($Socio->empresa_id,null,30)];
  }



  //para editar la parte de empresa desde el modal
  public function editar_empresa_renovacion_automatica(Request $Request)
  {
     $manager           = new EmpresaRenovacionModalManager(null,$Request->all() );

     if(!$manager->isValid())
     {
       return  ['Validacion'          => false,
                'Validacion_mensaje'  => 'No se pudo actualizar: ' . $manager->getErrors()];
     } 

     $Empresa = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

     $Empresa = $this->EmpresaConSociosoRepo->setAtributoEspecifico($Empresa,'actualizar_servicios_socios_automaticamente',$Request->get('actualizar_servicios_socios_automaticamente') );

     return ['Validacion'          => true,
            'Validacion_mensaje'   => 'Se actualizó correctamente',
            'empresa'              =>  $Empresa]; 

  }





  public function email_simples()
  {

      $Email = 'email';
      $Texto = 'Bienvenido a Easy Socio! te hemos creado una cuenta.';

      $User_name  = 'mauricio@worldmaster.com.uy';
      $Contraseña = 'ñakljsdfi';

      $Texto_boton    = 'Ingresar ahora';
      $Link_del_boton = 'asdasd';
      return view('emails.envio_email_creacion_user', compact('Texto','Texto_boton','Link_del_boton','User_name','Contraseña'));

  }


    public function borrar_todos_los_datos_de_esta_empresa($id)
    {
      $Empresa = $this->EmpresaConSociosoRepo->find($id);



      $Movimientos_de_caja = $this->CajaEmpresaRepo->getMovimientosDeCajaDeEstaEmpresa($Empresa->id);
      foreach($Movimientos_de_caja as $Caja)
      {
        $this->CajaEmpresaRepo->setAtributoEspecifico($Caja,'borrado','si');
      }
      $Socios              = $this->SocioRepo->getSociosDeEstaEmpresa($Empresa->id);

      foreach($Socios as $Socio)
      {
        //Borro los servisio
        $Servicios_de_socio = $this->ServicioContratadoSocioRepo->getServiciosContratadosASocios($Socio->id);
        foreach($Servicios_de_socio as $Servicio)
        {
          $this->ServicioContratadoSocioRepo->setAtributoEspecifico($Servicio,'borrado','si');
        }

        $Estado_de_cuenta_del_socio = $this->MovimientoEstadoDeCuentaSocioRepo->getEstadosDecuentaDeEsteSocio($Socio->id);
        foreach($Estado_de_cuenta_del_socio as $Estado_de_cuenta)
        {
          $this->MovimientoEstadoDeCuentaSocioRepo->setAtributoEspecifico($Estado_de_cuenta,'borrado','si');
        }
      }
    }



  
}