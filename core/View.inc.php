<?php

class View
{
    public function generate($title, $file, $param ='')
    {
        $contentTpl = new Template($file);
        $contentTpl->setParam('Params', $param);
        return array('Title'=> $title,
            'Content'=>$contentTpl->fetch());
    }
}
