<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//https://developers.facebook.com/docs/reference/php/facebook-getLoginUrl/
$config['facebook_login_parameters'] = array(
                                    'scope' => 'publish_actions',
                                    'redirect_uri' => 'http://sneakertrade.ph/fblogin/fb/',
                                    'display' => 'page'
                                    );