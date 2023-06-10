<?php
require_once('config.php');
require_once('classes/ExchangeRateDownloader.php');
require_once('classes/CurrencyConverter.php');

// Download exchange rates from NBP API and save them to the database
$exchangeRateDownloader = new ExchangeRateDownloader($db);
$exchangeRateDownloader->downloadAndSaveExchangeRates();

// Get exchange rates from the database and display them in a table
include('templates/exchange_rates_table.php');

// Include the conversion form
include('templates/conversion_form.php');

// Execute the currency conversion code
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = $_POST['amount'];
  $sourceCurrency = $_POST['source_currency'];
  $targetCurrency = $_POST['target_currency'];

  // Convert the given amount from one currency to another using data from the database
  $currencyConverter = new CurrencyConverter($db);
  $convertedAmount = $currencyConverter->convertCurrency($amount, $sourceCurrency, $targetCurrency);

  // Save the results of currency conversions to the database
  $currencyConverter->saveConversionResult($amount, $sourceCurrency, $targetCurrency, $convertedAmount);

  // Get recent currency conversion results from the database and display them in a table
  include('templates/conversion_results_table.php');
}

// // Handle currency conversion form submission
// if (isset($_POST['submit'])) {
//   $amount = $_POST['amount'];
//   $sourceCurrency = $_POST['source_currency'];
//   $targetCurrency = $_POST['target_currency'];

//   // Convert the given amount from one currency to another using data from the database
//   $currencyConverter = new CurrencyConverter($db);
//   $convertedAmount = $currencyConverter->convertCurrency($amount, $sourceCurrency, $targetCurrency);

//   // Save the results of currency conversions to the database
//   $currencyConverter->saveConversionResult($amount, $sourceCurrency, $targetCurrency, $convertedAmount);

//   // Get recent currency conversion results from the database and display them in a table
//   include('templates/conversion_results_table.php');
// }
// else {
//   // Display the currency conversion form
//   include('templates/conversion_form.php');
// }
// ?>
