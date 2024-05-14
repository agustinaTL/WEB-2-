<?php
class VehiculoModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("");
    }

    // Creo función crearNuevoVehiculo()
    public function crearNuevoVehiculo($idVehiculo, $marca, $modelo, $anio)
    {
        $query = $this->db->prepare("INSERT INTO vehiculo (id_vehiculo, marca, modelo, anio) VALUES (?, ?, ?, ?)");
        $query->execute([$idVehiculo, $marca, $modelo, $anio]);
        $id = $this->db->lastInsertId();
        return $id;
    }
}
