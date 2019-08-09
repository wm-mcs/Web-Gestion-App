Vue.component('socio-panel-componente',
{


props:['servicios'],

data:function(){
    return {
      socio:'hola',
      socio_id: 1,
      servicios_del_socio:'',
      
      empresa_id: {{$Empresa_gestion->id}},

    }
}, 
mounted: function mounted () {        

       this.getSocio();
       this.getServiciosDelSocio('mounted');
      


},
methods:{

     getServicios:function(){


       var url = '/get_tipo_servicios' + this.empresa_id;

       var vue = this;

       axios.get(url).then(function(response){  
          
          if(response.data.Validacion == true)
          {
            vue.servicios = response.data.servicios;
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });
     

     },     
     getSocio:function()
     {
       var url = '/get_socio' + this.socio_id;

       var vue = this;

       axios.get(url).then(function(response){  
          
          if(response.data.Validacion == true)
          {
            vue.socio = response.data.Socio;
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });
     },
     getServiciosDelSocio:function(servicios){

      if(servicios == 'mounted')
      {   

         var url  = '/get_servicios_de_socio';

          var data = {


               socio_id: this.socio_id,
             empresa_id: this.empresa_id
            

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
     es_mayor_que_sero:function(valor){
        if(valor >= 0)
        {
          return true;
        }
        else
        {
          return false;
        }
     }
    

         

},
template:'<span>


  <div class="panel-socio-header-contenedor">
    <div class="panel-socio-name">

    @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.modal-editar-socio')    

    </div>
    <div class="panel-socio-contiene-acciones"> 
      
     <agregar-al-socio-un-servicio :socio="socio"  
                                   :servicios="servicios"
                                   @actualizar_servicios_de_socios="getServiciosDelSocio"
                                   @actualizar_socio="actualizar_socio" ></agregar-al-socio-un-servicio>  
      
     

    </div>


  </div>

  <div class="panel-socio-contiene-seccion">
      <div class="panel-socio-titulo-seccion">Servicios que contrató el socio</div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-socio-lista :servicio="servicio" 
            @actualizar_servicios_de_socios="getServiciosDelSocio" 
                          @actualizar_socio="actualizar_socio"

                           v-for="servicio in servicios_del_socio" :key="servicio.id"> 
            </servicio-socio-lista>
            
          

      </div>
  </div>

  <div class="panel-socio-contiene-seccion">
      <div class="estado-de-cuenta-titulo-saldo-contenedor ">

          <span class="panel-socio-titulo-seccion">Estado de cuenta del socio</span>

          <div v-if="!socio.saldo_de_estado_de_cuenta_pesos == 0 || !socio.saldo_de_estado_de_cuenta_dolares == 0" class="flex-row-center">
            
         
              <div v-if="es_mayor_que_sero(socio.saldo_de_estado_de_cuenta_pesos)" class="estado-de-cuenta-saldo estado-pago-indication">
                <span v-if="socio.saldo_de_estado_de_cuenta_pesos == 0">
                  Esta al día <i class="far fa-grin"></i> (en pesos)
                </span>
                <span v-else>
                  Tiene a favor $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}} <i class="far fa-grin"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe pesos: $ @{{ Math.abs(socio.saldo_de_estado_de_cuenta_pesos)}}  <i class="far fa-frown-open"></i>
              </div>

              <div v-if="es_mayor_que_sero(socio.saldo_de_estado_de_cuenta_dolares)" class="estado-de-cuenta-saldo estado-pago-indication">
                <span v-if="socio.saldo_de_estado_de_cuenta_dolares == 0">
                  Esta al día <i class="far fa-grin"></i> (en dolares)
                </span>
                <span v-else>
                  Tiene a favor U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}} <i class="far fa-grin"></i>
                </span>
                
              </div>
              <div v-else class="estado-de-cuenta-saldo estado-debe-indication">
                Debe pesos: U$S @{{Math.abs(socio.saldo_de_estado_de_cuenta_dolares)}}  <i class="far fa-frown-open"></i>
              </div>

           </div>   
           <div v-else class="estado-de-cuenta-saldo estado-pago-indication"">
                  Está al día <i class="far fa-grin"></i> 
           </div>
      </div>
      <div class="contiene-estados-de-cuenta-lista">
        
          


          


           <estado-de-cuenta-socio v-for="estado in socio.estado_de_cuenta_socio" 
                                   :estado_de_cuenta="estado" 
                                   @actualizar_socio="actualizar_socio">
                                     
           </estado-de-cuenta-socio>

          
            
          

      </div>
  </div>
 

  
    
     




  

  

</span>'

});