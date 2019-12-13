
  

   

    var app = new Vue({
    el: '#app',    
    data:{     
      servicios:[],
      empresa: {!! json_encode($Empresa) !!},
      variable:'esta es la instancia',
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

     


    },

    methods:{



    cerrarModal:function(id_modal){

     $(id_modal).modal('hide');
     $('.modal-backdrop').remove();
    },   
    abrirModal:function(id_modal){
    $(id_modal).appendTo("body").modal('show');
    },
    whatsappContactoPagos:function(){
     var url = 'https://api.whatsapp.com/send?phone=59892336388&text=Hola';
     return url;
    }
    
    }

     

   

   });









































