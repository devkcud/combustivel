<?php
require_once 'db.php';
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

            if ($row['idAbastecimento'] === $_GET['id']) {
              echo "<a class='abastecimento selected'>$nome | Valor abastecido: R$$valor</a>";
            } else {
              echo "<a href='view.php?id=" . $row['idAbastecimento'] . "' class='abastecimento'>$nome | Valor abastecido: R$$valor</a>";
            }
          }
        } else {
          echo "<p>Seu histórico está<br>vazio</p>";
        }
        ?>
      </section>

      <?php
      if ($result->num_rows === 0) {
        echo "<a class='invisible add-more'>Adicionar mais</a>";
      } else {
        echo "<a href='add.php' class='add-more'>Adicionar mais</a>";
      }
      ?>
    </aside>

    <main>
      <section class="view">
        <?php
        $id = $_GET['id'];

        $stmt = $con->prepare("SELECT * FROM Abastecimento WHERE idAbastecimento = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
          $data = date("d/m/Y", strtotime($row['data']));

          echo "<span>Nome: " . $row['nome'] . "</span>";
          echo "<span>Data do abastecimento: " . $data . "</span>";
          echo "<span>Valor do abastecimento: " . $row['valor'] . "</span>";
          echo "<span>Litros abastecidos: " . $row['litros'] . "</span>";
        }

        $stmt->close();
        $result->free();
        ?>
      </section>
    </main>
  </body>
</html>
