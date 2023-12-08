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

            echo "<a href='view.php?id=" . $row['idAbastecimento'] . "' class='abastecimento'>$nome | Valor abastecido: R$$valor</a>";
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
      <form action="index.php" id="add" onsubmit="return showConfirmationDialog()">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="date" name="data" placeholder="Data do abastecimento" required>
        <input type="number" step="0.01" name="valor" placeholder="Valor do abastecimento" required>
        <input type="number" step="0.001" name="litros" placeholder="Litros abastecidos" required>

        <button type="submit" class="btn smol invert">Salvar</button>
      </form>

      <dialog id="confirmationDialog">
        <div>
          <h2>Confirme os dados</h2>
          <ul id="confirmationList"></ul>
          <button class="alterar" onclick="closeDialog()">Alterar</button>
          <button class="confirmar" onclick="submitForm()">Confirmar</button>
        </div>
      </dialog>

      <script>
        function showConfirmationDialog() {
          var nome = document.getElementsByName('nome')[0].value;
          var data = document.getElementsByName('data')[0].value;
          var valor = document.getElementsByName('valor')[0].value;
          var litros = document.getElementsByName('litros')[0].value;

          var list = document.getElementById('confirmationList');
          list.innerHTML = "<li>Nome: <span class='value'>" + nome + "</span></li>" +
                            "<li>Data do abastecimento: <span class='value'>" + data + "</span></li>" +
                            "<li>Valor do abastecimento: <span class='value'>" + valor + "</span></li>" +
                            "<li>Litros abastecidos: <span class='value'>" + litros + "</span></li>";

          var dialog = document.getElementById('confirmationDialog');
          dialog.showModal();
          return false;
        }

        function closeDialog() {
          var dialog = document.getElementById('confirmationDialog');
          dialog.close();
        }

        function submitForm() {
          var form = document.getElementById('add');
          form.submit();
        }
      </script>
    </main>
  </body>
</html>
