<?php
/*
Plugin Name: Affiliate Tracker
Plugin URI: 
Description: Trackiing affiliate activity
Version: 100.0.0
Author: Asheish Gupta
*/

//add_action( 'init', 'add_affiliate_cookie' );
add_action('wp_footer', 'addTrackingJs');

function add_affiliate_cookie() {
 if(isset($_GET['Pcode'])) {
      
      $pcode = strip_tags($_GET['Pcode']);
      $time = time()+60*60*24*30;
        $secure = ( 'https' === parse_url( wp_login_url(), PHP_URL_SCHEME ) );
         setcookie( 'AFFILIATE_PCODE',$pcode, $time, COOKIEPATH, COOKIE_DOMAIN, $secure );
        
        if ( SITECOOKIEPATH != COOKIEPATH ) {
	      setcookie( 'AFFILIATE_PCODE',$pcode, $time, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );
        }
          
 }

 /*CXD*/
 if(isset($_GET['cxd'])) {
      
      $cxd    = strip_tags($_GET['cxd']);
      $time   = time()+60*60*24*30;
      $secure = ( 'https' === parse_url( wp_login_url(), PHP_URL_SCHEME ) );
      setcookie( 'AFFILIATE_CXD',$cxd, $time, COOKIEPATH, COOKIE_DOMAIN, $secure );
        
      if ( SITECOOKIEPATH != COOKIEPATH ) {
         setcookie( 'AFFILIATE_CXD',$cxd, $time, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );
      }
          
 }

 /*AFFID*/
 if(isset($_GET['affid'])) {
      
      $affid  = strip_tags($_GET['affid']);
      $time   = time()+60*60*24*30;
      $secure = ( 'https' === parse_url( wp_login_url(), PHP_URL_SCHEME ) );
      setcookie( 'AFFILIATE_AFFID',$affid, $time, COOKIEPATH, COOKIE_DOMAIN, $secure );
        
      if ( SITECOOKIEPATH != COOKIEPATH ) {
         setcookie( 'AFFILIATE_AFFID',$affid, $time, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );
      }
          
 }    
 
}


function addTrackingJs() {
    $url = plugin_dir_url(__FILE__);
    $str = '<script src="'.$url.'js/affiliate.js?v=12"></script>';
    echo $str;