<?php
require_once 'models/evento.model.php';
require_once 'view/evento.view.php';

require_once 'AuthHelper.php';

class EventoController{
    private $eventoModel;

    private $view;

    public function __construct(){
        $this->eventoModel = new EventoModel();
        $this->view = new EventoView();
    }

    public function addEvento(){
        //Verificar que el usuario sea administrador  
        
        if(AuthHelper::verifyAdmin()){
            $this->view->showError("El usuario es administrador");
        } else{
            $this->view->showError("El usuario no es administrador");
        }

        //Verificar e informar posibles errores de entrada del usuario

        if(empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['precio']) 
        || empty($_POST['fecha_evento']) || empty($_POST['entradas_restantes'])){
            $this->view->showError("Completar todos los campos", 400);
            return;
        }
        
        // Guardo los datos ingresados en variables

        // la expresión $data = new stdClass();
        // es una forma sencilla de crear un objeto con propiedades dinámicas
        // para interactuar con una API.

        $data = new stdClass();
        $data->idEvento = $_POST['id'];
        $data->nombre = $_POST['nombre'];
        $data->precio = intval($_POST['precio']);
        $data->fechaEvento = $_POST['fecha_evento'];
        $data->entradasRestantes = $_POST['entradas_restantes'];

        // Verificar que el precio y las entradas restantes sean valores mayores a 0

        if($data->precio <= 0 || $data->entradasRestantes <= 0){
            $this->view->showError("Los valores de precio y entradas deben ser mayores a cero", 400);
            return;
        }

        // Controlar que no exista un evento con el mismo nombre

        $eventoNombre = $this->eventoModel->getEventoByNombre($data->nombre);

        if($eventoNombre){
            $this->view->showError("Ya existe un evento con este nombre", 400);
            return;
        }

        // Controlar que no exista un evento con la misma fecha

        $eventoFecha = $this->eventoModel->getEventoByFecha($data->fechaEvento);

        if($eventoFecha){
            $this->view->showError("Ya existe un evento con la misma fecha");
            return;
        }
        
        $nuevoEvento = $this->eventoModel->addNuevoEventoById($data->idEvento, $data->nombre, $data->precio, $data->fechaEvento, $data->entradasRestantes);

        $this->view->showEvento($nuevoEvento);
    }
}