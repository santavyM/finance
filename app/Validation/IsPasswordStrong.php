<?php

namespace App\Validation;

class IsPasswordStrong
{
    public function is_password_strong($password): bool
    {
        $password = trim($password);
        if( !preg_match('/^(?=-*[\W])(?=.*[A-Z])(?=.*[0-9]).{5,20}$/', $password)){
            return true;
        }
        return false;
    }
}
