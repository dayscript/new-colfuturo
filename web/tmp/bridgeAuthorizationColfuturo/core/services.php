<?php

require './FuncionesComunicacion.php';
/*
  listar todos los posts o solo uno
 */
// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $bodyRequest = file_get_contents("php://input");
        if (!empty($bodyRequest) && !is_null($bodyRequest)) {
            $dataRequest = json_decode($bodyRequest, true);
            if (!empty($dataRequest["data"]) && !is_null($dataRequest["data"])) {
                $dataArray = $dataRequest["data"];
                if (!empty($dataArray["identificacion"]) && !is_null($dataArray["identificacion"])) {
                    $identificador = $dataArray["identificacion"];
                    $datosModificar = $dataArray["data"];
                    if (!empty($datosModificar) && !is_null($datosModificar)) {
                        $funciones = new FuncionesComunicacion();
                        $provider = $funciones->obtenerProvider();
                        $otrosAtributos = false;
                        $arrayOtrosAtributos = [];
                        $cambioRoles = false;
                        $rolesAttributos = "";
                        foreach ($datosModificar as $key_array => $value) {
                            if (strcmp($key_array, Parametros::$GROUPS_NAME) == 0) {
                                //funciones para grupos
                                $cambioRoles = true;
                                $rolesAttributos = $value;
                            } else {
                                $otrosAtributos = true;
                                array_push($arrayOtrosAtributos, ['Name' => $key_array, 'Value' => $value]);
                            }
                        }
                        if ($otrosAtributos) {
                            $funciones->cambiarAtributosCognito($provider, $identificador, $arrayOtrosAtributos);
                        }
                        if ($cambioRoles) {
                            //Consulto los roles de cognito
                            $grupos = $funciones->consultarRolesCognitoUsuario($provider, $identificador);

                            $gruposReguistrados = [];
                            //Agrego los nombres de los roles registrados en cognito en un array temporal
                            if ($grupos != null) {
                                foreach ($grupos as $grupo) {
                                    $gruposReguistrados[] = $grupo["GroupName"];
                                }
                            }
                            $roles_Array = explode(",", $rolesAttributos);
                            // Recore los roles enviados si no esta en los que se encuentran en cognito lo agrega
                            foreach ($roles_Array as $rol) {
                                if (!empty($rol) && !is_null($rol)) {
                                    $rol = trim($rol);
                                    $esta = false;
                                    foreach ($gruposReguistrados as $grupoCognito) {
                                        if ($grupoCognito == $rol) {
                                            $esta = true;
                                        }
                                    }
                                    if (!$esta) {
                                        $funciones->agregarRolCognitoUsuario($provider, $rol, $identificador);
                                    }
                                }
                            }

                            // Recore los roles que se encuentran en cognito si no estan en los enviados los elimina
                            foreach ($gruposReguistrados as $grupoCognito) {
                                $esta = false;
                                if (!empty($grupoCognito) && !is_null($grupoCognito)) {
                                    foreach ($roles_Array as $rol) {
                                        $rol = trim($rol);
                                        if ($grupoCognito == $rol) {
                                            $esta = true;
                                        }
                                    }
                                    if (!$esta) {
                                        // eliminar de cognito
                                        $funciones->eliminarRolCognitoUsuario($provider, $grupoCognito, $identificador);
                                    }
                                }
                            }
                        }
                        echo "{'resultado':'Usuario actualizado'}";
                        header("HTTP/1.1 200 OK");
                        exit();
                    } else {
                        echo "{'resultado':'sin datos para modificar'}";
                        header("HTTP/1.1 400 Bad Request");
                    }
                } else {
                    echo "{'resultado':'no se especifica usuario para actualizar.'}";
                    header("HTTP/1.1 400 Bad Request");
                }
            } else {
                echo "{'resultado':'no se puede leer la informacion.'}";
                header("HTTP/1.1 400 Bad Request");
            }
        } else {
            echo "{'resultado':'sin datos.'}";
            header("HTTP/1.1 400 Bad Request");
        }
    } catch (Exception $ex) {
        header("HTTP/1.0 500 Internal Server Error");
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $identificador = "";
    $identificador = $_GET["identificacion"];
    if ($identificador != "") {
        try {
            $funciones = new FuncionesComunicacion();
            $provider = $funciones->obtenerProvider();
            $grupos = $funciones->consultarRolesCognitoUsuario($provider, $identificador);

            $gruposReguistrados = [];
            $roles = "";
            //Agrego los nombres de los roles registrados en cognito en un array temporal
            if ($grupos != null) {
                foreach ($grupos as $grupo) {
                    if ($roles != "") {
                        $roles = $roles . "," . $grupo["GroupName"];
                    } else {
                        $roles = $roles . $grupo["GroupName"];
                    }
                }
            }
            echo "{ 'roles' : \"" . $roles . "\" }";
            header("HTTP/1.1 200 OK");
            exit();
        } catch (Exception $ex) {
            header("HTTP/1.0 500 Internal Server Error");
            exit();
        }
    }else {
            echo "{'resultado':'sin identificacion.'}";
            header("HTTP/1.1 400 Bad Request");
        }
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
exit();

