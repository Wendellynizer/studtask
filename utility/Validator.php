<?php

// validates variables/inputs
class Validator {

    public static function isValid($value) {
        if(empty($value)) 
            return false;

        return true;
    }
}