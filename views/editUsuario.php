<h1>Editar Usuario</h1>

<form action="index.php?action=editar&id=<?= e($usuario['id']) ?>" method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= e($usuario['nombre']) ?>" required><br><br>
    
    <label>Email:</label><br>
    <input type="email" name="email" value="<?= e($usuario['email']) ?>" required><br><br>
    
    <button type="submit">Actualizar Cambios</button>
    <a href="index.php">Cancelar</a>
</form>