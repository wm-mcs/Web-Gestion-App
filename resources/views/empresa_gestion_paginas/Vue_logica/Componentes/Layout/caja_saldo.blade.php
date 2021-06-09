

Vue.component('caja-saldo' ,
{

data:function(){
    return {
      sucursal:{!! json_encode(Session::get('sucursal'.$Empresa->id)) !!},
      modal_pesos:'#modal-caja-pesos',
      modal_dolares:'#modal-caja-dolares',
      valor_actual_pesos:'0',
      fecha_de_saldo:'',
      movimientos_de_caja_pesos:0,
      movimientos_de_caja_dolares:0,
      saldo_pesos:0,
      saldo_dolares:0,
      fecha_inicio:new Date(),
      fecha_fin:new Date(),
      fecha_de_arqueo:'',
      buscar_entre_fechas_mostrar:false,
      tipo_de_consulta:'inicial',
      inicial:'inicial',
      arqueo:'arqueo',
      entre_fechas:'entre_fechas',
      cargando:false

    }
},
mounted: function mounted () {



},
methods:{

    disparador:function(tipo_de_consulta)
    {
      this.tipo_de_consulta = tipo_de_consulta;
      this.getMovimientosDeCaja();
    },

     setFecha:function()
     {
       var fecha =  new Date();
       fecha.setMonth(fecha.getMonth());


       this.fecha_de_arqueo = fecha.toISOString().slice(0,10);
     },

     mostrar_busqueda:function(){
     if(this.buscar_entre_fechas_mostrar)
     {
      this.buscar_entre_fechas_mostrar = false;
     }
     else
     {
      this.buscar_entre_fechas_mostrar = true;
     }
     },

    getMovimientosDeCaja:function(){

       var url = '/get_movimientos_de_caja_de_sucursal';

      var data = {
                       empresa_id : this.sucursal.empresa_id,
                      sucursal_id : this.sucursal.id,
                     fecha_inicio : this.fecha_inicio,
                        fecha_fin : this.fecha_fin,
                  fecha_de_arqueo : this.fecha_de_arqueo,
                 tipo_de_consulta : this.tipo_de_consulta

                 };
      var vue = this;

      this.cargando = true;

     axios.post(url,data).then(function (response){
            var data = response.data;


            if(data.Validacion == true)
            {



               vue.fecha_de_saldo = data.Fecha_saldo;
               vue.fecha_inicio    = data.Fecha_inicio;
               vue.fecha_fin       = data.Fecha_fin;
               vue.fecha_de_arqueo = data.Fecha_fin;

               if(data.movimientos_de_caja_pesos)
               {
                vue.movimientos_de_caja_pesos = data.movimientos_de_caja_pesos;
                vue.saldo_pesos =  data.Saldo_pesos;
               }
               if(data.movimientos_de_caja_dolares)
               {
                vue.movimientos_de_caja_dolares = data.movimientos_de_caja_dolares;
                vue.saldo_dolares = data.Saldo_dolares;
               }

               $.notify(response.data.Validacion_mensaje, "success");
               vue.cargando = false;
            }
            else
            { app.cargando = false;
              $.notify(response.data.Validacion_mensaje, "error");
              vue.cargando = false;
            }

           }).catch(function (error){
            vue.cargando = false;


           });

    },


    esMatoyIgualACero:function(valor){
        if(valor < 0 )
        {
          return false;
        }
        else
        {
          return true;
        }
    },
    esDistintoACero:function(valor){
      if(valor == 0)
      {
        return false;
      }
      else
      {
        return true;
      }
    },
    abrir_modal_pesos:function(){
      this.getMovimientosDeCaja();
      app.abrirModal(this.modal_pesos);
    },
    abrir_modal_dolares:function(){
      this.getMovimientosDeCaja();
      app.abrirModal(this.modal_dolares);
    }


},
created() {

    bus.$on('sucursal-set', (sucursal) => {
      this.sucursal = sucursal
    });

    bus.$on('actualizar-movimientos-de-caja', () => {
      this.getMovimientosDeCaja();
    })
},
template:`<div>

  <div  class="w-100 my-2 p-3" v-on:click="abrir_modal_pesos" title="Clcik para ver detalle de caja">
     <div class="btn btn-outline-success w-100 align-items-center cursor-pointer">
      <i class="fas fa-cash-register"></i> Caja $ sucursal <span class="text-bold" >@{{sucursal.name}}</span>
     </div>
  </div>

 <div v-if="esDistintoACero(saldo_dolares)" class="w-100 my-2 p-3" v-on:click="abrir_modal_dolares" title="Clcik para ver detalle de caja">


     <div class="Boton-Primario-Sin-Relleno ">
       Caja dólares sucursal <span class="text-bold" >@{{sucursal.name}}</span>
     </div>

 </div>


 <div class="modal fade" id="modal-caja-pesos" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h4  class="modal-title get_width_80" id="myModalLabel">
            Movimientos de caja pesos:
            <div class="saldo-modal">
              Saldo al día @{{fecha_de_saldo}}
              <span class="saldo-modal-valor"> <span v-if="cargando"> Cargando ...</span> <span v-else> $ @{{saldo_pesos}} </span></span>
            </div>
            @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.caja_buscar_entre_fechas')

          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>

        </div>
        <div v-if="cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  </div>
        <div v-if="esDistintoACero(movimientos_de_caja_pesos)"  class="modal-body text-center">
        <div class="fechas-buscar-texto text-center">
          Movimientos entre las fechas <strong> @{{fecha_inicio}} -  @{{fecha_fin}}</strong> y el saldo acumulado al  @{{fecha_fin}} es de <strong> $ @{{saldo_pesos}} </strong> .
        </div>


          <caja-lista v-for="(caja,index) in movimientos_de_caja_pesos"
                       :key="caja.id"
                       :caja="caja"
                       :sucursal="sucursal">



          </caja-lista>



        </div>
        <div  v-else class="fechas-buscar-texto text-center">
          No hay movimientos entre estas fechas  <strong> @{{fecha_inicio}} -  @{{fecha_fin}}</strong>
        </div>

      </div>
    </div>
  </div>

  <div  class="modal fade" id="modal-caja-dolares" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Movimientos de caja dolares

            <div class="saldo-modal">
              Saldo al día @{{fecha_de_saldo}}
              <span class="saldo-modal-valor"> <span v-if="cargando"> Cargando ...</span> <span v-else>U$S @{{saldo_dolares}}  </span> </span>
            </div>
            @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.caja_buscar_entre_fechas')
          </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>

        </div>
        <div v-if="cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  </div>
        <div v-if="esDistintoACero(movimientos_de_caja_dolares)" class="modal-body text-center">
        <div class="fechas-buscar-texto text-center">
          Movimientos entre las fechas <strong> @{{fecha_inicio}} -  @{{fecha_fin}}</strong> y el saldo acumulado al  @{{fecha_fin}} es de <strong> U$S @{{saldo_dolares}} </strong> .
        </div>
          <caja-lista v-for="(caja,index) in movimientos_de_caja_dolares"
                       :key="caja.id"
                       :caja="caja"
                       :sucursal="sucursal">



          </caja-lista>
        </div>
         <div  v-else class="fechas-buscar-texto text-center">
          No hay movimientos entre estas fechas  <strong> @{{fecha_inicio}} -  @{{fecha_fin}}</strong>
        </div>



      </div>
    </div>
  </div>






</div>`

}




);
