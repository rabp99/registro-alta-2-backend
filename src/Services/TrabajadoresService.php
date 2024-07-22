<?php
declare(strict_types=1);

namespace App\Services;
use Cake\Http\Client;

class TrabajadoresService
{   
    private $http;
    private $url;
    
    public function __construct() {
        $this->http = new Client();
        $this->url = 'http://172.27.58.61:8080/api.sgper/public/apifree/trabajador/getData1';
    }
    
    public function getAll() {
        $response = $this->http->post($this->url, [
            'texto' => ''
        ]);
        
        return $response->getJson()['items'];
    }
    
    public function getByDni($dni) {
        $response = $this->http->post($this->url, [
            'texto' => $dni
        ]);
        
        return $response->getJson()['items'][0];
    }
}