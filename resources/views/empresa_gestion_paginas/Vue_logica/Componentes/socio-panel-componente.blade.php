Vue.component('socio-panel-componente',
{


props:['empresa'],

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
   return socio.servicios_contratados_del_socio;
  },
  servicios_no_disponibles:function(){
  return socio.servicios_contratados_del_socio;
  }

},
template:'<span>


  <div class="panel-socio-header-contenedor">
    <div class="panel-socio-name">

    @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.modal-editar-socio')    

    </div>
    <div class="panel-socio-contiene-acciones"> 
      
     <agregar-al-socio-un-servicio :socio="socio"                                     
                                   :empresa="empresa"
                                   @actualizar_socio="actualizar_socio" ></agregar-al-socio-un-servicio>  
      
     

    </div>


  </div>

  <div class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios que contrató <span class="color-text-success">disponibles</span> </div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-socio-lista :servicio="servicio" 
                                  :empresa="empresa"
            
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio in servicios_disponibles" :key="servicio.id"> 
            </servicio-socio-lista>
            
          

      </div>
  </div>

   <div class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios que contrató el socio <span class="color-text-gris">No disponibles</span></div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-socio-lista :servicio="servicio" 
                                  :empresa="empresa"
            
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio in servicios_disponibles" :key="servicio.id"> 
            </servicio-socio-lista>
            
          

      </div>
  </div>

  <div class="empresa-contendor-de-secciones">
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
 

  
    
     




  

  

</span>'

});