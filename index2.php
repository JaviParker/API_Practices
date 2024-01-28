<!DOCTYPE html>
<html>
<head>
    <title>API de Ejemplo (GET, POST, PUT, DELETE)</title>
    <script src="min.js"></script>

</head>
<body>
<h1>Eliminar Registro por ID</h1>
    
    <form id="deleteForm">
        <label for="id_mae">ID del Registro a Eliminar:</label>
        <input type="text" id="id_mae" name="id_mae" required>
        <button type="button" id="deleteButton">Eliminar</button>
    </form>

    <div id="response"></div>

    <script>
        // Agregar un evento al botón para enviar la solicitud DELETE
        document.getElementById('deleteButton').addEventListener('click', function () {
            var id_mae = document.getElementById('id_mae').value;

            fetch('method.php?id_mae=' + id_mae, {
                method: 'DELETE'
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                document.getElementById('response').textContent = data;
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        });
    </script>
    
</body>
</html>
