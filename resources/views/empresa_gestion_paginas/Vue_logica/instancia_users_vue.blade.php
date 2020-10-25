
  

   

    var app = new Vue({
    el: '#app',    
    data:{     
      
      variable:'esta es la instancia',
      windowWidth: window.innerWidth,
      resolucion_celular: 320,
      resolucion_tablet: 640,
      resolucion_pc: 1024,
      menu_abierto:false,
      cargando:false,
      boton_aceptar_texto:'Aceptar',
      boton_cancelar_texto:'Cancelar'

      

    },
    mounted: function mounted () {        

      this.$nextTick(() => {
        window.addEventListener('resize', () => {
          this.windowWidth = window.innerWidth
        });
      });


    },

    methods:{



    cerrarModal:function(id_modal){

     $(id_modal).modal('hide');
     $('.modal-backdrop').remove();
    },   
    abrirModal:function(id_modal){
    $(id_modal).appendTo("body").modal('show');
    },
    abrir_menu_cerrar_principal:function(){
      if(this.menu_abierto)
      {
        this.menu_abierto = false;
      }
      else
      {
        this.menu_abierto = true;
      }
    }
    
    
    },
    computed:{
     whatsappContactoPagos:function(){
     var url = 'https://api.whatsapp.com/send?phone=59892336388&text=Hola';
     return url;
    },
    esResolucionDeCelular:function(){
      if(this.windowWidth <= this.resolucion_celular)
      {
        return true;
      }
    },
    esResolucionDeTablet:function(){
      if(this.windowWidth <= this.resolucion_tablet)
      {
        return true;
      }
    },
    esResolucionDePc:function(){
      if(this.windowWidth > this.resolucion_pc)
      {
        return true;
      }
    },
    mostrar_menu:function(){
      if(this.menu_abierto)
      {
        return true;
      }
      if(this.esResolucionDePc)
      {
        return true;
      }

      if(!this.menu_abierto)
      {
        return false;
      }
    },
    contenido_style_width:function(){
      if(this.esResolucionDePc)
      {
        return {
                  width: '80%',
               }
      }
      else
      {
        return {
                  width: '100%',
               }
      }
    }
    
   }

     

   

   });










