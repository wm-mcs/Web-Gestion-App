var bus = new Vue();

@include('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.Mixins.mis_chart_mixin')
@include('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.Components.bar_chart')
@include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.order_function')

@include('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.ventas_gastos_segun_periodo')
@include('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.servicios_vendidos')



Vue.component("analiticas-componente-padre", {
  components: {
    "ventas-gastos-segun-periodo": VentasGastoSegunPeridodo,
    'servicios-vendidos':ServiciosVendidos
  },
  data: function() {
    return {
      cargando: false,
      mostrarVentasYGasto: true,
      mostrarAnaliticasServicios: false
    };
  },

  created() {
    document.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    document.removeEventListener("scroll", this.handleScroll);
  },

  methods: {
    handleScroll() {
      if (window.scrollY > 200) {
        this.mostrarAnaliticasServicios = true;

      }
    }
  },

  template: `

<div class="row mx-0 align-items-center">

  <div class="col-12 mb-5">
      <ventas-gastos-segun-periodo v-if="mostrarVentasYGasto"></ventas-gastos-segun-periodo>
  </div>

  <div class="col-12 mb-5">
  <servicios-vendidos v-show="mostrarAnaliticasServicios"></servicios-vendidos>
  </div>

</div>

`
});
