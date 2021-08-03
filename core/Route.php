<?php

class Route {
    // function __construct()
    // {
    //     echo "route";
    // }

    function handleRoute ($url) {
        global $routes;
        unset($routes['default_controller']);
        $handleUrl = trim($url,'/');
        if (!empty($routes)){
            foreach ($routes as $key => $value) {
                if(preg_match('~'.$key.'~is', $url)){
                    $handleUrl = preg_replace('~'.$key.'~is', $value, $url);
                }
            }
        }
        return $handleUrl;
    }
}
?>