<?php
require_once 'db.php';

if (isset($_GET['nome']) && isset($_GET['data']) && isset($_GET['valor']) && isset($_GET['litros'])) {
  $nome = $_GET['nome'];
  $data = $_GET['data'];
  $valor = $_GET['valor'];
  $litros = $_GET['litros'];

  $sql = "INSERT INTO Abastecimento (nome, data, valor, litros) VALUES ('$nome', '$data', '$valor', '$litros')";

  if ($con->query($sql) === TRUE) {
    header("Location: index.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Combustível</title>

    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <aside>
      <h1>Supply history</h1>

      <section id="history">
        <?php
        $sql = "SELECT * FROM Abastecimento ORDER BY Abastecimento.data DESC";
        $result = $con->query($sql);

        $currentDate = null;

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $abastecimentoDate = date("d/m/Y", strtotime($row['data']));
            $todayDate = date("d/m/Y");

            if ($abastecimentoDate == $todayDate) {
              $abastecimentoDate = "Hoje";
            }

            if ($currentDate != $abastecimentoDate) {
              echo "<h2>$abastecimentoDate</h2>";
              $currentDate = $abastecimentoDate;
            }

            $nome = $row['nome'];
            $valor = $row['valor'];

            echo "<a href='view.php?id=" . $row['idAbastecimento'] . "' class='abastecimento'>$nome | Valor abastecido: R$$valor</a>";
          }
        } else {
          echo "<p>Seu histórico está<br>vazio</p>";
        }
        ?>
      </section>

      <a class='invisible add-more'>..</a>
    </aside>

    <main>
      <section id="start">
        <p>Iniciar histórico de<br>combustível</p>

        <a href="add.php" class="btn">Iniciar</a>
      </section>
    </main>
  </body>
</html>
