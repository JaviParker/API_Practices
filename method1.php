<?php

require "config/Conexion.php";

//print_r($_SERVER['REQUEST_METHOD']);
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Consulta SQL para seleccionar datos de la tabla
        $sql = "SELECT nombre, apodo, tel, foto FROM maestro";

        $query = $conexion->query($sql);

        if ($query->num_rows > 0) {
            $data = array();
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            // Devolver los resultados en formato JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "No se encontraron registros en la tabla.";
        }

        $conexion->close();
        break;

    case 'POST':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir los datos del formulario HTML
            $nombre = $_POST['nombre'];
            $apodo = $_POST['apodo'];
            $tel = $_POST['tel'];
            $foto = $_POST['foto'];
        
            // Insertar los datos en la tabla
            $sql = "INSERT INTO maestro (nombre, apodo, tel, foto ) VALUES ('$nombre', '$apodo','$tel', '$foto')"; // Reemplaza con el nombre de tu tabla
        
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
        if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
            parse_str(file_get_contents("php://input"), $datos);
        
            $id_mae = $datos['id_mae'];
            $apodo = $datos['apodo'];
            $foto = $datos['foto'];
            $tel = $datos['tel'];
        
            if ($_SERVER['REQUEST_METHOD'] === 'PATCH') { // Método PATCH
                $actualizaciones = array();
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
                $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_mae = $id_mae";
            }
        
            if ($conexion->query($sql) === TRUE) {
                echo "Registro actualizado con éxito.";
            } else {
                echo "Error al actualizar registro: " . $conexion->error;
            }
        } else {
            echo "Método de solicitud no válido.";
        }
        
        $conexion->close();
        break;

    case 'PUT':
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
    
            // Obtiene los datos del cuerpo de la solicitud POST
            $datos = json_decode(file_get_contents("php://input"), true);
        
            // Verifica si los datos requeridos están presentes
            if (isset($datos['id_mae']) && isset($datos['apodo']) && isset($datos['foto']) && isset($datos['tel'])) {
        
                $id_mae = $datos['id_mae'];
                $apodo = $datos['apodo'];
                $foto = $datos['foto'];
                $tel = $datos['tel'];
        
                // Construye la consulta SQL según el método de solicitud
                if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                    $sql = "UPDATE maestro SET apodo = '$apodo', foto = '$foto', tel = '$tel' WHERE id_mae = $id_mae";
                } else { // Método PATCH
                    $actualizaciones = array();
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
                    $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_mae = $id_mae";
                }
        
                // Ejecuta la consulta SQL
                if ($conexion->query($sql) === TRUE) {
                    echo "Registro actualizado con éxito.";
                } else {
                    echo "Error al actualizar registro: " . $conexion->error;
                }
            } else {
                echo "Datos incompletos en la solicitud.";
            }
        } else {
            echo "Método de solicitud no válido.";
        }
        
        $conexion->close();
        break;

    case 'DELETE':
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Procesar solicitud DELETE
            $id_mae = $_GET['id_mae'];
            $sql = "DELETE FROM maestro WHERE id_mae = $id_mae";
        
            if ($conexion->query($sql) === TRUE) {
                echo "Registro eliminado con éxito.";
            } else {
                echo "Error al eliminar registro: " . $conexion->error;
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
