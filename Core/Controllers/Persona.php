<?php namespace Controllers;

    class Persona
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $persona = new \Models\Persona();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_por_id')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id']);
                    if($parametrosOk){
                        $respuesta = $persona->consultarPorId($_GET['id']);
                    }
                }

                if($solicitud == 'consultar_por_documento')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['numero_documento']);
                    if($parametrosOk){
                        $respuesta = $persona->consultarPorMumeroDocumento($_GET['numero_documento']);
                    }
                }

                if($solicitud == 'consultar_por_empresa')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['empresa']);
                    if($parametrosOk){
                        $respuesta = $persona->consultarPorEmpresa($_GET['empresa']);
                    }
                }
                
                if($solicitud == 'consultar_por_tipo')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['empresa', 'tipo']);
                    if($parametrosOk){
                        $respuesta = $persona->consultarPorTipo($_GET['empresa'], $_GET['tipo']);
                    }
                }

                if($solicitud == 'consultar_por_tipo_empleado')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['empresa']);
                    if($parametrosOk){
                        $respuesta = $persona->consultarPorTipoEmpleado($_GET['empresa']);
                    }
                }


                /*if($solicitud == 'consultar_todos')
                {
                    $respuesta = $persona->consultarTodos();
                }*/
            }
            
            \responder($respuesta, $parametrosOk);
        }

        public static function post(){
            $persona = new \Models\Persona();
            $respuesta = \Respuesta::obtenerDefault();
            $parametrosOk = true;
    
            if(isset($_POST['solicitud'])){
                $solicitud = $_POST['solicitud'];
    
                if($solicitud == 'crear'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['municipio', 'tipo', 'empresa', 'tipo_documento', 'numero_documento', 'nombres']);
                    
                    if($parametrosOk === true){
                        $persona->municipio = new \Models\Municipio($_POST['municipio']);
                        $persona->tipo = new \Models\TipoPersona($_POST['tipo']);
                        $persona->empresa = new \Models\Empresa($_POST['empresa']);
                        $persona->tipo_documento = new \Models\TipoDocumento($_POST['tipo_documento']);
                        $persona->numero_documento = $_POST['numero_documento'];
                        $persona->nombres = $_POST['nombres'];

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
        
                        $respuesta = $persona->crear();

                    }
                }
                
                if($solicitud == 'actualizar'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id', 'municipio', 'tipo', 'empresa', 
                        'tipo_documento', 'numero_documento', 'nombres']);
                    
                    if($parametrosOk === true){
                        $persona = new \Models\Persona($_POST['id']);
                        
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
    
                        if(isset($_POST['municipio']))
                        {
                            $persona->municipio = new \Models\Municipio($_POST['municipio']);
                        }

                        if(isset($_POST['habilitada'])){
                            $persona->habilitada = $_POST['habilitada'];
                        }
        
                        $respuesta = $persona->actualizar();

                    }
                }
                
                if($solicitud == 'eliminar'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true){
                        $persona->id = $_POST['id'];
                    }
    
                    $respuesta = $persona->eliminar();
                }
            }
    
            \responder($respuesta, $parametrosOk);
        }

    }
    
?>