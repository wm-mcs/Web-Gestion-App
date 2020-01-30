
  

   

    var app = new Vue({
    el: '#app',    
    data:{     
      servicios:[],
      empresa: {!! json_encode($Empresa) !!},
      variable:'esta es la instancia',
      windowWidth: window.innerWidth,
      resolucion_celular: 320,
      resolucion_tablet: 640,
      menu_abierto:false,
      cargando:false,
      busqueda:'',
      @if( $Empresa != '')
      Sucursal: {!! json_encode(Session::get('sucursal'.$Empresa->id)) !!},
      @else
      Sucursal:'', 
      @endif 
      @if(Session::has('vista_socios_lista'))
      vista_lista:true
      @else
      vista_lista:true
      @endif


      

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
      if(this.windowWidth > this.resolucion_tablet)
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









































