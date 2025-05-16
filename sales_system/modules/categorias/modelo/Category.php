
<?php
// Modelo simple con solo datos
class Category {
    public $id;
    public $nombre;

    public function __construct($id = null, $nombre = null) {
        $this->id = $id;
        $this->nombre = $nombre;
    }
}
?>
