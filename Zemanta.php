<?php
/**
 * Zemanta Class
 *
 *  @version     1.0
 *  @author      Romack Natividad <romacknatividad@gmail.com>
 */

define('ZEMANTA_METHOD_CREATE_USER', 'zemanta.auth.create_user');
define('ZEMANTA_METHOD_SUGGESTIONS', 'zemanta.suggest');

class Zemanta {
    private $apiKey = false;
    private $restURL = 'http://api.zemanta.com/services/rest/0.0/';
    private $method;
    
    public function __construct($key = false) {
        if ($key !== false) {
            $this->apiKey = $key;
        }
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getRestURL() {
        return $this->restURL;
    }
    
    public function setApiKey($key) {
        $this->apiKey = $key;
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    public function fetchApiKey() {
        $this->setMethod(ZEMANTA_METHOD_CREATE_USER);
        $data = http_build_query(array('method' => $this->getMethod()));

        try {
            if (function_exists('curl_init')) {
                $session = curl_init($this->getRestURL());
                curl_setopt($session, CURLOPT_POST, true);
                curl_setopt($session, CURLOPT_POSTFIELDS, $data);

                // Don't return HTTP headers. Do return the contents of the call
                curl_setopt($session, CURLOPT_HEADER, false);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

                // Make the call
                $response = curl_exec($session);
                curl_close($session);

                $p = xml_parser_create();
                xml_parse_into_struct($p, $response, $vals, $index);
                xml_parser_free($p);

                if (isset($index['APIKEY'][0])) {
                    $key = $vals[$index['APIKEY'][0]]['value'];
                    $this->setApiKey($key);
                    error_log($key);
                    return true;
                }
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public function fetchSuggestions($text = false, $format = 'xml') {
        $this->setMethod(ZEMANTA_METHOD_SUGGESTIONS);
        $params = array(
            'method' => $data = $this->getMethod(),
            'api_key'=> $this->getApiKey(),
            'text'=> (!$text) ? '' : $text,
            'format'=> $format
        );

        $data = http_build_query($params);

        try {
            if (function_exists('curl_init')) {
                $session = curl_init($this->getRestURL());
                curl_setopt($session, CURLOPT_POST, true);
                curl_setopt($session, CURLOPT_POSTFIELDS, $data);

                // Don't return HTTP headers. Do return the contents of the call
                curl_setopt($session, CURLOPT_HEADER, false);
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

                // Make the call
                $response = curl_exec($session);
                curl_close($session);
                return $response;
            } else if (ini_get( 'allow_url_fopen')) {
                // $response = $this->zem_do_post_request($url, $data);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }
}
