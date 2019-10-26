Vue.component('estado-de-cuenta-socio' ,
{


data:function(){
    return {
      
            

    }
},

props:['estado_de_cuenta','empresa','socio']
,


mounted: function mounted () {        
      
   

},
methods:{
    eliminar_estado_de_cuenta:function()
    {

       var validation = confirm("¿Quieres eliminar esté estado de cuenta?");

       if(!validation)
       {
        return '';
       }

       var url = '/eliminar_estado_de_cuenta';

       var vue = this;

       var data = {estado_de_cuenta:this.estado_de_cuenta,
                           socio_id: this.socio.id,
                         empresa_id: this.empresa.id};

       axios.post(url,data).then(function(response){ 


          
          if(response.data.Validacion == true)
          {    
             vue.$emit('actualizar_socio',response.data.Socio); 
             bus.$emit('sucursal-set', response.data.sucursal);
             $.notify(response.data.Validacion_mensaje, "success");
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });
    }
     

},
computed:{
   paga:function()
   {
    if(this.estado_de_cuenta.tipo_saldo == 'deudor')
    {
      return true;
    }
    else
    {
      return false;
    }
   },
   tipoSaldoclassObject: function () {
    return {
      'estado-pago-indication': this.paga,
      'estado-debe-indication': !this.paga
    }
   }

},
template:'
           <div class="contiene-estado-de-cuenta">

            <div class="get_width_100 flex-row-center flex-justifice-space-between">
              <div class="get_width_70 ">
                <div class="estado-detalle" :class="tipoSaldoclassObject"> @{{estado_de_cuenta.detalle}}</div>
                <div class="entidad-lista-servicio-fecha"> Por valor de  @{{estado_de_cuenta.moneda}} @{{estado_de_cuenta.valor}}</div>
                <div class="entidad-lista-servicio-fecha">Registrado el @{{estado_de_cuenta.fecha_formateada}} </div>
                <div class="entidad-lista-servicio-fecha">Estado de cuenta Nº @{{estado_de_cuenta.id}} </div>
              </div>
              

              <div class="get_width_10 flex-row-column">

                 <span class="simula_link" v-on:click="eliminar_estado_de_cuenta" title="Eliminar esté estado de cuenta">

                   <i class="fas fa-trash-alt"></i>

                 </span>
                
              </div>


              
            </div>


             
             

            
           </div>
  

'
}




);