<?php
class Category {
    public $id;
    public $nombre;
    public $descripcion;
    public $fecha_creacion;
    public $estado;

    public function __construct($id = null, $nombre = '', $descripcion = '', $fecha_creacion = '', $estado = '') {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fecha_creacion = $fecha_creacion;
        $this->estado = $estado;
    }
}
