<?php

    class modelView{

        /*--------- Modelo para obtener vistas-----------*/

        protected static function obtain_view_model($views){

            $whiteList=["client-list","client-new","client-search"
            ,"client-update","company","home","item-list","item-new"
            ,"item-search","item-update","reservation-list","reservation-new"
            ,"reservation-pending","reservation-search","reservation-update"
            ,"user-list","reservation-reservation","user-new","user-search","user-update"];
            if(in_array($views, $whiteList)) {
                if(is_file("./views/contents/".$views."-view.php")){
                    $content= "./views/contents/".$views."-view.php";

                }else{
                    $content="404";
                }

            }else if($views==="login" || $views==="index"){
                $content="login";
            }else{
                $content="404";
            }
            return $content;
        }
    }