<?php
class ServiceModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("");
    }

    // Creo función nuevoService()
    public function nuevoService($id, $idVehiculo, $idMecanico, $fecha, $kilometraje)
    {
        $query = $this->db->prepare("INSERT INTO services (id, id_vehiculo, id_mecanico, fecha, kilometraje) VALUES (?,?,?,?,?)");
        $query->execute([$id, $idVehiculo, $idMecanico, $fecha, $kilometraje]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    // Creo una función ultimoKilometraje donde paso por parámetro el $idVehiculo, para seleccionar
    // de la tabla services todos los kilometrajes del vehiculo ordenados por fecha en orden descendente, 
    // y establezco un límite de 1 (lo que me trae sólo el último kilometraje). 
    public function ultimoKilometraje($idVehiculo)
    {
        $query = $this->db->prepare("SELECT kilometraje FROM services WHERE id_vehiculo = ? ORDER BY fecha DESC, limit = 1");
        $query->execute([$idVehiculo]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
