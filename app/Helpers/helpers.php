<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

function id_number(){
    $id_number = Session::get('id_number');
    return $id_number;
}
