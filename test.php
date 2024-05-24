<?php
// Ejecutar la consulta nuevamente para asegurar que tenemos todos los datos
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()):
    // Agrega esta línea para imprimir el contenido de $row
    print_r($row);
?>
<div class="modal fade" id="editUserModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel<?php echo $row['id']; ?>">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí va el formulario para editar usuario -->
                <form action="edit_user.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="edit_username">Nombre de Usuario:</label>
                        <input type="text" class="form-control" id="edit_username<?php echo $row['id']; ?>" name="edit_username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email<?php echo $row['id']; ?>">Email:</label>
                        <input type="email" class="form-control" id="edit_email<?php echo $row['id']; ?>" name="edit_email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_role<?php echo $row['id']; ?>">Rol:</label>
                        <select class="form-control" id="edit_role<?php echo $row['id']; ?>" name="edit_role" required>
                            <option value="1" <?php if ($row['role_id'] == 1) echo 'selected'; ?>>Webmaster</option>
                            <option value="2" <?php if ($row['role_id'] == 2) echo 'selected'; ?>>Encargado</option>
                            <option value="3" <?php if ($row['role_id'] == 3) echo 'selected'; ?>>Empleado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
