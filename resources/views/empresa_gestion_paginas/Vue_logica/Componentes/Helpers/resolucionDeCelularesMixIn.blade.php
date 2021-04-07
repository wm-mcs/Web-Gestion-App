const resolucionDeCelularesMixIn = {
  data: function() {
    return {
      windowWidth: window.innerWidth,
      resolucion_celular: 320,
      resolucion_tablet: 640,
      resolucion_pc: 1024
    };
  },
  mounted: function mounted() {
    this.$nextTick(() => {
      window.addEventListener("resize", () => {
        this.windowWidth = window.innerWidth;
      });
    });
  },

  methods: {},
  computed: {
    esResolucionDeCelular: function() {
      if (this.windowWidth <= this.resolucion_celular) {
        return true;
      }
    },
    esResolucionDeTablet: function() {
      if (this.windowWidth <= this.resolucion_tablet) {
        return true;
      }
    },
    esResolucionDePc: function() {
      if (this.windowWidth > this.resolucion_pc) {
        return true;
      }
    }
  }
};
