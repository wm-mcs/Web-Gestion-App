Vue.component('atencion-al-cliente' ,
{
props:[ 'empresa' ],
data:function(){
    return {


    }
},
methods:{



},
template:`
<div class="col-12 contenedor-atencion-comercial-layout">
<a :href="empresa.vendedor_de_esta_empresa.link_whatsapp_send">
	<div class="contacto-whatsapp-contenedor" >
  <img :src="empresa.vendedor_de_esta_empresa.foto_de_perfil" class="contacto-whatsapp-img">

  <div class="contiene-aclaracio-y-resouesta">
    <div class="contacto-whatsapp-texto">
    Hola ¿en qué te puedo ayudar?
    </div>
  </div>
</div>
</a>
</div>
`

}




);
