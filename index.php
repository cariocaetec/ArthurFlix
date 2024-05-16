<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas do Arthur</title>
    <link rel="shortcut icon" type="imagex/png" href="https://static.vecteezy.com/system/resources/previews/019/956/195/original/netflix-transparent-netflix-free-free-png.png">
</head>
<body>
    <div class="container">
        <h2>Reserve seu lugar para o evento:</h2>

        <?php
        function lerReservas() {
            $reservas = [];
            $arquivo = fopen("reservas.txt", "r");
            if ($arquivo) {
                while (($linha = fgets($arquivo)) !== false) {
                    $dados = explode(",", $linha);
                    $reservas[intval($dados[0])] = trim($dados[1]);
                }
                fclose($arquivo);
            }
            return $reservas;
        }

        function salvarReserva($lugar, $nome_cliente) {
            $arquivo = fopen("reservas.txt", "a");
            fwrite($arquivo, "$lugar,$nome_cliente\n");
            fclose($arquivo);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fileira = $_POST["fileira"];
            $coluna = $_POST["coluna"];
            $nome_cliente = $_POST["nome"];

            if ($fileira >= 0 && $fileira < 5 && $coluna >= 0 && $coluna < 10) {
                $lugar_escolhido = $fileira * 10 + $coluna;
                $reservas = lerReservas();
                if (!isset($reservas[$lugar_escolhido])) {
                    salvarReserva($lugar_escolhido, $nome_cliente);
                    echo "<p>Lugar reservado com sucesso para $nome_cliente!</p>";
                } else {
                    echo "<p>O lugar selecionado já está reservado. Por favor, escolha outro lugar.</p>";
                }
            } else {
                echo "<p>Por favor, escolha uma fileira e coluna válidas.</p>";
            }
        }

        echo "<form method='post'>";
        echo "Fileira: <input type='number' name='fileira' min='0' max='4' required>";
        echo " Coluna: <input type='number' name='coluna' min='0' max='9' required>";
        echo " Seu nome: <input type='text' name='nome' required>";
        echo "<button type='submit'>Reservar Lugar</button>";
        echo "</form>";

        echo "<h3>Lugares Reservados:</h3>";
        echo "<table>";
        echo "<thead><tr><th></th>";
        for ($j = 0; $j < 10; $j++) {
            echo "<th>$j</th>";
        }
        echo "</tr></thead>";
        echo "<tbody>";
        $reservas = lerReservas();
        for ($i = 0; $i < 5; $i++) {
            echo "<tr>";
            echo "<th>$i</th>";
            for ($j = 0; $j < 10; $j++) {
                $num_lugar = $i * 10 + $j;
                echo "<td class='" . (isset($reservas[$num_lugar]) ? "assento-ocupado" : "assento-livre") . "'>";
                if (isset($reservas[$num_lugar])) {
                    echo $reservas[$num_lugar];
                } else {
                    echo "Livre";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        ?>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            text-align: center;
        }

        input[type="number"], input[type="text"], button {
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
        }

        input[type="number"], input[type="text"] {
            width: 80px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table td {
            width: 50px;
            height: 50px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .assento-livre {
            background-color: #8bc34a;
        }

        .assento-ocupado {
            background-color: #f44336;
        }

        .row-numbers {
            text-align: center;
        }

        .row-numbers th {
            font-weight: bold;
            padding: 5px;
        }
    </style>
</body>
</html>
