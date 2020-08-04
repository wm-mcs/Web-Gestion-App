Vue.component('tipo-de-movimientos' ,
{

data:function(){
    return {
     
     tipo_de_movimientos:[],
     cargando:false

    }
},
methods:{

  get_tipo_de_movimientos:function(){

       let url = '/get_tipo_de_movimientos';     
       let vue = this; 

       this.cargando = true;         

     axios.get(url).then(function (response){  
            let data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.cargando  = false; 
               vue.tipo_de_movimientos = response.data.Socios;    
               $.notify(response.data.Validacion_mensaje, "success"); 
            }
            else
            {
              vue.cargando = false; 
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){
                
               vue.cargando = false;  
               $.notify(error, "error");      
            
           });
  }

},
mounted: function () {
	this.get_tipo_de_movimientos();

},

template:'
<div  v-if="cargando" class="w-100 d-flex flex-column align-items-center p-5">
   <div class="cssload-container">
       <div class="cssload-tube-tunnel"></div>
   </div>
</div>
<div v-else class="p-5">
	<div v-if="tipo_de_movimientos.length" class="">
		
	</div>
	<div v-else class="text-center sub-titulos-class color-text-gris" >Aún no hay tipos de movimientos cargados.</div>
</div>
'
}




);
