var reservaAdmin = {

    props:['destacaSocio','reserva'],


    methods:{

        eliminar:function(){

        },
        marcarComoHecha:function(){

        }
    },



    template:`

                         <socio-list
                            :socio="reserva.socio"
                            :empresa="$root.empresa"
                            >
                          </socio-list>

    `
};
