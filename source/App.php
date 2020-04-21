<?php
class App{
    public static function get__PATH_INFO($path){
        $path_elements = explode("/", $path);
        $tempPI = "";
        if (isset($path_elements[2])){
            for ($i = 2 ;$i < count($path_elements); $i++ )
                $tempPI .= "/".$path_elements[$i];
        }
        return $tempPI;
    }
}
?>