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

            /*----------------Funcion para limpiar cadenas----------------*/
            protected static function clean_chain($chain){
                    $chain=trim($chain);
                    $chain=stripcslashes($chain);
                    $chain=str_ireplace("<script>", "", $chain);
                    $chain=str_ireplace("</script>", "", $chain);
                    $chain=str_ireplace("<script> src", "", $chain);
                    $chain=str_ireplace("<script> type=", "", $chain);
                    $chain=str_ireplace("SELECT*FROM", "", $chain);
                    $chain=str_ireplace("DELETE FROM", "", $chain);
                    $chain=str_ireplace("INSERT INTO", "", $chain);
                    $chain=str_ireplace("DROP TABLE", "", $chain);
                    $chain=str_ireplace("DROP DATABASE", "", $chain);
                    $chain=str_ireplace("TRUNCATE TABLE", "", $chain);
                    $chain=str_ireplace("SHOW TABLES", "", $chain);
                    $chain=str_ireplace("SHOW DATABASES", "", $chain);
                    $chain=str_ireplace("<?php", "", $chain);
                    $chain=str_ireplace("?>", "", $chain);
                    $chain=str_ireplace("--", "", $chain);
                    $chain=str_ireplace(">", "", $chain);
                    $chain=str_ireplace("<", "", $chain);
                    $chain=str_ireplace("[", "", $chain);
                    $chain=str_ireplace("]", "", $chain);
                    $chain=str_ireplace("^", "", $chain);
                    $chain=str_ireplace("==", "", $chain);
                    $chain=str_ireplace(";", "", $chain);
                    $chain=str_ireplace("::", "", $chain);
                    $chain=stripcslashes($chain);
                    $chain=trim($chain);

                    return $chain;
            }

            /*----------------Funcion para verificar datos----------------*/
            protected static function verify_data($filter, $chain){
                if(preg_match("/^".$filter."$/", $chain)){
                    return false;
                }else{
                    return true;
                }
            }

            /*----------------Funcion para verificar datos----------------*/
            protected static function verify_dates($date){
                $values=explode('-', $date);
                $month=$values[1];
                $day=$values[2];
                $year=$values[0];

                if(count($values)===3 && checkdate($month, $day, $year) ){
                        return false;
                }else{
                        return true;
                }
            }

            /*----------------Funcion paginador de tablas----------------*/
            protected static function paginator_tables($page, $NumPages, $url, $buttons){
                $table='<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

                if($page===1){
                    $table.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-left"></i></a></li>';
                }else{
                    $table.='
                    <li class="page-item"><a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a></li>
                    <li class="page-item"><a class="page-link" href="'.$url.($page-1).'/">Anterior</a></li>';
                }

                $ci=0;
                for($i=$page; $i<=$NumPages; $i++){
                    if($ci>=$buttons){
                        break;
                    }
                    if($page===$i){
                        $table.='<li class="page-item"><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
                    }else{
                        $table.='<li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';

                    }

                    $ci++;
                }

                if($page===$NumPages){
                    $table.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-right"></i></a></li>';
                }else{
                    $table.='
                    <li class="page-item"><a class="page-link" href="'.$url.($page+1).'/"><i class="fas fa-angle-double-right"></i></a></li>
                    <li class="page-item"><a class="page-link" href="'.$url.$NumPages.'/">Anterior</a></li>';
                }

                $table.='</ul></nav>';
                return $table;
            }


        }
        
    