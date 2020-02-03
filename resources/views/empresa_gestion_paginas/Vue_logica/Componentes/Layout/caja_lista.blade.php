Vue.component('caja-lista' ,
{
props:[ 'caja','sucursal' ],
data:function(){
    return {
     mostrar:true,
     cargando:false

    }
},
methods:{

anular_movimiento:function(){

       var validation = confirm("¿Quieres eliminar éste movimiento de caja?");

       if(!validation)
       {
        return '';
       }

       var url = '/eliminar_estado_de_caja';

       var vue = this;

       var data = {         caja_id:  this.caja.id,
                         empresa_id:  this.caja.empresa_id};




       this.cargando = true;                  

       axios.post(url,data).then(function(response){ 


          
          if(response.data.Validacion == true)
          {    
             vue.cargando = false;
             bus.$emit('sucursal-set', response.data.sucursal);
             bus.$emit('actualizar-movimientos-de-caja');
             $.notify(response.data.Validacion_mensaje, "success");
          }
          else
          { vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });
  }
  
},
computed:{
  getClassLista:function(){
    return {
      
      'sub-contiene-lista-caja-deudor': this.caja.tipo_saldo === 'deudor',
      'sub-contiene-lista-caja-acredor': this.caja.tipo_saldo === 'acredor',
      'sub-contiene-lista-caja': this.mostrar 
    }
  },
  getClassListaNombreYValor:function(){
    return {
      
      'color-text-success text-bold': this.caja.tipo_saldo === 'deudor',
      'color-text-danger text-bold': this.caja.tipo_saldo === 'acredor'
    }
  },
  sePuedeEliminar:function(){
    if(this.caja.estado_del_movimiento != 'anulado' && this.caja.estado_del_movimiento != 'anulador' )
    {
      return true;
    }
    else
    {
      return false;
    }
  },
  
    

},
template:'  <div class="contiene-lista-caja"> 

              <div :class="getClassLista">
                <span class="caja-lista-nombre" >
                 
                 <span :class="getClassListaNombreYValor">
                     @{{caja.detalle}}

                     @{{caja.moneda}} 

                     @{{caja.valor}}
                 </span> 

                 

                </span>
                <span class="caja-lista-datos-secundarios"> 

                   Operador: <strong>@{{caja.user_name}}</strong>  | Fecha:  <strong>@{{caja.fecha}}</strong> | Id: @{{caja.id}}  
                   <span v-if="sePuedeEliminar"> 

                      |
                      <div v-if="cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                      </div>
                     <span v-else v-on:click="anular_movimiento" class="simula_link" title="Anular éste movimiento.">
                        <i class="fas fa-trash-alt"></i> 
                      </span>

                      </span>

                </span>            
                <span> </span>
              </div>             
              
            </div>'

}




);