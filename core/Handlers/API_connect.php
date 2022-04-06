<?php 

/*
    Class for setting up a REST API connection.
    This is a class in progress, which means that the functionality will be improved over time. 
    Comments are always welcome.
    This version is basically working, but still very incomplete.
    
    Created: 2022-01-25
    Updated: 2022-01-27

    Varjoissa


    ***** TODO *****
    **1 Setup authorisation methods (declarations, setAuth())
    **2 Check if $this->variables can be used as standard value in optional arguments. (request)
    **3 setup responseheaders (getResponseHeaders)
*/

// namespace core\Handlers;

// use PDO;

class REST_API_CONNECTION
{
    protected $connection;
    protected $connection_status = false;

    protected $current_requestMethod = 'GET';
    protected $endpoint;
                                         
    protected $request_headers = [];
    protected $request_body;
    
    protected $response;
    protected $response_headers = [];
    protected $response_body;
    
    protected $options = [];                                                              // DOCS curl_setopt(): https://www.php.net/manual/en/function.curl-setopt.php
        
    // **1 Figure out whether to keep authorization info seperated or in an array.
    // protected $auth = []; // Type, ID, Key
    protected $auth_id;
    protected $auth_key;
    protected $auth_type; //**1 Set as standard authorisation type
    
    // CONSTRUCTOR
    function __construct(
        $endpoint, 
        $parameters = []                        // headers, options, auth[entication]
    ) {
        // Setup API Endpoint
        $this->endpoint = $endpoint;
        $this->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_URL => $this->endpoint, 
            CURLOPT_HEADERFUNCTION => array($this,'setResponseHeadersCallback')
        ]);

        // Setup
        foreach ($parameters as $paramKey => $paramArr) {
            switch ($paramKey) {
                case 'auth':
                    $this->setAuth($paramArr);
                    break;
                case 'headers':
                    $this->setHeaders($paramArr);
                    break;
                case 'options':
                    $this->setOptions($paramArr);
                    break;
                default:
            }
        }
    }

    // SETTERS
    
    function setAuth($auth = [])
    {
        if (isset($auth)) {
            foreach ($auth as $key => $setting) {
                /*
                    **1 Learn about authorisation types and implement various ways
                    - $key == 'type' >> Authorisation type
                    - $key == 'id' or 'user' >> $this->auth_id;
                    - $key == 'pass' or 'code'
                */
            }
        }
    }

    function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }



    private function setResponseHeadersCallback($connection, $header)
    {
        $len = strlen($header);
        $parts = explode(":", $header);
        if (count($parts) == 2) {
            $this->response_headers[$parts[0]] = trim($parts[1]);
        } else {
            $this->response_headers[] = $header;
        }
        return $len;
    }

    function setHeaders($headers = [])                                  // Request Headers only
    {
        if (isset($headers)) {
            foreach ($headers as $header) {
                $this->request_headers[] = $header;
            }
        }
        $this->options[CURLOPT_HTTPHEADER] = $this->request_headers; 
    }   
    
    function setOptions($options = [])
    {

        if (isset($options)) {
            foreach ($options as $key => $value) {
                $this->options[$key] = $value;
            }
        }
    }
    



    // GETTERS

    function getData($newRequest = false)
    {
        if ($newRequest === false && isset($this->response)) {
            return $this->response;
        } else {
            if ($this->connection_status === false) {
                $this->initialize();
            }
                return curl_exec($this->connection);
        }
    }

    function getInfo($infotype)
    {
                                                   // DOCS curl_getinfo: https://www.php.net/manual/en/function.curl-getinfo.php
        switch ($infotype) {
            case 'CURLINFO_CONTENT_LENGTH' || 'CONTENT_LENGTH' || 'content-length' || 'contentlength':
                return curl_getinfo($this->connection, CURLINFO_CONTENT_TYPE);
                break;
            case 'CURLINFO_CONTENT_TYPE' || 'CONTENT_TYPE' || 'content-type' || 'contenttype':
                return curl_getinfo($this->connection, CURLINFO_CONTENT_TYPE);
                break;
            case 'CURLINFO_HTTP_CODE' || 'HTTP_CODE' || 'status-code' || 'statuscode' || 'status':
                return curl_getinfo($this->connection, CURLINFO_HTTP_CODE);         // DOCS HTTP Status Codes: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
                break;
            default:
                return false;
        }
    }
    

    function getResponseHeaders($header = null)
    {
        /*
        **5 setup responseheaders
        if is_array headers
            loop through headers
            if match, add to tempheaders
            return tempheaders
        else
            loop through headers
            if match, return tempheaders
        end if

        
         */
        if ($header === null or $header = '') {
            return $this->response_headers;
        } else {
        }
    }

    
    // FUNDAMENTALS
    function initialize()
    {
        try {
            if (!isset($this->connection)) {
                $this->connection = curl_init();
                $this->connection_status = true;
            } 

            if (isset($this->options) && $this->connection_status = true) {
                curl_setopt_array($this->connection, $this->options);
            } 
        } catch (Exception $error) {
            echo "Error: Initializing API '$this->endpoint' went wrong: " . $error->getMessage();
        }
    }

    function request(
        $method = null, 
        $endpoint = null,
        $returnData = 'NONE',               // Other options: 'JSON', 'ARR'
        $returnHeaders = false,
        $requestHeaders = [],
        $requestBody = ''
    ) {
        // Set standard request information. **4 Check if $this->variables can be used as standard value in optional arguments.
        if ($method === '' or $method === null) {
            $method = $this->current_requestMethod;
        }
        if ($endpoint === '' or $endpoint === null) {
            $endpoint = $this->endpoint;
        }
        return $this->getData();
    }


    function close()
    {
        curl_close($this->connection);
        $this->connection_status = false;
    }
}
