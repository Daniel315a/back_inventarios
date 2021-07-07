<?php namespace Controllers;

    class Prestamo
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $prestamo = new \Models\Prestamo();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_por_empresa')
                {
                    $idEmpresa = 0;

                    if(isset($_GET['empresa'])){
                        $idEmpresa = $_GET['empresa'];
                    }

                    $respuesta = $prestamo->consultarPorEmpresa($idEmpresa);
                }
            }
            
            \responder($respuesta, $parametrosOk);
        }

        public static function post(){
            $prestamo = new \Models\Prestamo();
            $respuesta = \Respuesta::obtenerDefault();
            $parametrosOk = true;
    
            if(isset($_POST['solicitud'])){
                $solicitud = $_POST['solicitud'];
    
                if($solicitud == 'crear'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['distribuidor', 'fecha_prestamo']);
                    
                    if($parametrosOk === true){
                        $prestamo->distribuidor = new \Models\Persona($_POST['distribuidor']);
                        $prestamo->fecha_prestamo = $_POST["fecha_prestamo"];

                        if(isset($_POST['empleado'])){
                            $prestamo->empleado = new \Models\Persona($_POST['empleado']);
                        }
    
                        if(isset($_POST['fecha_devolucion'])){
                            $prestamo->empleado = $_POST["fecha_devolucion"];
                        }
        
                        $respuesta = $prestamo->crear();

                    }
                }
                /*
                if($solicitud == 'actualizar'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id', 'municipio', 'tipo', 'empresa', 
                        'tipo_documento', 'numero_documento', 'nombres']);
                    
                    if($parametrosOk === true){
                        $persona->id = $_POST['id'];
                        $persona->municipio = new \Models\Municipio($_POST['municipio']);
                        $persona->tipo = new \Models\TipoPersona($_POST['tipo']);
                        $persona->empresa = new \Models\Empresa($_POST['empresa']);
                        $persona->tipo_documento = new \Models\TipoDocumento($_POST['tipo_documento']);

                        if(isset($_POST['numero_documento'])){
                            $persona->numero_documento = $_POST['numero_documento'];
                        }
    
                        if(isset($_POST['nombres'])){
                            $persona->nombres = $_POST['nombres'];
                        }
    

                        if(isset($_POST['apellidos'])){
                            $persona->apellidos = $_POST['apellidos'];
                        }
    
                        if(isset($_POST['razon_social'])){
                            $persona->razon_social = $_POST['razon_social'];
                        }
    
                        if(isset($_POST['direccion'])){
                            $persona->direccion = $_POST['direccion'];
                        }
    
                        if(isset($_POST['telefono'])){
                            $persona->telefono = $_POST['telefono'];
                        }
    
                        if(isset($_POST['email'])){
                            $persona->email = $_POST['email'];
                        }
    
                        if(isset($_POST['habilitada'])){
                            $persona->habilitada = $_POST['habilitada'];
                        }
        
                        $respuesta = $persona->actualizar();

                    }
                }
                */
                if($solicitud == 'eliminar'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true){
                        $prestamo->consultarPorId($_POST['id']);

                        if($prestamo->fecha_devolucion == null){
                            $respuesta = $prestamo->eliminar();
                        }else{
                            $respuesta = \Respuesta::obtener(false, "No puede eliminar un prestamo entregado", null);
                        }

                        
                    }
    
                }
            }
    
            \responder($respuesta, $parametrosOk);
        }

    }
    
?>