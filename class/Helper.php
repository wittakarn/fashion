<?php

class Helper {

    public static function getDefaultValue($value, $default) {
        return isset($value) && $value != '' ? $value : $default;
    }

}

?>