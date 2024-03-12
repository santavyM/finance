<?php
namespace App\Libraries;
use App\Models\User;

class CIAuth
{
    /** STORE LOGGED IN USER DETAILS IN SESSION */
    public static function setCIAuth($result){
        $session = session();
        $array = ['logged_in'=>true];
        $userdata = $result;
        $session->set('userdata', $userdata);
        $session->set($array);
    }

    /** GET LOGGED IN ID  */
    public static function id(){
        $session = session();
        if( $session->has('logged_in') ){
            if( $session->has('userdata') ){
                return $session->get('userdata')['id'];
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    /** CHECK IF USER IS AUTHENTICATED */
    public static function check(){
        $session = session();
        return $session->has('logged_in');
    }

    /** LOGOUT FUNCTION */
    public static function forget(){
        $session = session();
        $session->remove('logged_in');
        $session->remove('userdata');
    }

    /** RETURN USER DETAILS */
    public static function user(){
        $session = session();
        if( $session->has('logged_in') ){
            if( $session->has('userdata') ){
                // return $session->get('userdata');
                $user = new User();
                return $user->asObject()->where('id',CIAuth::id())->first();
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
}