<?php

    require_once "./models/modelView.php";

    class viewController extends modelView {

        /*-------------Controlador para obtener plantillas---------------*/
        public function obtain_template_controller(){
            return require_once "./views/template.php";
        }

        /*-------------Controlador para obtener vistas---------------*/
        public function obtain_view_controller(){
            if(isset($_GET['views'])){
                $route=explode("/", $_GET['views']);
                $response= modelView::obtain_view_model($route[0]);
            }else{
                $response="login";
            }
            return $response;
        }

        
    }