Vue.component('caja-lista' ,
{
props:[ 'caja','sucursal' ],
data:function(){
    return {
     mostrar:true

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
  }
    

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

                </span>            
                <span> </span>
              </div>             
              
            </div>'

}




);