<?php
require_once 'model/serviceModel';
require_once 'view/view';

class ServiceController
{
    private $serviceModel;
    private $view;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->view = new View();
    }

    public function agregarNuevoService()
    {
        $id = $_GET['id'];
        $idVehiculo = $_GET['id_vehiculo'];
        $idMecanico = $_GET['id_mecanico'];
        $fecha = $_GET['fecha'];
        $kilometraje = $_GET['kilometraje'];

        // Verifico posibles errores de carga
        if (!isset($_GET['id']) || !isset($_GET['id_vehiculo']) || !isset($_GET['id_mecanico']) || !isset($_GET['fecha']) || !isset($_GET['kilometraje'])) {
            $this->view->showError("Complete todos los campos");
            return;
        }

        // Llamo a función nuevoService() y si no se agregó un nuevo id, da mensaje de error
        $nuevoService = $this->serviceModel->nuevoService($id, $idVehiculo, $idMecanico, $fecha, $kilometraje);

        if (!$nuevoService) {
            $this->view->showError("No se pudo agregar un nuevo service");
            return;
        }

        // La fecha del nuevo service debe ser la actual obtenida por la función date()
        $fechaActual = date("d-m-Y");
        if (!($fecha == $fechaActual)) {
            $this->view->showError("La fecha ingresada no es la actual");
            return;
        }

        // El kilometraje de un service debe ser mayor al de los services anteriores
        $ultimoKilometraje = $this->serviceModel->ultimoKilometraje($idVehiculo);

        if (!($kilometraje > $ultimoKilometraje)) {
            $this->view->showError("El último kilometraje del service del vehículo no es mayor a los services anteriores");
            return;
        }

        // Muestro los datos del nuevo service
        $this->view->showNuevoService($nuevoService);
    }
}
