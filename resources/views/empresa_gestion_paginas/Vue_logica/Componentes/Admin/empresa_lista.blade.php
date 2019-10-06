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
      <div class="empresa-lista-contiene-img">
        <img :src="empresa.url_img" class="empresa-lista-img">
      </div>
      
      <a :href="empresa.route_admin" > @{{empresa.name}}</a> 
    </div>
  
  
  </div> 

'

}




);