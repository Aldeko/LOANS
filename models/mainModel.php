<?php

    if($ajaxRequest){

        require_once "../config/SERVER.php";

    }else{
        require_once "./config/SERVER.php";

    }

    class mainModel{

        /*----------------Funcion para conectar a la DB----------------*/
        protected static function connect(){
                $connection= new PDO(SGBD, USER, PASS);
                $connection->exec("SET CHARACTER SET utf8");
                return $connection;
            }

                /*----------------Funcion para ejecutar consultas simples a la DB----------------*/
        protected static function run_simple_query($query){
                $sql=self::connect()->prepare($query);
                $sql->execute();
                return $sql;
            }

                /*----------------Encriptar cadenas----------------*/
            public function encryption($string){
                $output=FALSE;
                $key=hash('sha256', SECRET_KEY);
                $iv=substr(hash('sha256', SECRET_IV), 0, 16);
                $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
                $output=base64_encode($output);
                return $output;
            }

            /*----------------Desencriptar cadenas----------------*/
            protected static function decryption($string){
                $key=hash('sha256', SECRET_KEY);
                $iv=substr(hash('sha256', SECRET_IV), 0, 16);
                $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
                return $output;
            }

            /*----------------Funcion para generar codigos aleatorios----------------*/
            protected static function generate_random_code($letter, $length, $number){
                    for($i=1; $i<=$length; $i++){
                                $randnom= rand(0,9);
                                $letter.=$randnom;
                    }
                    return $letter."-".$number;
            }
        }
        
    