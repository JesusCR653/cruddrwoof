<?php

class MainModel {
    private $db;

    public function __construct() {
        require_once __DIR__ . 'views/conexion.php';
        global $conexion; 
        $this->db = $conexion;
    }

    public function guardarCita($id_mascota, $fecha, $hora, $motivo) {
        $sql = "INSERT INTO citas_JCR (id_mascota, fecha, hora, motivo) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_mascota, $fecha, $hora, $motivo]);
    }

    public function editarCita($id, $fecha, $hora, $motivo) {
        $sql = "UPDATE citas_JCR SET fecha = ?, hora = ?, motivo = ? WHERE id_cita = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fecha, $hora, $motivo, $id]);
    }

    public function eliminarCita($id) {
        $sql = "DELETE FROM citas_JCR WHERE id_cita = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function guardarMascota($nombre, $especie, $raza, $edad, $id_dueno) {
        $sql = "INSERT INTO mascotas_JCR (nombre, especie, raza, edad, id_dueno) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $especie, $raza, $edad, $id_dueno]);
    }

    public function editarMascota($id, $nombre, $especie, $raza, $edad) {
        $sql = "UPDATE mascotas_JCR SET nombre = ?, especie = ?, raza = ?, edad = ? WHERE id_mascota = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $especie, $raza, $edad, $id]);
    }

    public function eliminarMascota($id) {
        $sql = "DELETE FROM mascotas_JCR WHERE id_mascota = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function obtenerInfoQR($id_mascota) {
        $sql = "SELECT m.*, u.nombre as dueno, u.direccion_residencial 
                FROM mascotas_JCR m 
                INNER JOIN usuarios_JCR u ON m.id_dueno = u.id_usuario 
                WHERE m.id_mascota = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_mascota]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarComentario($id_usuario, $comentario, $fecha) {
        $sql = "INSERT INTO comentarios_JCR (id_usuario, comentario, fecha) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_usuario, $comentario, $fecha]);
    }

    public function eliminarComentario($id) {
        $sql = "DELETE FROM comentarios_JCR WHERE id_comentario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function guardarUsuario($nombre, $correo, $password) {
        $sql = "INSERT INTO usuarios_JCR (nombre, correo, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $correo, $password]);
    }

    public function actualizarUsuario($id, $nombre, $correo) {
        $sql = "UPDATE usuarios_JCR SET nombre = ?, correo = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $correo, $id]);
    }

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios_JCR WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>