<?php
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$nombre = $data['nombre'];
$precio = $data['precio'];
$unidades = $data['unidades'];
$modelo = $data['modelo'];
$marca = $data['marca'];
$detalles = $data['detalles'];
$imagen = $data['imagen'];

$link = new mysqli('localhost','root','','marketzone');
if($link->connect_errno){
    echo json_encode(["status"=>"error","message"=>"Error de conexión"]);
    exit;
}

$sql = "UPDATE productos SET nombre=?, precio=?, unidades=?, modelo=?, marca=?, detalles=?, imagen=? WHERE id=?";
$stmt = $link->prepare($sql);
$stmt->bind_param("sdissssi",$nombre,$precio,$unidades,$modelo,$marca,$detalles,$imagen,$id);

if($stmt->execute()){
    echo json_encode(["status"=>"success","message"=>"Producto actualizado correctamente"]);
} else {
    echo json_encode(["status"=>"error","message"=>"No se pudo actualizar el producto"]);
}

$stmt->close();
$link->close();
?>
