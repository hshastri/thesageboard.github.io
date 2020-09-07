<?php

use http\Env\Request;

if (! function_exists('areActiveNavs')) {
    function areActiveNavs(Array $routes, $output = "nav-item-expanded nav-item-open")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}


if (! function_exists('areActiveRoutes')) {
    function areActiveRoutes(Array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}

if (! function_exists('userActiveRoute')) {
    function userActiveRoute(Array $routes, $output = "current_page_item")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}

if (! function_exists('convert_time')) {
    function convert_time($date) {

        $mydate= date("Y-m-d H:i:s");
        $datetime1 = date_create($date);
        $datetime2 = date_create($mydate);
        $interval = date_diff($datetime1, $datetime2);

        $min=$interval->format('%i');
        $sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');

        if($interval->format('%i%h%d%m%y')=="00000")
        {
            return $sec." Seconds";
        }

        else if($interval->format('%h%d%m%y')=="0000"){
            return $min." Minutes";
        }

        else if($interval->format('%d%m%y')=="000"){
            return $hour." Hours";
        }

        else if($interval->format('%m%y')=="00"){
            return $day." Days";
        }
        else if($interval->format('%y')=="0"){
            return $mon." Months";
        }

        else{
            return $year." Years";
        }
    }
}


if (! function_exists('sign_vote')) {
    function sign_vote($num)
    {
        if ((int)$num >= 1 ){
            return "+".$num;
        }else if((int)$num <= 1){
            return $num;
        }
    }
}

if (! function_exists('previous')) {
    function previous()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        return $referer;
    }
}

if (! function_exists('convertHour')) {
    function convertHour($hour)
    {
        $seconds = $hour*3600;
        $seconds= (int)$seconds;
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@" . $seconds);
        if($dtF->diff($dtT)->d>0){
            return $dtF->diff($dtT)->format('%a days');
            /*return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');*/
        }else{
            return $dtF->diff($dtT)->format('%h hours');
        }

    }
}

if (! function_exists('rndString')) {
    function rndString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
}

if (! function_exists('getMyTime')) {
    function getMyTime()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $URL = 'http://www.geoplugin.net/php.gp?ip='.$ip;
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) {
            $data =unserialize($contents);
            $timezone = $data['geoplugin_timezone'];
            $dt = new DateTime();

            $tz = new DateTimeZone($timezone);
            $dt->setTimezone($tz);
            return  $dt;
        }
        else return FALSE;
    }
}


if (! function_exists('getUserTime')) {
    function getUserTime($utc)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $URL = 'http://www.geoplugin.net/php.gp?ip='.$ip;
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) {
            $data =unserialize($contents);
            $timezone = $data['geoplugin_timezone'];
            $dt = new DateTime($utc);
            $tz = new DateTimeZone($timezone);
            $dt->setTimezone($tz);
            return  $dt->format('Y-m-d H:i A');
        }else{
           return $utc;
        }
    }
}

if (! function_exists('getUTCTime')) {
    function getUTCTime($utc)
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $utc);
        return $date->setTimezone(new DateTimeZone('UTC'));
    }
}





?>
