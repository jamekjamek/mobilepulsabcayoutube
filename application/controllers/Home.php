<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Exception\BadResponseException;

class Home extends CI_Controller
{

    private static $main_url        = 'https://sandbox.bca.co.id';
    private static $client_id       = '3ec0e446-1ab6-4b18-b823-9cb174b8f471';
    private static $client_secret   = '8e4b885a-6bd6-48aa-a290-e28ca3460a67';
    private static $api_key         = '99319500-625f-439e-af9d-ca6d4ca9a37c';
    private static $api_secret      = 'ed936a07-08cd-4758-a0d2-971756ecb504';
    private static $access_token    = null;
    private static $timestamp       = null;
    private static $corporate_id    = 'BCAAPI2016';
    private static $account_number  = '0201245680';


    public function __construct()
    {
        parent::__construct();
        $this->guzzle       = new \GuzzleHttp\Client;
        self::$timestamp    = date('o-m-d') . 'T' . date('H:i:s') . '.' . substr(date('u'), 0, 3) . date('P');
        $this->getToken();
    }


    public function index()
    {

        if ($this->input->get('startDate') && $this->input->get('endDate')) {
            $startDate  = $this->input->get('startDate');
            $endDate    = $this->input->get('endDate');
        } else {
            // $startDate  = date('Y-m-') . '01';
            // $endDate  = date('Y-m-d');
            $startDate  = '2016-08-29';
            $endDate    = '2016-09-01';
        }


        $results        = $this->getStatements($startDate, $endDate);
        if (@$results->ErrorCode) {
            $alert  = ' <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' . $results->ErrorMessage->Indonesian . '
                        </div>';

            $this->session->set_flashdata('error', $alert);
            redirect('bca');
        } else {
            $statements = $results->Data;
            $danamasuk  = 0;
            foreach ($statements as $mutasi) {
                if ($mutasi->TransactionType == 'C') {
                    $danamasuk += $mutasi->TransactionAmount;
                }
            }
        }

        $data   = [
            'title'         => 'HOME BCA',
            'saldo'         => $this->getBalance(),
            'danamasuk'     => $danamasuk,
            'statements'    => $statements
        ];
        $page   =    '/home/index';
        page($page, $data);
    }

    private function getToken()
    {
        $url        = '/api/oauth/token';
        $output     = $this->guzzle->request('POST', self::$main_url . $url, [
            'verify'        => false,
            'headers'       => [
                'Authorization'     => 'Basic ' . base64_encode(self::$client_id . ':' . self::$client_secret),
                'Content-Type'      => 'application/x-www-form-urlencoded'
            ],
            'form_params'   => [
                'grant_type'        => 'client_credentials'
            ]
        ]);
        $output     = json_decode($output->getBody()->getContents(), true);
        return self::$access_token = $output['access_token'];
    }


    private function getSignature($method, $relative_url, $request_body = '')
    {
        $request_body   = strtolower(hash('sha256', $request_body));
        $stringToSign   = $method . ':' . $relative_url . ':' . self::$access_token . ':' . $request_body . ':' . self::$timestamp;
        $signature      = hash_hmac('sha256', $stringToSign, self::$api_secret);
        return $signature;
    }


    private function getBalance()
    {
        $url        =   '/banking/v3/corporates/' . self::$corporate_id . '/accounts/' . self::$account_number;
        $method     = 'GET';

        $output     = $this->guzzle->request($method, self::$main_url . $url, [
            'verify'    => false,
            'headers'   => [
                'X-BCA-Signature'   => $this->getSignature($method, $url),
                'CorporateID'       => self::$corporate_id,
                'Authorization'     => 'Bearer ' . self::$access_token,
                'X-BCA-Key'         => self::$api_key,
                'AccountNumber'     => self::$account_number,
                'X-BCA-Timestamp'   => self::$timestamp
            ]
        ]);

        $output = json_decode($output->getBody()->getContents(), true);
        return $output['AccountDetailDataSuccess'][0]['Balance'];
    }


    private function getStatements($startDate, $endDate)
    {

        $url        =   '/banking/v3/corporates/' . self::$corporate_id . '/accounts/' . self::$account_number . '/statements?EndDate=' . $endDate . '&StartDate=' . $startDate;
        $method     = 'GET';
        try {
            $output     = $this->guzzle->request($method, self::$main_url . $url, [
                'verify'    => false,
                'headers'   => [
                    'X-BCA-Signature'   => $this->getSignature($method, $url),
                    'StartDate'         => $startDate,
                    'EndDate'           => $endDate,
                    'CorporateID'       => self::$corporate_id,
                    'Authorization'     => 'Bearer ' . self::$access_token,
                    'X-BCA-Key'         => self::$api_key,
                    'AccountNumber'     => self::$account_number,
                    'X-BCA-Timestamp'   => self::$timestamp
                ]
            ]);
            $output = json_decode($output->getBody()->getContents());
        } catch (BadResponseException $exception) {
            $output = json_decode($exception->getResponse()->getBody()->getContents());
        }
        return $output;
    }
}

/* End of file Home.php */
