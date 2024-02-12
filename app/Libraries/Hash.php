<?php
namespace App\Libraries;

class Hash
{
    /** RETURN HASHED PASSWORD */
    public static function make($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /** COMPARE PASSWORDS */
    public static function check($password, $db_hashed_password){
        if( password_verify($password, $db_hashed_password) ){
            return true;
        }else{
            return false;
        }
    }
}