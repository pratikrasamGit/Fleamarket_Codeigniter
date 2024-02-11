<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Stripe API Configuration
| -------------------------------------------------------------------
|
| You will get the API keys from Developers panel of the Stripe account
| Login to Stripe account (https://dashboard.stripe.com/)
| and navigate to the Developers » API keys page
| Remember to switch to your live publishable and secret key in production!
|
|  stripe_api_key        	string   Your Stripe API Secret key.
|  stripe_publishable_key	string   Your Stripe API Publishable key.
|  stripe_currency   		string   Currency code.
*/
$config['stripe_api_key']         = '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'; 
$config['stripe_publishable_key'] = 'pk_live_51KKqN2Bqk2bdo0puJ3Vkh8yQvAi0swoupTWKPsajhbhAHppTZ7HdW2My4TKMRTFWALU1hAlVcRZLt1gHWxvjhphD00a888jBd5'; 
$config['stripe_currency']        = 'dkk';