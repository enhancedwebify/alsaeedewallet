<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

function id_number(){
    $id_number = Session::get('id_number');
    return $id_number;
}
function user_id(){
    $user_id = Session::get('user_id');
    return $user_id;
}
