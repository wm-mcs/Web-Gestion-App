Vue.component('agregar-al-socio-un-servicio' ,
{


data:function(){
    return {
      
      
      servicio_data:{
                        name:'',
                        tipo:'',
                        moneda:'',
                        valor:'',
                        fecha_vencimiento:'',
                        cantidad_de_servicios:'',
                        empresa_id:this.empresa.id,
                        socio_id:this.socio.id,
                        socio_empresa_id:'',
                        paga:'si',
                        tipo_servicio_id:'',
                        renovacion_cantidad_en_dias:''

                    },
      tipo_servicio:'',              

    }
},

props:['socio','empresa']
,


mounted: function mounted () {        
      
    

},
computed:{
  es_clase:function(){

  if(this.tipo_servicio != '')
  {
    if(this.servicio_data.tipo == 'clase')
    {
      return true;
    }
  }
  
  },
  se_puede_mostrar:function(){
  if(this.tipo_servicio != '')
  {
   return true;
  }
  }
},
methods:{

 setFecha:function(servicio)
 {
      const  fecha =  new Date();

      fecha.setDate(fecha.getDate() + parseInt(servicio.renovacion_cantidad_en_dias));
      

      this.servicio_data.fecha_vencimiento = fecha.toISOString().slice(0,10);
 },

 abrir_modal:function(){
   $('#modal-agregar-servicio-socio').appendTo("body").modal('show');    
 },
 crear_servicio_a_socio:function(){  

    var url  = '/agregar_servicio_a_socio';

    var data = this.servicio_data;

    var vue = this;

    app.cargando = true;

    axios.post(url,data).then(function (response){  
          var data = response.data;  
          

          if(data.Validacion == true)
          {
            app.cargando = false;
            vue.$emit('actualizar_servicios_de_socios',response.data.servicios);   
            vue.$emit('actualizar_socio',response.data.Socio);   
            app.cerrarModal('#modal-agregar-servicio-socio');
            bus.$emit('sucursal-set', response.data.sucursal); 
            $.notify(data.Validacion_mensaje, "success");      
          }
          else
          {
            app.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
          
    }).catch(function (error){}); 
 },
 cambioTipoDeServicio:function(){  
    var servicio = this.seleccionarUnObjetoSegunAtributo(this.empresa.tipo_servicios,'id',this.tipo_servicio);
    this.servicio_data.name                        = servicio.name;
    this.servicio_data.tipo                        = servicio.tipo;
    this.servicio_data.moneda                      = servicio.moneda;
    this.servicio_data.valor                       = servicio.valor;
    this.servicio_data.tipo_servicio_id            = servicio.id;
    this.servicio_data.renovacion_cantidad_en_dias = servicio.renovacion_cantidad_en_dias;

    this.servicio_data.socio_id         = this.socio.id;
    this.servicio_data.socio_empresa_id = this.socio.empresa_id;

    this.getDate(servicio);

    if(servicio.tipo != 'mensual')
    {
      this.servicio_data.cantidad_de_servicios = servicio.cantidad_clases;
    } 
    else
    {
      this.servicio_data.cantidad_de_servicios = 0;
    }
}, 
seleccionarUnObjetoSegunAtributo:function(lista,atributo,valor){
    return lista.find(function(element) {
      return element.id == valor;
    });
},

     

},
template:'<span>
 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear " v-on:click="abrir_modal">
        <i class="fas fa-cash-register"></i> Vender servicio
       
 </div>

    <div class="modal fade" id="modal-agregar-servicio-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Agregar un servicio a @{{socio.name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                

              

                 <div class="formulario-label-fiel">
                      <label class="formulario-label" >Tipo de servicio <span class="formulario-label-aclaracion"> ¿por clase o mensual?</span></label>
                     <select v-on:change="cambioTipoDeServicio" class="form-control" v-model="tipo_servicio">
                        <option></option>
                        <option v-for="servicio in empresa.tipo_servicios" v-bind:value="servicio.id">@{{servicio.name}}</option>
                       
                        
                      </select>
                  </div> 

                  <div  class="formulario-label-fiel" v-if="se_puede_mostrar">
                      <label class="formulario-label" >Nombre <span class="formulario-label-aclaracion"> Puedes cambiar este nombre si quieres</span></label>
                      <input type="text" class="formulario-field"  v-model="servicio_data.name" placeholder="Nombre"   />
                  </div> 

                  

                    <div  class="formulario-label-fiel" v-if="se_puede_mostrar">
                      <label class="formulario-label" >Moneda</label>
                      <select v-model="servicio_data.moneda" class="form-control">
                        <option>$</option>
                        <option>U$S</option>
                        
                       
                        
                      </select>
                    </div> 

                     <div  class="formulario-label-fiel" v-if="es_clase">
                      <label class="formulario-label" >Cantidad de clases</label>
                      <input type="number" min="1" class="formulario-field"  v-model="servicio_data.cantidad_de_servicios"   />
                     </div>

                     <div  class="formulario-label-fiel" v-if="se_puede_mostrar" >
                      <label class="formulario-label" >Valor <span v-if="servicio_data.cantidad_de_servicios"> de todas las clases</span> </label>
                      <input type="number" min="1" class="formulario-field"  v-model="servicio_data.valor"   />
                     </div> 


                     <div  class="formulario-label-fiel" v-if="se_puede_mostrar" >
                      <label class="formulario-label" >Fecha de vencimiento <span class="formulario-label-aclaracion"> por defecto es a un mes</span></label>
                      <input type="date" class="formulario-field"  v-model="servicio_data.fecha_vencimiento"    />
                     </div> 

                      <div  class="formulario-label-fiel" v-if="se_puede_mostrar">
                      <label class="formulario-label" >¿Lo paga ahora? <span class="formulario-label-aclaracion"> puede que quede debiendo</span></label>
                      <div class="form-control">
                        <input type="radio" id="si" value="si" v-model="servicio_data.paga">
                        <label for="si">si</label>

                         <input type="radio" id="no" value="no" v-model="servicio_data.paga">
                         <label for="no">no</label>
                      </div>
                      
                     </div> 



                     



               
                   <div v-if="$root.cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  </div>
                  <div v-else v-on:click="crear_servicio_a_socio" class="boton-simple">@{{$root.boton_aceptar_texto}}</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>        
        </div>
      </div>
    </div>
  </div>
  
   
  

</span>'
}




);