Vue.component("avisos-empresa", {
	props: ["empresa"],
	data: function() {
		return {};
	},
	methods: {},
	computed: {
		tiene_algo_activo: function() {
			if (this.empresa.servicios_contratados_a_empresas_activos.length) {
				return true;
			} else {
				return false;
			}
		},
		debe_plata_pesos: function() {
			if (this.empresa.estado_de_cuenta_saldo_pesos < 0) {
				return true;
			} else {
				return false;
			}
		},
		debe_plata_dolares: function() {
			if (this.empresa.estado_de_cuenta_saldo_dolares < 0) {
				return true;
			} else {
				return false;
			}
		},
		tiene_mensaje_personalizado: function() {
			if (this.empresa.mensaje_aviso_especial != "") {
				return true;
			} else {
				return false;
			}
		},
		mostrar_contenedor_avisos: function() {
			if (
				this.tiene_mensaje_personalizado ||
				this.debe_plata_pesos ||
				this.debe_plata_dolares
			) {
				return true;
			} else {
				return false;
			}
		}
	},
	template: `
<div  v-if="mostrar_contenedor_avisos" class="ocultar-esto contiene-mensaje-empresa-top">

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span>

    <div v-if="debe_plata_pesos" class="linea-de-aviso-individual"><i class="fas fa-exclamation"></i> Hay un saldo pendiente de pago de $ @{{Math.abs(this.empresa.estado_de_cuenta_saldo_pesos)}} .
    <br> Si se trata de algún error por favor reportarlo  <a :href="this.$root.whatsappContactoPagos"><i class="fab fa-whatsapp-square"></i> <strong>aquí  </strong> </a>.
    <br> Datos para realizar el pago: <strong>Caja Ahorro BROU PESOS 00156513100002 (viejo: 177 0469556)</strong>.
    <br> Se puede realizar en: <strong>Abitab, Red Pagos</strong> , Sucursales del Brou y por transferencia bancaria.
    <br>
     Luego de efectuar el pago enviar comprobante <a :href="this.$root.whatsappContactoPagos"><i class="fab fa-whatsapp-square"></i> <strong>aquí  </strong></a>.



    </div>
    <div v-if="debe_plata_dolares" class="linea-de-aviso-individual">
    <br>
    <br>

    <i class="fas fa-exclamation"></i> Hay un saldo pendiente de pago de US$ @{{Math.abs(this.empresa.estado_de_cuenta_saldo_dolares)}} .
    <br> Si se trata de algún error por favor reportarlo  <a :href="this.$root.whatsappContactoPagos"><i class="fab fa-whatsapp-square"></i> <strong>aquí  </strong> </a>
    <br> Datos para realizar el pago: <strong>Caja Ahorro BROU DOLARES 00156513100001 (viejo: 177 0633012)</strong> . Luego de efectuar el pago enviar comprobante <a :href="this.$root.whatsappContactoPagos"><i class="fab fa-whatsapp-square"></i> <strong>aquí  </strong></a>
.

    </div>




    <div v-if="tiene_mensaje_personalizado" class="linea-de-aviso-individual">


    <i class="fas fa-exclamation"></i>
     <strong>@{{this.empresa.mensaje_aviso_especial}}</strong>
    </div>





</div>
`
});
