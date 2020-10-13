@include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.funcion-para-ordenar-resultados-comparando-a-b')


Vue.component('control-de-acceso-movimientos' ,
{



data:function(){
    return {
        cargando:false,
        accesos:[],
        accesos_ids:[],
        scrollPos:0,
        showOrdenarOpciones:false,
        ordenar_segun:'id',       
        ordenar_sentido:'desc',
        filtrar_segun:'',
        ya_pedi_todos:false  
    }
},
mounted() {     
     this.cargarAccesos();
},
ready() {
   
},
methods:{

  
    cargarAccesos:function(borrar_ids){   
        
        if(borrar_ids)
        {
            this.accesos_ids = [];
        }

        if(this.ya_pedi_todos)
        {      
            return false;
        }   
        
        this.cargando = true;

        var url  = '/get_control_acceso_movimientos';

        var data = {                          
                     empresa_id:{{$Empresa->id}},
                     ids_ya_usados:this.accesos_ids
                   };  

        var vue  = this;                
  
        axios.post(url,data).then(function (response){  

        var data = response.data;         

        if(data.Validacion == true)
        {
            if(!data.Data.length)
            {
                vue.ya_pedi_todos = true;
            }

            vue.accesos = vue.accesos.concat(data.Data);  
            vue.setArrayDeIs(data.Data);     
            vue.cargando = false;            
        }
        else
        {
            vue.cargando = false;            
        }
        

        }).catch(function (error){
            vue.cargando = false;
            $.notify(error, "error");              
        });

    },   

    scroll:function(){
        if( (document.body.getBoundingClientRect() ).top > this.scrollPos )
        {    
        }
        else
        {
            window.onscroll = () => {
            let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight + 300 > document.documentElement.offsetHeight;
                if(bottomOfWindow) {    
                if(this.cargando == false)
                {  
                    this.cargarAccesos();            
                } 
                }
            };
        }
        this.scrollPos = document.body.getBoundingClientRect().top;
    
    },
    
    setArrayDeIs:function(accesos){

        accesos.forEach(element => this.accesos_ids.push(element.id));

    }
}, 
created () {
    window.addEventListener('scroll', this.scroll);
},
destroyed () {
    window.removeEventListener('scroll', this.scroll);
},
computed:{
  
 


},
template:`



<div class="w-100 d-flex flex-column align-items-center">


    <p class="text-center col-11 col-lg-8 color-text-gris mb-5"> Pasaron por el control de acceso</p>


    <socio-list 

    v-for="acceso in accesos" 
                 :key="acceso.id" 
                 :acceso="acceso"
               :socio="acceso.socio" 
             :empresa="$root.empresa"
              v-on:ActualizarSocios="cargarAccesos(true)" ></socio-list>
    


    <div v-if="cargando" class="Procesando-text">    
        <div class="cssload-container">
              <div class="cssload-tube-tunnel"></div>
        </div>   
    </div>  
          

   
   

          

</div>




`}




);