<?php
class ExchangeRateDownloader {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  // Download exchange rates from NBP API and save them to the database
  public function downloadAndSaveExchangeRates() {
    $stmt = $this->db->prepare("TRUNCATE TABLE exchange_rates");
    $stmt->execute();  

    // Prepare the URL to download exchange rates
    $url = "https://api.nbp.pl/api/exchangerates/tables/A?format=json";
    
    // Make the API request and parse the JSON response
    $exchangeRatesJson = file_get_contents($url);
    $exchangeRatesArray = json_decode($exchangeRatesJson, true);

    // Extract the exchange rates and save them to the database
    foreach ($exchangeRatesArray[0]['rates'] as $rate) {
      $currencyCode = $rate['code'];
      $rateValue = $rate['mid'];

      $stmt = $this->db->prepare("INSERT INTO exchange_rates (currency_code, rate) VALUES (:currency_code, :rate)");
      $stmt->bindParam(':currency_code', $currencyCode);
      $stmt->bindParam(':rate', $rateValue);
      $stmt->execute();
    }
  }
}
?>
