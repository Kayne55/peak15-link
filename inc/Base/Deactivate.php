<?php
/**
 * @package Peak15Link
 */

 namespace Inc\Base;

 class Deactivate
 {
     public static function deactivate() {
         flush_rewrite_rules();
     }

 }