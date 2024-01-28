<?php
require "config/Conexion.php";

  //print_r($_SERVER['REQUEST_METHOD']);
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        if (!empty($nombre)) {
            $sql = "SELECT id_mae, nombre, apodo, tel, foto FROM maestro WHERE nombre = '$nombre'";
        } else {
            $sql = "SELECT id_mae, nombre, apodo, tel, foto FROM maestro";
        }

        $query = $conexion->query($sql);

        if ($query->num_rows > 0) {
            $data = array();
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "No se encontraron registros" . (!empty($nombre) ? " para el nombre '$nombre'." : ".");
        }

        $conexion->close();
        break;

    case 'POST':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $apodo = $_POST['apodo'];
            $tel = $_POST['tel'];
            $foto = $_POST['foto'];

            $sql = "INSERT INTO maestro (nombre, apodo, tel, foto ) VALUES ('$nombre', '$apodo','$tel', '$foto')";

            if ($conexion->query($sql) === TRUE) {
                echo "Datos insertados con éxito.";
            } else {
                echo "Error al insertar datos: " . $conexion->error;
            }
        } else {
            echo "Esta API solo admite solicitudes POST.";
        }

        $conexion->close();
        break;

        case 'PATCH':
            // Obtener los datos del cuerpo de la solicitud JSON
            $input = json_decode(file_get_contents("php://input"), true);
    
            // Obtener el ID del maestro desde la URL o el cuerpo de la solicitud
            $id_maestro = isset($_GET['id_mae']) ? $_GET['id_mae'] : (isset($input['id_mae']) ? $input['id_mae'] : null);
            echo $id_maestro;
            // Obtener otros datos del cuerpo de la solicitud
            $nombre = isset($input['nombre']) ? $input['nombre'] : null;
            $apodo = isset($input['apodo']) ? $input['apodo'] : null;
            $foto = isset($input['foto']) ? $input['foto'] : null;
            $tel = isset($input['tel']) ? $input['tel'] : null;
    
            // Realizar la lógica para manejar las solicitudes PUT aquí...
            if (!empty($id_maestro)) {
                $actualizaciones = array();
                if (!empty($nombre)) {
                    $actualizaciones[] = "nombre = '$nombre'";
                }
                if (!empty($apodo)) {
                    $actualizaciones[] = "apodo = '$apodo'";
                }
                if (!empty($foto)) {
                    $actualizaciones[] = "foto = '$foto'";
                }
                if (!empty($tel)) {
                    $actualizaciones[] = "tel = '$tel'";
                }
    
                $actualizaciones_str = implode(', ', $actualizaciones);
                $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_mae = $id_maestro";
    
                if ($conexion->query($sql) === TRUE) {
                    echo "Registro actualizado con éxito.";
                } else {
                    echo "Error al actualizar registro: " . $conexion->error;
                }
            } else {
                echo "Faltan datos obligatorios en la solicitud.";
            }
    
            $conexion->close();
            break;

        case 'PUT':
            // Obtener los datos del cuerpo de la solicitud JSON
            $input = json_decode(file_get_contents("php://input"), true);
    
            // Obtener el ID del maestro desde la URL o el cuerpo de la solicitud
            $id_maestro = isset($_GET['id_mae']) ? $_GET['id_mae'] : (isset($input['id_mae']) ? $input['id_mae'] : null);
            echo $id_maestro;
            // Obtener otros datos del cuerpo de la solicitud
            $nombre = isset($input['nombre']) ? $input['nombre'] : null;
            $apodo = isset($input['apodo']) ? $input['apodo'] : null;
            $foto = isset($input['foto']) ? $input['foto'] : null;
            $tel = isset($input['tel']) ? $input['tel'] : null;
    
            // Realizar la lógica para manejar las solicitudes PUT aquí...
            if (!empty($id_maestro)) {
                $actualizaciones = array();
                if (!empty($nombre)) {
                    $actualizaciones[] = "nombre = '$nombre'";
                }
                if (!empty($apodo)) {
                    $actualizaciones[] = "apodo = '$apodo'";
                }
                if (!empty($foto)) {
                    $actualizaciones[] = "foto = '$foto'";
                }
                if (!empty($tel)) {
                    $actualizaciones[] = "tel = '$tel'";
                }
    
                $actualizaciones_str = implode(', ', $actualizaciones);
                $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_mae = $id_maestro";
    
                if ($conexion->query($sql) === TRUE) {
                    echo "Registro actualizado con éxito.";
                } else {
                    echo "Error al actualizar registro: " . $conexion->error;
                }
            } else {
                echo "Faltan datos obligatorios en la solicitud.";
            }
    
            $conexion->close();
            break;

    case 'DELETE':
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if (isset($data['id_maestro'])) {
                $id_maestro = $data['id_maestro'];
                $sql = "DELETE FROM maestro WHERE id_mae = $id_maestro";

                if ($conexion->query($sql) === TRUE) {
                    echo "Registro eliminado con éxito.";
                } else {
                    echo "Error al eliminar registro: " . $conexion->error;
                }
            } else {
                echo "El parámetro id_maestro no se proporcionó en el JSON.";
            }
        } else {
            echo "Método de solicitud no válido.";
        }

        $conexion->close();
        break;

    default:
        echo 'undefined request type!';
}
?>