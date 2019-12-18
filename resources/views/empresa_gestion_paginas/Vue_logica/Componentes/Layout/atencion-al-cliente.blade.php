Vue.component('atencion-al-cliente' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<div class="contacto-whatsapp-contenedor" >
  <img :src="empresa.vendedor_de_esta_empresa.foto_de_perfil" class="contacto-whatsapp-img">

  <div class="contiene-aclaracio-y-resouesta">
    <div class="aclaracion-de-respuesta">                      
        Normalmente respondo en <span class="text-success">menos de 1 hora</span> 
    </div>
    <div class="contacto-whatsapp-texto">
    Hola ¿en qué te puedo ayudar? 
    </div> 
  </div>
</div>'

}




);