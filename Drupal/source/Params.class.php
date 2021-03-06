<?php
/*
Copyright 2011 Microsoft Corporation

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

/*
 * These methods could even be folded into the parent scaffold class so any scaffolders built
 * simple call
 * 
 * $this->addParam
 * $this->getParamValue
 * etc...
 */



class Params {
    
    /**
     * Holds a list of parameters for the command line tools
     * 
     * array (<param_name>, array(<required|optional>, <value>, <message>, <get_from>))
     * @var Array
     */
    private $mParams;
    
    public function __construct(){}
    
    public function add($name, $required, $default_value, $message, $get_from = "*") {
        $this->mParams[$name] = array($required, $default_value, $message, $get_from); 
    }
    
    public function remove($name) {
        unset($this->mParams[$name]);
    }
    
    public function verify($params) { 
        $keys = array_keys($params);
        $msg = "";
        foreach($this->mParams AS $k => $v) { 
            if($v[0] /* required */ && (!in_array($k, $keys) || is_null($params[$k]))) {
                $msg = "\n{$v[2]}";
            } 
            /* this line is a patch for current cmd code */if(!is_null($params[$k])) $this->setValue($k, $params[$k]);
        }
        if($msg != '') die("The following required parameters could not be found:\n$msg");
    }
    
    public function setValue($param, $value) {
        $this->mParams[$param][1] = $value;
    }
    
    public function getValue($param) {
        return $this->mParams[$param][1];
    }
    
    public function valueArray() {
        $arr = array();
        foreach($this->mParams AS $k => $v) {
            $arr[$k] = $v[1];
        }
        return $arr;
    }
    
    
} // end class
