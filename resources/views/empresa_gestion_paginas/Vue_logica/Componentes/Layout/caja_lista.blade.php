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
  }
    

},
template:'  <div class="contiene-lista-caja"> 

              <div :class="getClassLista">
                <span>@{{caja.detalle}} @{{caja.moneda}} @{{caja.valor}}</span>
                <span> Operador:  Fecha: </span>            
                <span> </span>
              </div>             
              
            </div>'

}




);