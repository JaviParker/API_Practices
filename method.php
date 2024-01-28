<?php
require "config/Conexion.php";

  //print_r($_SERVER['REQUEST_METHOD']);
  switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener el valor del parámetro 'nombre' de la URL
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        if (!empty($nombre)) {
            // Consulta SQL para seleccionar datos de la tabla filtrados por 'nombre'
            $sql = "SELECT nombre, apodo, tel, foto FROM maestro WHERE nombre = '$nombre'";
        } else {
            // Consulta SQL para seleccionar todos los datos de la tabla
            $sql = "SELECT nombre, apodo, tel, foto FROM maestro";
        }

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
            echo "No se encontraron registros" . (!empty($nombre) ? " para el nombre '$nombre'." : ".");
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
      
          $id_maestro = $datos['id_maestro'];
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
              $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_maestro = $id_maestro";
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
        // Obtener los datos tanto de la URL como del cuerpo de la solicitud
        $id_maestro = isset($_GET['id_maestro']) ? $_GET['id_maestro'] : null;
        $apodo = isset($_GET['apodo']) ? $_GET['apodo'] : null;
        $foto = isset($_GET['foto']) ? $_GET['foto'] : null;
        $tel = isset($_GET['tel']) ? $_GET['tel'] : null;

        // Si los datos no están en la URL, intentar obtenerlos del cuerpo de la solicitud JSON
        if ($id_maestro === null && $apodo === null && $foto === null && $tel === null) {
            $input = json_decode(file_get_contents("php://input"), true);
            $id_maestro = isset($input['id_maestro']) ? $input['id_maestro'] : null;
            $apodo = isset($input['apodo']) ? $input['apodo'] : null;
            $foto = isset($input['foto']) ? $input['foto'] : null;
            $tel = isset($input['tel']) ? $input['tel'] : null;
        }

        // Realizar la lógica para manejar las solicitudes PUT o PATCH aquí...
        if (!empty($id_maestro)) {
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
            $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_maestro = $id_maestro";

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
        // Obtener el contenido del cuerpo de la solicitud
        $json = file_get_contents('php://input');
        
        // Decodificar el JSON en un array asociativo
        $data = json_decode($json, true);
        
        // Verificar si la solicitud es DELETE
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Verificar si se proporciona el parámetro id_maestro en el JSON
            if (isset($data['id_maestro'])) {
                // Procesar solicitud DELETE
                $id_maestro = $data['id_maestro'];
                $sql = "DELETE FROM maestro WHERE id_maestro = $id_maestro";
        
                // Realizar la consulta DELETE
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
        
        // Cerrar la conexión a la base de datos
        $conexion->close();
      break;


     default:
       echo 'undefined request type!';
  }
?>