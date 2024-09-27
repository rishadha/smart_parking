<?php
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_51N2EheDYfSD2I0DwXD8s4uGPQhi30XbTTJNYRcO0BqLM1JS6yzE0qhs14Y47t9csWLXFkmwShhorJ2antPqGjXq4001fVj6TnR');

$token = $_POST['stripeToken'];
$amount = 1000; // Amount in cents

try {
  $charge = \Stripe\Charge::create(
    array(
      'amount' => $amount,
      'currency' => 'usd',
      'source' => $token,
      'description' => 'Example charge'
    )
  );
  echo "Payment Successful";
} catch (\Stripe\Exception\CardException $e) {
  // Card was declined
  echo $e->getError()->message;
} catch (\Stripe\Exception\RateLimitException $e) {
  echo "Too many requests made to the API too quickly";
} catch (\Stripe\Exception\InvalidRequestException $e) {
  echo "Invalid parameters were supplied to Stripe's API";
} catch (\Stripe\Exception\AuthenticationException $e) {
  echo "Authentication with Stripe's API failed";
} catch (\Stripe\Exception\ApiConnectionException $e) {
  echo "Network communication with Stripe failed";
} catch (\Stripe\Exception\ApiErrorException $e) {
  echo "Display a very generic error to the user, and maybe send yourself an email";
} catch (Exception $e) {
  echo "Something went wrong";
}

