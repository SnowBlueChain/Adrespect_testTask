<h2>Currency Conversion</h2>
<form method="post">
  <label for="amount">Amount:</label>
  <input type="text" name="amount" id="amount" required>
  <br>
  <label for="source_currency">Source Currency:</label>
  <select name="source_currency" id="source_currency" required>
    <?php
    $stmt = $db->prepare("SELECT currency_code FROM exchange_rates");
    $stmt->execute();
    $currencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($currencies as $currency) {
      echo '<option value="' . $currency['currency_code'] . '">' . $currency['currency_code'] . '</option>';
    }
    ?>
  </select>
  <br>
  <label for="target_currency">Target Currency:</label>
  <select name="target_currency" id="target_currency" required>
    <?php
    foreach ($currencies as $currency) {
      echo '<option value="' . $currency['currency_code'] . '">' . $currency['currency_code'] . '</option>';
    }
    ?>
  </select>
  <br>
  <input type="submit" name="submit" value="Convert">
</form>
