<?php defined('BASEPATH') OR exit('No direct script access allowed');

// $config = array(
//     'protocol' => 'sendmail', // 'mail', 'sendmail', or 'smtp'
//     'smtp_host' => 'sendmail.gmail.com', 
//     'smtp_port' => 465,
//     'smtp_user' => 'infoloppekortet@gmail.com',
//     'smtp_pass' => 'Loppekortet77',
//     'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'text', //plaintext 'text' mails or 'html'
//     'smtp_timeout' => '4', //in seconds
//     'charset' => 'iso-8859-1',
//     'wordwrap' => TRUE
// );

$config['protocol'] = 'smtp';
$config['smtp_port']    = '587';
$config['smtp_host']    = 'smtp.sendgrid.net';
$config['smtp_user']    = 'info@loppekortet.dk';
$config['smtp_pass']    = 'Loppekortet23376543';
