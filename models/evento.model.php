<?php
class EventoModel{
    private $db;

    public function __construct(){
        $this->db = new PDO("...");
    }

    public function getEventoByNombre($nombre){
        $query = $this->db->prepare("SELECT * FROM Eventos WHERE nombre = ?");
        $query->execute([$nombre]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getEventoByFecha($fecha){
        $query = $this->db->prepare("SELECT * FROM Eventos WHERE fecha_evento = ?");
        $query->execute([$fecha]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function addNuevoEventoById($idEvento, $nombre, $precio, $fechaEvento, $entradasRestantes){
        $query = $this->db->prepare("INSERT INTO Eventos (id, nombre, precio, fecha_evento, entradas_restantes) VALUES (?,?,?,?,?)");
        $query->execute([$idEvento, $nombre, $precio, $fechaEvento, $entradasRestantes]);
        $id = $this->db->lastInsertId();
        return $id;
    }
}