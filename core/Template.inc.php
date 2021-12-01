<?php

class Template
{
    protected $Params;
    protected $FileName;

    public function __construct($fileName)
    {
        $this->Params = array();
        $this->FileName=$fileName;

    }

    public function setParam($name, $value)
    {
        $this->Params[$name] = $value;
    }

    public function setParams($assocArray)
    {
        if(!empty($assocArray))
            $this->Params= array_merge($this->Params, $assocArray);
    }

    public function fetch()
    {
        extract($this->Params);
        ob_start();
        include($this->FileName);
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function display()
    {
        echo $this->fetch();
    }
}