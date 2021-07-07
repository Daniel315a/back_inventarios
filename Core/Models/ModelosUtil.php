<?php namespace Models;
    
    class ModelosUtil {
        /**
         * Obtiene el fragmento de código para validar si un valor
         * es null y enviarlo correctamente a la DB.
         */
        static function verificarNull($valor, $esNumero){
            $valorDB = "NULL";
            if($valor != null){
                if($esNumero){
                    $valorDB = "{$valor}";
                }else{
                    $valorDB = "'{$valor}'";
                }
            }

            return $valorDB;
        }

        /**
         * Obtiene el fragmento de código para insertar un valor booleano.
         */
        static function getBoolean($valor){
            return intval($valor);
        }

        /**
         * Obtiene la fecha en formato de mysql.
         */
        static function getFecha($string){
            return date('Y-m-d', strtotime($string));
        }
    }

?>