<?php

class Curl{
    private $_ch        = null;
    private $_url       = null;
    private $_method    = null;
    private $_params    = null;

    public function __construct($url,$method,$params){
        $this->_ch      = curl_init();
        $this->_url     = $url;
        $this->_method  = $method;
        $this->_params  = $params;
    }

    public function execute(){
        curl_setopt($this->_ch,CURLOPT_FAILONERROR,false);
        curl_setopt($this->_ch,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($this->_ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($this->_ch,CURLOPT_SSL_VERIFYPEER,false);

        if($this->_method == 'GET'){
            $this->_url = $this->_url. '?';
            foreach($this->_params as $k => $v){
                $this->_url .= "$k=".urlencode($v).'&';
            }
            $this->_url = substr($this->_url,0,-1);
            curl_setopt($this->_ch,CURLOPT_URL,$this->_url);
        }else if($this->_method == 'POST'){
            curl_setopt($this->_ch,CURLOPT_URL,$this->_url);
            curl_setopt($this->_ch,CURLOPT_POST,true);
            curl_setopt($this->_ch,CURLOPT_POSTFIELDS,http_build_query($this->_params));
        }else{
            throw new Exception("invalid http method", 404);
        }

        $response = curl_exec($this->_ch);
        if(curl_errno($this->_ch)){
            throw new Exception(curl_error($this->_ch),0);
        }else{
            $retCode = curl_getinfo($this->_ch,CURLINFO_HTTP_CODE);
            if($retCode != '200'){
                throw new Exception($response,$retCode);
            }
        }
        curl_close($this->_ch);
        return json_decode($response,true);
    }
}
