Vue.component('empresa-lista' ,
{

props:['empresa']
,  

data:function(){
    return {
       

    }
}, 


methods:{
},
template:'

  <div class="empresa-lista-contenedor">
    <div class="empresa-lista-header">
      <img :src="empresa.url_img" class="empresa-lista-img">
      <a :href="empresa.route_admin" > @{{empresa.name}}</a> 
    </div>
  
  
  </div> 

'

}




);