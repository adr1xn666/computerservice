<?php

function ajax_echo(
    $title = '',
    $desc = '',
    $error = true,
    $type = 'ERROR',
    $other = null
){
    return json_encode(array(
        "error" => $error,
        "type" => $type,
        "title" => $title,
        "desc" => $desc,
        "other" => $other,
        "datetime" => array(
            'Y' => date('Y'),
            'm' => date('m'),
            'd' => date('d'),
            'H' => date('H'),
            'i' => date('i'),
            's' => date('s'),
            'full' => date('Y-m-d H:i:s')
        )));
};


function ViborMaxMin($arr){
    $size = count($arr);
    for($i=0; $i < $size; $i++) {
        $k=$i; 
        $x=$arr[$i];
        for($j=$i+1; $j < $size; $j++)
          if ($arr[$j] > $x) {
            $k=$j; $x=$arr[$j];
          }

        $arr[$k] = $arr[$i]; $arr[$i] = $x;
    }
    return $arr;
}

function ViborMinMax($arr){
    $size = count($arr);
    for($i=0; $i < $size; $i++) {
        $k=$i;
        $x=$arr[$i];
        for($j=$i+1; $j < $size; $j++)
          if ($arr[$j] < $x) {
            $k=$j; $x=$arr[$j];
          }
        $arr[$k] = $arr[$i]; 
        $arr[$i] = $x;
    }
    return $arr;
}


function SortirovkaMassiva($arr){
  $size = count($arr);
  for($i=0; $i < $size; $i++) {
      $k=$i; $x=$arr[$i];
  
      for( $j=$i+1; $j < $size; $j++)
        if (  $arr[$j] -> size > $x -> size ) {
          $k=$j; $x=$arr[$j];
        }
  
      $arr[$k] = $arr[$i]; $arr[$i] = $x;
  }
  return $arr;
}

function ScanirovanieDirectorii($dir){
  $arr = scandir($dir);
  $dir = $dir."/";
  $size = count($arr);
  $rez = array();
  for($i=0; $i < $size; $i++) {
      if(filetype($arr[$i]) == "dir"){
          $is_dir = true;
      }
      else {
          $is_dir = false;
      }
      $push = array(
          "name" => $arr[$i],
          "path" => $dir.$arr[$i],
          "size" => filesize($dir.$arr[$i]),
          "ext" => pathinfo($dir.$arr[$i], PATHINFO_EXTENSION),
          "is_dir" => $is_dir
      );
      array_push($rez, $push);
  }
  for($i=0; $i < $size; $i++) {
      if(filetype($arr[$i]) == "dir" && $arr[$i] != "." && $arr[$i] != ".." ){
          $rez = array_merge($rez, ScanirovanieDirectorii($dir.$arr[$i]));
      }
  }
  return $rez;
}

function PhoneFormat($phone)  {
  preg_match_all("/([0-9])([0-9]{3})([0-9]{2})([0-9]{2})([0-9]{3})/ui", $phone, $matches, PREG_PATTERN_ORDER);
  return "+".$matches[1][0]." (".$matches[2][0].") ".$matches[3][0]."-".$matches[4][0]."-".$matches[5][0];
}
function MailObfuscation($email)  {
  preg_match_all("/(.*)@/ui", $email, $len, PREG_PATTERN_ORDER);

  if(strlen($len[1][0]) == 1)
      preg_match_all("/(.*)@/ui", $email, $matches, PREG_PATTERN_ORDER);
  if(strlen($len[1][0]) >= 2)
      preg_match_all("/.{1}(.*)@/ui", $email, $matches, PREG_PATTERN_ORDER);
  if(strlen($len[1][0]) >= 3)
      preg_match_all("/.{1}(.*)@/ui", $email, $matches, PREG_PATTERN_ORDER);
  if(strlen($len[1][0]) >= 4)
      preg_match_all("/.{1}(.*).{1}@/ui", $email, $matches, PREG_PATTERN_ORDER);
  if(strlen($len[1][0]) >= 6)
      preg_match_all("/.{3}(.*).{2}@/ui", $email, $matches, PREG_PATTERN_ORDER);

  $stars = "";
  for ($i=0; $i < strlen($matches[1][0]); $i++) $stars = $stars.'*';
  return str_replace($matches[1][0], $stars, $email);
}

function minmaxtime($date_values) {
  $min = PHP_INT_MAX;
  $max = 0;
  foreach($date_values as $date) {
    if(is_array($date)) {
      $temp = minmaxtime($date);
      $min = min($min, $temp['min']);
      $max = max($max, $temp['max']);
    } else {
      if(preg_match('/^([0-9]{1,2}){2}:?([0-9]{1,2}){0,2}:?[0-9]{0,3}:?[0-9]{0,4}$/', $date)) {
          $min = min($min, $date);
          $max = max($max, $date);
        
      }
    }
  }
  return array('min' => $min, 'max' => $max);
}