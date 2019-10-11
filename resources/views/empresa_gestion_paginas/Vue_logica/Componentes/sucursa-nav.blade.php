Vue.component('sucursal-nav' ,
{
props:[ 'empresa','sucursal' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'
  <div class="contiene-sucursal">
    <span class="sucursal-estas">Estás en la sucursal</span> 
    <span class="sucursal-nombre">@{{sucursal.name}} <i class="fas fa-chevron-down"></i></span> 
  </div>'

}




);