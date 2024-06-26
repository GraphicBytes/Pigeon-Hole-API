<?php


function platform_check($platform){

    global $db;

    $return = array();
    $return['valid'] = 0;
    $return['platform'] = "";

    if ($platform !== null || $platform != "") {
      $res = $db->sql("SELECT * FROM platforms WHERE platform = ?", 's', $platform);
      while ($row = $res->fetch_assoc()) {
  
          $return['valid'] = 1;
          $return['platform'] = $row['platform'];
  
      }
    }

    return $return;

}