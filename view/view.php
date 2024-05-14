<?php
class View
{
    public function showError($error)
    {
        $this->$error;
    }

    public function showNuevoVehiculo($nuevoVehiculo)
    {
        $this->$nuevoVehiculo;
    }

    public function showNuevoService($nuevoService)
    {
        $this->$nuevoService;
    }
}
