var reservaAdmin = {

    props:['destacaSocio','reserva'],






    template:`

                         <socio-list
                            :socio="reserva.socio"
                            :empresa="$root.empresa"
                            >
                          </socio-list>

    `
};
