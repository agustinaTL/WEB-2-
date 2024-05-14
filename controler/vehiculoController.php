<?php
require_once 'model/vehiculoModel';
require_once 'view/view';
require_once 'helpers/authHelper.php';

class VehiculoController
{
    private $vehiculoModel;
    private $view;

    public function __construct()
    {
        //Creo las clases de los modelos y la vista
        $this->vehiculoModel = new VehiculoModel();
        $this->view = new View();
    }

    public function crearVehiculo()
    {

        // Ingreso los datos por método GET
        $idVehiculo = $_GET['id'];
        $marca = $_GET['marca'];
        $modelo = $_GET['modelo'];
        $anio = $_GET['anio'];

        // Verifico posibles errores de carga
        if (!isset($_GET['id']) || !isset($_GET['marca']) || !isset($_GET['modelo']) || !isset($_GET['anio'])) {
            $this->view->showError("Complete todos los campos");
            return;
        }

        // Verifico loggueo. Si no esta logueado mato todo
        AuthHelper::verificoLogueo();

        // Llamo a función crearNuevoVehiculo()
        $nuevoVehiculo = $this->vehiculoModel->crearNuevoVehiculo($idVehiculo, $marca, $modelo, $anio);

        if (!$nuevoVehiculo) {
            $this->view->showError("No se pudo agregar un nuevo vehículo a la DB");
            return;
        }

        // Muestro los datos del nuevo vehículo
        $this->view->showNuevoVehiculo($nuevoVehiculo);
    }
}
