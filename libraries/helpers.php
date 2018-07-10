<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/6/16
 * Time: 10:31
 */
if(!function_exists('dump')){
    function dump($var){
        echo '<pre>';
        foreach(func_get_args() as $var){
            var_dump($var);
        }
        echo '</pre>';
    }
}

if(!function_exists('request')){
    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    function request(){
        return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
    }
}


if(!function_exists('asset')){
    /**
     * @param string $path
     * @param bool $full
     * @return string
     */
    function asset($path, $full = true){
        $request = request();
        if($full){
            return $request->getSchemeAndHttpHost().$request->getBasePath().'/'.$path;
        }
        return $request->getBasePath().'/'.$path;
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
                return true;
            case 'false':
                return false;
            case 'null':
                return null;
        }

        return $value;
    }
}
