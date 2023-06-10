<h2>Conversion Results</h2>
<table>
  <thead>
    <tr>
      <th>Amount</th>
      <th>Source Currency</th>
      <th>Target Currency</th>
      <th>Converted Amount</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $stmt = $db->prepare("SELECT * FROM conversion_results ORDER BY date DESC");
    $stmt->execute();
    $conversionResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($conversionResults as $result) {
      echo '<tr>';
      echo '<td>' . $result['amount'] . '</td>';
      echo '<td>' . $result['source_currency'] . '</td>';
      echo '<td>' . $result['target_currency'] . '</td>';
      echo '<td>' . $result['converted_amount'] . '</td>';
      echo '<td>' . $result['date'] . '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
