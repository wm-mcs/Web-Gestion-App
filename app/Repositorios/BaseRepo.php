<?php
namespace App\Repositorios;

use App\Repositorios\Emails\EmailsRepo;
use Input;

/**
 * Contiene metodos comunes para todo los repositorios
 */
abstract class BaseRepo
{
    protected $entidad;

    public function __construct()
    {
        $this->entidad = $this->getEntidad();
    }

    /**
     * funcion que va a hacer creada el los repo que extiendan.
     */
    abstract public function getEntidad();

    public function getEmailsRepo()
    {
        return new EmailsRepo();
    }

    public function find($id)
    {
        return $this->entidad->find($id);
    }

    public function destroy_entidad($id)
    {
        $entidad_a_borrar = $this->find($id);
        $entidad_a_borrar->delete();
    }

    //elimina esta entidad
    public function destruir_esta_entidad($Entidad)
    {
        $Entidad->delete();
    }

    /**
     *  Devulve entidades filtrando por estos parametros
     *  @param $Entidad_key_array es un array de este tipo [
    [ 'where_tipo' => 'where',
    'key'        => 'empresa_id',
    'value'      => $Empresa_id
    ]
    ]
     *  @param $Cantidad La cantidad que quiero cada vez que pido
     *  @param $Ordenar_key Orden key
     *  @param $Order_sentido sentido del orden
     *  @param $Borrado si trae borrados o no
     *
     *  @return array
     */
    public function getEntidadesMenosIdsYConFiltros($Entidad_key_array = null,
        $Ids_ya_cargados = [],
        $Cantidad = null,
        $Ordenar_key = 'fecha',
        $Order_sentido = 'desc',
        $Borrado = 'no') {
        $Entidades = $this->getEntidad()
            ->where(function ($q) use ($Entidad_key_array) {

                if ($Entidad_key_array != null) {
                    foreach ($Entidad_key_array as $clave => $valor) {
                        if ($valor['where_tipo'] == 'where') {
                            $q->where($valor['key'], $valor['value']);
                        } elseif ($valor['where_tipo'] == 'orWhere') {
                            $q->orWhere($valor['key'], $valor['value']);
                        } elseif ($valor['where_tipo'] == 'whereBetween') {
                            $q->whereBetween($valor['key'], [
                                $valor['value']['start'],
                                $valor['value']['end'],
                            ]);
                        }
                    }
                }
            }
            )
            ->where('borrado', $Borrado)
            ->whereNotIn('id', $Ids_ya_cargados)
            ->orderBy($Ordenar_key, $Order_sentido)
            ->get();

        if ($Cantidad != null && $Entidades->count() >= $Cantidad) {
            return $Entidades->take($Cantidad);
        }

        return $Entidades;
    }

    public function getEntidadesDeEstaEmpresa(
        $Empresa_id,
        $Ordenar_key = 'id',
        $Order_sentido = 'desc',
        $Estado = 'si',
        $Borrado = 'no') {

        return $this->entidad
            ->where('empresa_id', $Empresa_id)
            ->where('borrado', $Borrado)
            ->orderBy($Ordenar_key, $Order_sentido)
            ->get();
    }

    //se cambia la propiedad borrado a si
    public function destruir_esta_entidad_de_manera_logica($Entidad)
    {
        $Entidad->borrado = 'si';
        $Entidad->save();
    }

    /**
     * Entidades Activas
     */
    public function getEntidadActivas()
    {
        return $this->entidad
            ->where('estado', 'si')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Entidades Activas
     */
    public function getEntidadActivasOrdenadasSegun($Order_by, $Asc_desc)
    {
        return $this->entidad
            ->where('estado', 'si')
            ->where('borrado', 'no')
            ->orderBy($Order_by, $Asc_desc)
            ->get();
    }

    /**
     * Entidades Activas Paginadas
     */
    public function getEntidadActivasPaginadas($request, $paginacion)
    {
        return $this->entidad
            ->name($request->get('name'))
            ->where('estado', 'si')
            ->orderBy('id', 'desc')
            ->paginate($paginacion);
    }

    public function getEntidadesConEstosId($ids)
    {
        $array = array_unique($ids);

        return $this->entidad
            ->where('estado', 'si')
            ->whereIn('id', $array)
            ->get();
    }

    //setters
    public function setEntidadDato($Entidad, $request, $Propiedades)
    {

        if ($Entidad === null) {
            $Entidad = $this->getEntidad();
        }

        foreach ($Propiedades as $Propiedad) {
            if ($request->input($Propiedad) != null) {
                $Entidad->$Propiedad = $request->input($Propiedad);
            } elseif ($request->input($Propiedad) == '') {
                $Entidad->$Propiedad = trim($request->input($Propiedad));
            }
        }

        $Entidad->save();

        return $Entidad;
    }

    //setters recibe un objeto en lugar del reques
    public function setEntidadDatoObjeto($Entidad, $objeto, $Propiedades)
    {

        foreach ($Propiedades as $Propiedad) {
            $Entidad->$Propiedad = $objeto->$Propiedad;
        }

        $Entidad->save();

        return $Entidad;
    }

    public function setAtributoEspecifico($Entidad, $atributo, $valor)
    {

        if ($valor != '') {
            $Entidad->$atributo = trim($valor);
            $Entidad->save();

            return $Entidad;
        }
    }

    public function getDetalleAlAnular($EntidadAAnular)
    {
        return 'Anulación del movimiento ' . $EntidadAAnular->id . ' : ' . $EntidadAAnular->detalle;
    }
}
