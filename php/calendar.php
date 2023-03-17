<?php


$stdin = fopen('php://stdin', 'r');

$keywords = fgets($stdin);

function calendar()
{
    $date = date("d-m-Y");
    $date = explode("-", $date);
    $day = date('N', mktime(0,0,0,$date[1], 1, $date[2]));

    $n = - ($day - 2);
    $cal = [];
    for($y = 0; $y < 6; $y++){
        $row = [];
        $notEmpty = false;
        for($x = 0; $x < 7; $x++, $n++){
            if(checkdate($date[1], $n, $date[2])){
                $row[] = $n;
                $notEmpty = true;
            } else {
                $row[] = "";
            }
        
        }
        if(!$notEmpty) break;
        $cal[] = $row;
    }
    return $cal;
}

function showCal($cal)
{
    $str = "";
    $str .= "Пн.Вт.Ср.Чт.Пт.Сб.Вс.".PHP_EOL;
    foreach($cal as $weeks){
        foreach($weeks as $key => $day){
            if(date('d') == $day){
                $day = "\e[31m$day\e[0m";
            }
            if(strlen($day) == 0){   
                $str .= "   ";
            }elseif(strlen($day) == 1){
                $str .= " $day ";
                
            }else{
                $str .= "$day ";
                
                
            }
        }
        $str .= PHP_EOL;
    }
    return $str;
}

    
    if($keywords == "cal".PHP_EOL){
        echo showCal(calendar());
    }

