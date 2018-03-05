@extends('layouts.default')
@section('content')
	<!-- Load the required Braintree client component - Begin -->
	<script src="https://js.braintreegateway.com/web/3.11.0/js/client.min.js"></script>
	<script src="https://js.braintreegateway.com/web/3.11.0/js/hosted-fields.min.js"></script>
	<script src="https://js.braintreegateway.com/web/3.11.0/js/paypal-checkout.min.js"></script>
	<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
	<!-- Load the required Braintree client component - End -->
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h3>Please choose a Payment Method:</h3>
			<table style ="border-collapse: separate; border-spacing: 0 .5em;">
				<form id="bt-hsf-checkout-form" action="transaction" method="post">
					<!--
					<input type="hidden" name="first_name" id="first_name" value="Veena"/>
					<input type="hidden" name="last_name" id="last_name" value="Kalappagari"/>
					<input type="hidden" name="line1" id="line1" value="2211 N First Street"/>
					<input type="hidden" name="line2" id="line2" value="The Great Lake"/>
					<input type="hidden" name="city" id="city" value="San Jose"/>
					<input type="hidden" name="state" id="state" value="CA"/>
					<input type="hidden" name="postal_code" id="postal_code" value="95131"/>
					<input type="hidden" name="country_code" id="country_code" value="IN"/>
					-->
					<br/>
					<tr>
						<td>
						    
							<div id="papbutton"></div>
							<!--Container for hosting the Checkout with PayPal button-->
							<span style="margin-left:60px">OR</span>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td colspan="2">Payment Methods:</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="invalid-field-error" class="btError" style="display:none; color:red;">Please enter the missing credit card fields / enter appropriate values.</div>
							<div style="font-size: 11px;">NOTE:Please enter the values displayed in the credit card fields</div>
						</td>
					</tr>
					<!--Hosted Fields for Credit Card Payment-->
					<tr>
						<td>Card Number</td>
						<td>
							<div class="hosted-field" id="card-number"></div>
						</td>
					</tr>
					<tr>
						<td><br/></td>
					</tr>
					<tr>
						<td>CVV</td>
						<td>
							<div class="hosted-field" id="cvv"></div>
						</td>
					</tr>
					<tr>
						<td><br/></td>
					</tr>
					<tr>
						<td>Expiration Date</td>
						<td>
							<div class="hosted-field" id="expiration-date"></div>
						</td>
					</tr>
					<tr>
						<td><br/> </td>
					</tr>
					<tr>
						<td><input type="hidden" name="currencyCodeType" value="USD"/>
							<input type="hidden" id="paymentAmount" name="paymentAmount" value="1"/>
							<input type="hidden" name="payment_method_nonce" id ="payment_method_nonce"/>
							<input class="btn btn-primary" type="submit" value="Pay with Card"/>
						</td>
					</tr>
				</form>
			</table>
		</div>
		<div class="col-md-4"></div>
	</div>
	<script type="text/javascript">
		var authorization = "<?php print $clientToken; ?>";
		var submit = document.querySelector('input[type="submit"]');
		var btForm = document.getElementById('bt-hsf-checkout-form');
		var btPayPalButton = document.getElementById('bt-paypal-button');
		var paymentAmount = document.getElementById('paymentAmount').value;
		
		braintree.client.create({
			authorization: authorization
		}, function(clientErr, clientInstance) {
			if (clientErr) { /*Handle error in client creation*/
				console.log('Error creating client instance:: ' + clientErr);
				return;
			}
			/* Braintree - Hosted Fields component */
			braintree.hostedFields.create({
				client: clientInstance,
				styles: {
					'input': {
						'font-size': '14pt',
						'color': '#6E6D6C'
					},
					'input.invalid': {
						'color': 'red'
					},
					'input.valid': {
						'color': 'green'
					}
				},
				fields: {
					number: {
						selector: '#card-number',
						placeholder: '4111 1111 1111 1111'
					},
					cvv: {
						selector: '#cvv',
						placeholder: '123'
					},
					expirationDate: {
						selector: '#expiration-date',
						placeholder: '10/2019'
					}
				}
			}, function(hostedFieldsErr, hostedFieldsInstance) {
				if (hostedFieldsErr) { /*Handle error in Hosted Fields creation*/
					return;
				}
				submit.removeAttribute('disabled');
				btForm.addEventListener('submit', function(event) {
					event.preventDefault();
					hostedFieldsInstance.tokenize(function(tokenizeErr, payload) {
						if (tokenizeErr) { /* Handle error in Hosted Fields tokenization*/
							document.getElementById('invalid-field-error').style.display = 'inline';
							return;
						} /* Put `payload.nonce` into the `payment-method-nonce` input, and thensubmit the form. Alternatively, you could send the nonce to your serverwith AJAX.*/
						/* document.querySelector('form#bt-hsf-checkout-form input[name="payment_method_nonce"]').value = payload.nonce;*/
						document.getElementById('payment_method_nonce').value = payload.nonce;
						console.log('hostfield nonece', payload.nonce);
						btForm.method = "get";
						if ("merchant" === "merchant") {
							btForm.submit();
						}
					});
				}, false);
			});

			/* Braintree - PayPal button component */
			braintree.paypalCheckout.create({
				client: clientInstance
			}, function (createErr, paypalCheckoutInstance) {
				if (createErr) {
					if (createErr.code === 'PAYPAL_BROWSER_NOT_SUPPORTED') {
						console.error('This browser is not supported.');
					} else {
						console.error('Error!', createErr);
					}
					return;
				}

				paypal.Button.render({
					env: 'sandbox', /* or 'production'*/

					locale: 'en_US',

					payment: function () {
						return paypalCheckoutInstance.createPayment({
							flow: 'checkout',
							intent: 'sale',
							amount: paymentAmount,
							currency: 'USD',
							locale: 'en_US',
							displayName: 'Demo Portal Test Store',
							enableShippingAddress: false,
							shippingAddressEditable: false,

						});
					},

					commit: true, // Optional: show a 'Pay Now' button in the checkout flow

					onAuthorize: function (data, actions) {
						return paypalCheckoutInstance.tokenizePayment(data, function (err1, payload) {
							if (err1) {
								console.log(err1);
							} else {
								console.log('Paypal nonce!',payload.nonce );

								document.getElementById('payment_method_nonce').value = payload.nonce;
								btForm.method = "get";
								btForm.submit();
							}
						});
					},

					onCancel: function (data) {
						console.log('checkout.js payment cancelled', JSON.stringify(data, 0, 2));
						var currentUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
						var cancelUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/')) + '/cancel.php';
						window.location.href = cancelUrl;

					},

					onError: function (err) {
						console.error('checkout.js error', err.toString());
						var currentUrl = window.location.href = window.location.protocol + '//' + window.location.host + window.location.pathname;
						var errorUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/')) + '/error.php?err='+err.toString();
						window.location.href = errorUrl;
					}
				}, '#papbutton');
				/* the PayPal button will be rendered in an html element with the id `papbutton`*/
			});

		});
	</script>
	<!--Styling for the Hosted Fields-->
	<style>
		#card-number, #cvv, #expiration-date {
			-webkit-transition: border-color 160ms;
			transition: border-color 160ms;
			height: 25px;
			width: 250px;
			-moz-appearance: none;
			border: 0 none;
			border-radius: 5px;
			box-shadow: 0 0 4px 1px #a5a5a5 inset;
			color: #DDDBD9;
			display: inline-block;
			float: left;
			font-size: 13px;
			height: 40px;
			margin-right: 2.12766%;
			padding-left: 10px;
		}
	</style>


@stop
@section('scripts')
@stop
