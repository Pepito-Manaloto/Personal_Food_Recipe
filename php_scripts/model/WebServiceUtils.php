<?php
class WebServiceUtils
{
    public function authenticate()
    {
        $headers = apache_request_headers();
        
        $authorization = $this->getAuthorizationHeader($headers);

        if(isset($authorization))
        {
            $isAuthorized = $authorization === md5("aaron");
            if($isAuthorized)
            {
                return 200;
            }

            return 401;
        }

        return 400;
    }
    
    private function getAuthorizationHeader($headers)
    {
        if(array_key_exists('Authorization', $headers))
        {
            return isset($headers['Authorization']) ? $headers['Authorization'] : null;
        }
        else if(array_key_exists('authorization', $headers))
        {
            return isset($headers['authorization']) ? $headers['authorization'] : null;
        }

        return null;
    }

    public function returnErrorResponseDataAndCode($code, $errorMessage)
    {
        http_response_code($code);
        $error = array("Error" => $errorMessage);
        echo json_encode($error);
    }
}
?>