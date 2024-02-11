<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stripe Library for CodeIgniter 3.x
 *
 * Library for Stripe payment gateway. It helps to integrate Stripe payment gateway
 * in CodeIgniter application.
 *
 * This library requires the Stripe PHP bindings and it should be placed in the third_party folder.
 * It also requires Stripe API configuration file and it should be placed in the config directory.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      CodexWorld
 * @license     http://www.codexworld.com/license/
 * @link        http://www.codexworld.com
 * @version     3.0
 */

class Stripe_lib{
    var $CI;
	var $api_error;
    
    function __construct(){
		$this->api_error = '';
        $this->CI =& get_instance();
        $this->CI->load->config('stripe');
		
		// Include the Stripe PHP bindings library
		require APPPATH .'third_party/stripe-php/init.php';
		
		// Set API key
		\Stripe\Stripe::setApiKey($this->CI->config->item('stripe_api_key'));
    }

    function addCustomer($email, $token){
		try {
			// Add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $token
			));
			return array('status' => true, 'data' => $customer);
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();
			return array('status' => false, 'msg' => $this->api_error);
		}
    }

    function createPrice($price, $plan_name){
    	$priceCents = ($price*100);
		$currency = $this->CI->config->item('stripe_currency');
		try {
			// Create price with subscription info and interval
			$price = \Stripe\Price::create([
				'unit_amount' => $priceCents,
				'currency' => $currency,
				'recurring' => ['interval' => 'month'],
				'product_data' => ['name' => $plan_name],
			]);
			return array('status' => true, 'data' => $price);
		} catch (Exception $e) { 
			$api_error = $e->getMessage();
			return array('status' => false, 'msg' => $this->api_error);
		}
    }

    function subscriptionPayment($customer_id, $price_id){
		try {
			$subscription = \Stripe\Subscription::create([
				'customer' => $customer_id,
				'items' => [[
					'price' => $price_id,
				]],
				'payment_behavior' => 'default_incomplete',
				'expand' => ['latest_invoice.payment_intent'],
			]);
			return array('status' => true, 'data' => $price);
		}catch(Exception $e) {
			$api_error = $e->getMessage();
			return array('status' => false, 'msg' => $this->api_error);
		}
    }
	
	function createCharge($customerId, $itemName, $itemPrice){
		// Convert price to cents
		$itemPriceCents = ($itemPrice*100);
		$currency = $this->CI->config->item('stripe_currency');
		
		try {
			// Charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customerId,
				'amount'   => $itemPriceCents,
				'currency' => $currency,
				'description' => $itemName
			));
			
			// Retrieve charge details
			$chargeJson = $charge->jsonSerialize();
			return array('status' => true, 'data' => $chargeJson);
		}catch(Exception $e) {
			$this->api_error = $e->getMessage();			
			return array('status' => false, 'msg' => $this->api_error);
		}
    }
}