<?php
date_default_timezone_set('America/Los_Angeles');
require './aws/aws-autoloader.php';
require './Parametros.php';

/**
 * Clase encargada de realizar la conexion y manejador de metodos para comunicacion modificacion y uso del SDK de Amazon
 *
 * @author jadkson.moreno
 */
class FuncionesComunicacion {

    public function obtenerProvider() {
        $options = [
            'version' => Parametros::$VERSION,
            'region' => Parametros::$REGION,
            'credentials' => [
                'key' => Parametros::$KEY_ID,
                'secret' => Parametros::$SECRET_CLIENT,
            ]
        ];
        $sdk = new Aws\Sdk($options);
        $provider = $sdk->createCognitoIdentityProvider();
        return $provider;
    }

    public function cambiarAtributosCognito($provider, $identificador, $userAttributes) {
        $result = $provider->adminUpdateUserAttributes([
            'UserAttributes' => $userAttributes
            ,
            'UserPoolId' => Parametros::$USER_POOL_ID,
            'Username' => $identificador,
        ]);
        return $result;
    }

    public function consultarRolesCognitoUsuario($provider, $identificador) {
        $result = $provider->adminListGroupsForUser([
            'UserPoolId' => Parametros::$USER_POOL_ID,
            'Username' => $identificador,
        ]);
        return $result["Groups"];
    }

    public function agregarRolCognitoUsuario($provider, $groupName, $identificador) {
        $result = $provider->adminAddUserToGroup([
            'GroupName' => $groupName,
            'UserPoolId' => Parametros::$USER_POOL_ID,
            'Username' => $identificador,
        ]);
        return $result;
    }

    public function eliminarRolCognitoUsuario($provider, $groupName, $identificador) {
        $result = $provider->AdminRemoveUserFromGroup([
            'GroupName' => $groupName,
            'UserPoolId' => Parametros::$USER_POOL_ID,
            'Username' => $identificador,
        ]);
        return $result;
    }

}
