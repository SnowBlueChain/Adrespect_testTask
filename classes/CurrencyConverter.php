<?php
class CurrencyConverter {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  // Convert the given amount from one currency to another using data from the database
  public function convertCurrency($amount, $sourceCurrency, $targetCurrency) {
    $stmt = $this->db->prepare("SELECT rate FROM exchange_rates WHERE currency_code = :source_currency OR currency_code = :target_currency");
    $stmt->bindParam(':source_currency', $sourceCurrency);
    $stmt->bindParam(':target_currency', $targetCurrency);
    $stmt->execute();
    $rates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rates) != 2) {
      throw new Exception('Exchange rates not found.');
    }

    $rate1 = $rates[0]['rate'];
    $rate2 = $rates[1]['rate'];

    if ($sourceCurrency == 'PLN') {
      $convertedAmount = $amount / $rate2;
    } elseif ($targetCurrency == 'PLN') {
      $convertedAmount = $amount * $rate1;
    } else {
      $convertedAmount = $amount * $rate1 / $rate2;
    }

    return number_format($convertedAmount, 2, '.', '');
  }

  // Save the results of currency conversions to the database
  public function saveConversionResult($amount, $sourceCurrency, $targetCurrency, $convertedAmount) {
    $stmt = $this->db->prepare("INSERT INTO conversion_results (amount, source_currency, target_currency, converted_amount) VALUES (:amount, :source_currency, :target_currency, :converted_amount)");
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':source_currency', $sourceCurrency);
    $stmt->bindParam(':target_currency', $targetCurrency);
    $stmt->bindParam(':converted_amount', $convertedAmount);
    $stmt->execute();
  }
}
?>
