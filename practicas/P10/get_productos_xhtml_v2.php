<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<?php
    $data = array();

	if(isset($_GET['tope'])) {
		$tope = $_GET['tope'];
	} else {
        die('Parámetro "tope" no detectado...');
    }

	if (!empty($tope)) {
		@$link = new mysqli('localhost', 'root', '', 'marketzone');

		if ($link->connect_errno) {
			die('Falló la conexión: '.$link->connect_error.'<br/>');
		}

		if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= $tope") ) {
			$row = $result->fetch_all(MYSQLI_ASSOC);

			foreach($row as $num => $registro) {
				foreach($registro as $key => $value) {
					$data[$num][$key] = utf8_encode($value);
				}
			}
			$result->free();
		}

		$link->close();
	}
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Productos con tope</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<h3>PRODUCTOS</h3>
	<br/>

	<?php if( isset($row) ) : ?>
		<table class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nombre</th>
					<th scope="col">Marca</th>
					<th scope="col">Modelo</th>
					<th scope="col">Precio</th>
					<th scope="col">Unidades</th>
					<th scope="col">Detalles</th>
					<th scope="col">Imagen</th>
					<th scope="col">Modificar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($row as $value) : ?>
				<tr>
					<th scope="row"><?= $value['id'] ?></th>
					<td><?= $value['nombre'] ?></td>
					<td><?= $value['marca'] ?></td>
					<td><?= $value['modelo'] ?></td>
					<td><?= $value['precio'] ?></td>
					<td><?= $value['unidades'] ?></td>
					<td><?= $value['detalles'] ?></td>
					<td><img src="<?= $value['imagen'] ?>" width="60"></td>
					<td>
						<a href="formulario_productos_v2.php?
							id=<?= $value['id'] ?>
							&nombre=<?= urlencode($value['nombre']) ?>
							&marca=<?= urlencode($value['marca']) ?>
							&modelo=<?= urlencode($value['modelo']) ?>
							&precio=<?= urlencode($value['precio']) ?>
							&detalles=<?= urlencode($value['detalles']) ?>
							&unidades=<?= urlencode($value['unidades']) ?>
							&imagen=<?= urlencode($value['imagen']) ?>"
							class="btn btn-warning btn-sm">Modificar</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<script>alert('No se encontraron productos');</script>
	<?php endif; ?>
</body>
</html>

