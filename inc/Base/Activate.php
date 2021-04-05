<?php
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 class Activate 
 {
     public static function activate() {
         flush_rewrite_rules();
     }

 }