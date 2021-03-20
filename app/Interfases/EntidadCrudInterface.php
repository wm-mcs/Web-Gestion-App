<?php
namespace App\Interfases;

use Illuminate\Http\Request;

interface EntidadCrudInterface
{

    /**
     * El mangaer para validar la data de que viene de la vista.
     */
    public function getManager(Request $Request);

    /**
     * Las propiedades que se usan para editar o crear.
     */
    public function getPropiedades();

    /**
     * Método para obtener la vista.
     */
    public function getIndex(Request $Request);

    /**
     * Método para el get en json de las entidades.
     */
    public function getEntidades(Request $Request);

    /**
     * Método para el post de crear entidad.
     */
    public function crearEntidad(Request $Request);

    /**
     * Método para el post de editar entidad.
     */
    public function editarEntidad(Request $Request);

    /**
     * Borra los cache luego de editar o crear.
     */
    public function cleanCache($customCache);
}
