<?php

/**
 * Copyright (c) 2013, EBANX Tecnologia da InformaÃ§Ã£o Ltda.
 *  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * Neither the name of EBANX nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Plugin Name: Woocommerce EBANX Express Payment Gateway
 * Plugin URI: http://developers.ebanx.com
 * Description: This plugin extends the WooCommerce payment gateways with the EBANX payment gateway
 * Version: 2.1.2
 * Developer: EBANX Tecnologia da InformaÃ§Ã£o Ltda.
 * Developer URI: https://www.ebanx.com/
*/

// Add a custom payment class to WooCommerce
add_action('plugins_loaded', 'woocommerce_ebanx_payment_gateway_init', 0);

function woocommerce_ebanx_payment_gateway_init()
{
	// If the Woocommerce payment gateway class is not available, do nothing
	if (!class_exists('WC_Payment_Gateway'))
	{
		return;
	}

	// Require the library, the return routes and the WC gateway class
	require_once 'ebanx-php/src/autoload.php';
	require_once 'return.php';
	require_once 'WC_Gateway_Ebanx.php';

	// Add the payment gateway to the WooCommerce gateways
	add_filter('woocommerce_payment_gateways', 'add_woocommerce_ebanx_payment_gateway');
	function add_woocommerce_ebanx_payment_gateway($methods)
	{
		$methods[] = 'WC_Gateway_Ebanx';
		return $methods;
	}

	// Add stylesheet and javascripts
	add_action('wp_enqueue_scripts', 'add_ebanx_assets');
	function add_ebanx_assets()
	{
		wp_enqueue_style('ebanx-css', plugins_url('assets/app.css', __FILE__));
		wp_enqueue_script('jquery');
		wp_enqueue_script('ebanx-js', plugins_url('assets/app.js', __FILE__));
		wp_enqueue_script('ebanx-js-masked', plugins_url('assets/vendor/jquery.maskedinput.min.js', __FILE__));
	}
}
