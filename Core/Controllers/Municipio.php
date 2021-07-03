<?php namespace Controllers;

    class Municipio
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $municipio = new \Models\Municipio();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];
                
                if($solicitud == 'consultar_por_departamento')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id_departamento']);

                    if($parametrosOk)
                    {
                        $municipio->departamento = new \Models\Departamento($_GET['id_departamento']);
                        $respuesta = $municipio->consultarPorDepartamento();
                    }
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }
    

?>