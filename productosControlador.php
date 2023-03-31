<?php
header('Content-Type: application/json; charset=UTF-8');
require 'modeloProducto.php';

$productosModelo = new ModeloProducto();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $respuesta = $productosModelo->getProductos();
        echo json_encode($respuesta);
        break;

    case 'POST':
        $_POST = json_decode(file_get_contents('php://input', true));

        if (isset($_POST->nombre) && is_null($_POST->nombre) && empty(trim($_POST->nombre)) && strlen($_POST->nombre)>15) {
            $respuesta = ['error', 'El nombre de producto no debe estar vacia y no se debe superior a 15 caracteres'];
        } else if (!isset($_POST->descripcion) && is_null($_POST->descripcion) && empty(trim($_POST->descripcion)) && strlen($_POST->descripcion)>80) {
            $respuesta = ['error', '<La descripcion de producto no debe estar vacia y no se debe superior a 80 caracteres'];
        } else if (!isset($_POST->categoria) && is_null($_POST->categoria) && empty(trim($_POST->categoria)) && strlen($_POST->categoria)>15) {
            $respuesta = ['error', 'La categoria de producto no debe estar vacia y no se debe superior a 15 caracteres'];
        }
        if (!isset($_POST->valor) && is_null($_POST->valor) && empty(trim($_POST->valor)) && !is_numeric($_POST->valor)) {
            $respuesta = ['error', 'El valor de producto no debe estar vacio y debe tener solo numeros'];
        } else {
            var_dump($_POST);
           // $respuesta = $productosModelo->guadarProductos($_POST->nombre, $_POST->categoria, $_POST->descripcion, $_POST->valor);
        }
        echo json_encode($respuesta);

        break;
    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input', true));

        if (!isset($_PUT->id) && is_null($_PUT->id) && empty(trim($_PUT->id))) {
        
            $respuesta = ['error', 'El id de producto no debe estar vacia y no se debe superior a 15 caracteres'];
        } else if (!isset($_PUT->nombre) && is_null($_PUT->nombre) && empty(trim($_PUT->nombre))&& strlen($_PUT->nombre)>15) {
            $respuesta = ['error', 'El nombre de producto no debe estar vacia y no se debe superior a 15 caracteres'];
        } else if (!isset($_PUT->descripcion) && is_null($_PUT->descripcion) && empty(trim($_PUT->descripcion)) && strlen($_PUT->descripcion)>80) {
            $respuesta = ['error', '<La descripcion de producto no debe estar vacia y no se debe superior a 80 caracteres'];
        } else if (!isset($_PUT->categoria) && is_null($_PUT->categoria) && empty(trim($_PUT->categoria))&& strlen($_PUT->categoria)>15) {
            $respuesta = ['error', 'La categoria de producto no debe estar vacia'];
        }
        if (!isset($_PUT->valor) && is_null($_PUT->valor) && empty(trim($_PUT->valor)) && number_format($_PUT->valor)) {
            $respuesta = ['error', 'El valor de producto no debe estar vacio'];
        } else {
           // $respuesta = $productosModelo->actualizarProductos($_PUT->id, $_PUT->nombre, $_PUT->categoria, $_PUT->descripcion, $_PUT->valor);
        }
        echo json_encode($respuesta);
        break;
    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input', true));
        if (!isset($_DELETE->id) && is_null($_DELETE->id) && empty(trim($_DELETE->id))) {
            $respuesta = ['error', 'El id de producto no debe estar vacia'];
        } else {
            $respuesta = $productosModelo->eliminarProductos($_DELETE->id);
        }
        echo json_encode($respuesta);

        break;
}
