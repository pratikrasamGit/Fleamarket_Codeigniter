<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '1069648185488-uugo19npjocurckrui9mtpjsiv0pcpjr.apps.googleusercontent.com';
$config['google']['client_secret']    = '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';
$config['google']['redirect_uri']     = 'https://www.loppekortet.dk/auth_google';
$config['google']['application_name'] = 'lopperkortet';
$config['google']['api_key']          = '';
$config['google']['scopes']           = array();

