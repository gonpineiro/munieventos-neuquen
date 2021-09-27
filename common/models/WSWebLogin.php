<?php

namespace common\models;

use Exception;

class WSWebLogin
{
    protected $url = 'https://weblogin.muninqn.gov.ar/api/getUserByToken2/';
    public $permiso;

    public $nombreApellido;
    public $email;
    public $pais;
    public $dni;
    public $password;
    public $error = null;

    protected $token;
    protected $appId;

    public function __construct($token, $appId)
    {
        $this->token = $token;
        $this->appId = $appId;
        $this->login();
    }


    protected function login()
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->url . $this->token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $usuario = json_decode($response, true);
            $this->nombreApellido = explode(',', $usuario['datosPersonales']['razonSocial']);
            $this->email = $usuario['userName'];
            $this->pais = $usuario['datosPersonales']['domicilioReal']['codigoPostal']['pais'];
            $this->dni = $usuario['datosPersonales']['documento'];
            $this->password = $usuario['userPlainTextPass'];

            foreach ($usuario['apps'] as $apps) {
                if ($apps['id'] == 999 && $apps['userProfiles']) {
                    $this->permiso = $apps['userProfiles'];
                }
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }
}
