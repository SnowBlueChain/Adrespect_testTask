<h2>Exchange Rates</h2>
<table>
  <thead>
    <tr>
      <th>Currency Code</th>
      <th>Rate</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $stmt = $db->prepare("SELECT * FROM exchange_rates");
    $stmt->execute();
    $exchangeRates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($exchangeRates as $exchangeRate) {
      echo '<tr>';
      echo '<td>' . $exchangeRate['currency_code'] . '</td>';
      echo '<td>' . $exchangeRate['rate'] . '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
