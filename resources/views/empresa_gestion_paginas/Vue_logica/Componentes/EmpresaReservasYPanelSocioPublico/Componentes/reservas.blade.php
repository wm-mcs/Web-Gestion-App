var Reservas = {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],

  data: function () {
    return {
      cargando: false,

      showModal: false,

    };
  },
  methods: {

  },
  computed: {},
  mounted: function () {
      alert('me abren');

  },
  created() {},

  template: `
  <div class="col-12 col-lg-4">



    Reservas


  </div>

`,
};
