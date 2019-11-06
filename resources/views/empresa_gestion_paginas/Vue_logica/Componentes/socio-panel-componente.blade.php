Vue.component('socio-panel-componente',
{


props:['empresa','sucursal'],

data:function(){
    return {
      socio:{!! json_encode($Socio) !!}

    }
}, 
mounted: function mounted () {        

       
       
      


},
methods:{  

    
     
     
     getServiciosDelSocio:function(servicios){

      if(servicios == 'mounted')
      {   

         var url  = '/get_servicios_de_socio';

          var data = {


               socio_id: this.socio.id,
             empresa_id: this.empresa.id
            

          };

      var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              $.notify(data.Validacion_mensaje, "success");
              
              
              
              vue.servicios_del_socio = data.servicios;

              
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
           }).catch(function (error){

                     
            
           });


      }
      else
      {
        this.servicios_del_socio = servicios;
      }
        

     },
     editSocioShow:function()
     {
      $('#modal-editar-socio').appendTo("body").modal('show');
     }, 

     editSocioPost:function()
     {


      var url  = '/post_editar_socio_desde_modal';

      var data = {


           id: this.socio.id,
         name: this.socio.name,
         cedula:this.socio.cedula,
         email:this.socio.email,
         celular:this.socio.celular,
         direccion:this.socio.direccion,
         rut:this.socio.rut,
         razon_social:this.socio.razon_social,
         mutualista:this.socio.mutualista,
         nota:this.socio.nota ,
         estado:this.socio.estado,
         socio_id: this.socio.id,
       empresa_id: this.empresa.id

      };

      var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              $.notify(data.Validacion_mensaje, "success");
              
              vue.socio = response.data.Socio;
              
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
           }).catch(function (error){

                     
            
           });

     },
     actualizar_socio:function(socio){
      this.socio = socio;
     },
     
    

         

},
computed:{
  servicios_disponibles:function(){
   return this.socio.servicios_contratados_del_socio.filter(function(servicio) {
      
       if( servicio.esta_vencido == true || servicio.se_consumio == true )
        {
          return false ;
        }
        else
        {
          return true;
        }

      
    });
  },
  servicios_no_disponibles:function(){
  return this.socio.servicios_contratados_del_socio.filter(function(servicio) {
      return servicio.esta_vencido == true || servicio.se_consumio == true;
    });
  }

},
template:'<span>


  <div class="panel-socio-header-contenedor">
    <div class="panel-socio-name">

      @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.modal-editar-socio')    

    </div>
    <div class="panel-socio-contiene-acciones"> 

     <ingresar-movimiento-a-socio  @actualizar_socio="actualizar_socio" :empresa="empresa" :sucursal="sucursal" :socio="socio"></ingresar-movimiento-a-socio> 
     
     <agregar-al-socio-un-servicio :socio="socio"                                     
                                   :empresa="empresa"
                                   @actualizar_socio="actualizar_socio" ></agregar-al-socio-un-servicio>  
      
     

    </div>


  </div>
  <div  v-if="socio.servicios_renovacion_del_socio.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios más frecuentemente comprados. Se usan para cargar de forma rápido o renovación automática </div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-renovacion-lista  
                                  :empresa="empresa"
                                  :servicio_renovacion="servicio_renovacion"
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio_renovacion in socio.servicios_renovacion" :key="servicio_renovacion.id"> 
            </servicio-renovacion-lista>  
            
          

      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    No hay servicios renovación creados <i class="far fa-frown"></i>
  </div>

  <div  v-if="servicios_disponibles.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios que contrató <span class="color-text-success">disponibles</span> </div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-socio-lista :servicio="servicio" 
                                  :empresa="empresa"
            
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio in servicios_disponibles" :key="servicio.id"> 
            </servicio-socio-lista>  
            
          

      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    No hay servicios disponibles <i class="far fa-frown"></i>
  </div>

   <div v-if="servicios_no_disponibles.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios que contrató el socio <span class="color-text-gris">No disponibles</span></div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-socio-lista :servicio="servicio" 
                                  :empresa="empresa"
            
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio in servicios_no_disponibles" :key="servicio.id"> 
            </servicio-socio-lista>
            
          

      </div>
  </div>
  

  <div v-if="socio.estado_de_cuenta_socio.length" class="empresa-contendor-de-secciones">
      <div class="estado-de-cuenta-titulo-saldo-contenedor ">

          <span class="empresa-titulo-de-secciones">Estado de cuenta del socio</span>

          <estado-de-cuenta-socio-saldo :empresa="empresa" :socio="socio"> </estado-de-cuenta-socio-saldo>
      </div>
      <div class="contiene-estados-de-cuenta-lista">
        
          


          


           <estado-de-cuenta-socio v-for="estado in socio.estado_de_cuenta_socio" 
                                   :estado_de_cuenta="estado" 
                                   :empresa="empresa"
                                   :socio="socio"
                                   :key="estado.id"
                                   @actualizar_socio="actualizar_socio">
                                     
           </estado-de-cuenta-socio>

          
            
          

      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    Aún no hay movimientos de estado de cuenta  <i class="far fa-frown"></i>
  </div>
 

  
    
     




  

  

</span>'

});