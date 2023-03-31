<?php
class ModeloProducto
{

    public $conexion;

    public function __construct()
    {
        $this->conexion = mysqli_connect('localhost', 'root', '', 'api-php');
        mysqli_set_charset($this->conexion, 'utf8');
    }

    public function getProductos($id = null)
    {
        $where = ($id == null) ? " " : " WHERE id ='$id'";
        $productos = [];
        $sql = "SELECT * FROM productos " . $where;
        $registrar = mysqli_query($this->conexion, $sql);

        while ($row = mysqli_fetch_array($registrar)) {
            array_push($productos, $row);
        }
        return $productos;
    }

    public function guadarProductos($nombre, $categoria, $descripcion, $valor)
    {
        $validaGuardar = $this->existeProductos($nombre, $categoria, $descripcion, $valor);
        $resula = ['Error', 'el producto a guardar ' . $nombre . ' existe '];
        if (count($validaGuardar) == 0) {
            $sql = "INSERT INTO productos (nombre,categoria,descripcion,valor) VALUE ('$nombre','$categoria','$descripcion','$valor')";
            mysqli_query($this->conexion, $sql);
            $resula = ['seccees', 'product save'];
        }
        return $resula;
    }

    public function actualizarProductos($id, $nombre, $categoria, $descripcion, $valor)
    {
        $existeActuliaza = $this->getProductos($id);
        $resula = ['Error', 'el producto a actualizar ' . $nombre . ' no existe '];
        if (count($existeActuliaza) > 0) {
            $validaActuliaza = $this->existeProductos($nombre, $categoria, $descripcion, $valor);
            $resula = ['Error', 'el producto a guardar ' . $nombre . ' existe '];
            if (count($validaActuliaza) == 0) {
                $sql = "UPDATE productos SET nombre='$nombre',categoria='$categoria',descripcion='$descripcion',valor='$valor' WHERE id='$id'";
                mysqli_query($this->conexion, $sql);
                $resula = ['seccees', 'product actualizado'];
            }
        }
        return $resula;
    }

    public function eliminarProductos($id)
    {
        $validarEliminar = $this->getProductos($id);
        $resula = ['Error', 'el producto a eliminado no existe con este Id ' . $id];
        if (count($validarEliminar) > 0) {
            $sql = "DELETE FROM  productos WHERE id='$id'";
            mysqli_query($this->conexion, $sql);
            $resula = ['seccees', 'product eliminado'];
        }
        return $resula;
    }

    public function existeProductos($nombre, $categoria, $descripcion, $valor)
    {
        $productos = [];
        $sql = "SELECT * FROM productos WHERE  nombre='$nombre' and categoria='$categoria'and descripcion='$descripcion' and valor='$valor'";
        $verif = mysqli_query($this->conexion, $sql);
        while ($row = mysqli_fetch_array($verif)) {
            array_push($productos, $row);
        }
        return $productos;
    }
}
