<?php

function view(String $view, Mixed $data = [])
{
    if (!empty($data)) extract($data);
    include '../Routes/view/'.$view.'.view.php';

}