<?php

class Helper {

    public static function getDefaultValue($value, $default) {
        return $value != '' ? $value : $default;
    }

}

?>