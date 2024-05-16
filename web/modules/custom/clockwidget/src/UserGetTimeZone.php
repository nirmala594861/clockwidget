<?php

namespace Drupal\clockwidget;

/**
 *
 */
class UserGetTimeZone {

  protected $gettingtimezone;

  /**
   *
   */
  public function __construct() {

    $json = file_get_contents('https://worldtimeapi.org/api/timezone/UTC');
    $the_json = json_decode($json, TRUE);
    $this->gettingtimezone = $the_json['utc_datetime'];
  }

  /**
   *
   */
  public function Gettimezone($timezone = '') {
    if (empty($timezone)) {
      return $this->gettingtimezone;
    }
    else {
      return $this->gettingtimezone;
    }
  }

}
