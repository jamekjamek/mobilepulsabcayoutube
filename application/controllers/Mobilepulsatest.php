<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobilepulsatest extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->client = new \GuzzleHttp\Client;
    }


    public function getBalance()
    {
        $client = $this->client->request('POST', 'https://testprepaid.mobilepulsa.net/v1/legacy/index', [
            'header' => [
                'Content-Type' => 'application/json'
            ],
            'json'  => [
                'commands'  => 'balance',
                'username'  => '081113109504',
                'sign'      => 'dd3a40e519532d23d2af217098877262'
            ]
        ]);
        $results    = json_decode($client->getBody()->getContents(), true);
        var_dump($results);
        die;
    }

    public function getPriceList()
    {
        $client = $this->client->request('POST', 'https://testprepaid.mobilepulsa.net/v1/legacy/index', [
            'header' => [
                'Content-Type' => 'application/json'
            ],
            'json'  => [
                'commands'  => 'pricelist',
                'username'  => '081113109504',
                'sign'      => '02deea237de65d0c01fc426f8befb5be'
            ]
        ]);
        $results    = json_decode($client->getBody()->getContents(), true);
        var_dump($results);
        die;
    }
}

/* End of file Controllername.php */
