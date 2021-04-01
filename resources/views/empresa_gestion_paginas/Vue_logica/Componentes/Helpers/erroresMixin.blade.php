const erroresMixIn = {
  data: function () {
    return {
      errores: [],
    };
  },
  methods: {
    setErrores: function (erroresDataBackend) {
      if(erroresDataBackend.isArray){
        this.errores = erroresDataBackend;
      }else{
        this.errores = Object.values(erroresDataBackend);
      }
    },
    handlerClickErrores:function(){
        this.errores = [];
    }
  },
  
  computed: {},
 
};
