<?php
require_once 'functions.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $creci = $_POST['creci'];

    if (strlen($cpf) === 11 && strlen($name) >= 2 && strlen($creci) >= 2) {
        if (inserirCorretor($name, $cpf, $creci)) {
            $message = "Corretor cadastrado com sucesso!";
        } else {
            $message = "Erro ao cadastrar corretor.";
        }
    } else {
        $message = "Por favor, preencha os campos corretamente.";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (excluirCorretor($id)) {
        $message = "Corretor excluído com sucesso!";
    } else {
        $message = "Erro ao excluir corretor.";
    }
}

$corretores = buscarCorretores();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Corretores</h1>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="11" required>
            </div>
            <div class="form-group">
                <label for="creci">Creci:</label>
                <input type="text" id="creci" name="creci" minlength="2" required>
            </div>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" minlength="2" required>
            </div>
            <button type="submit">Enviar</button>
        </form>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <h2>Lista de Corretores</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Creci</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($corretores as $corretor): ?>
                    <tr>
                        <td><?= $corretor['id'] ?></td>
                        <td><?= htmlspecialchars($corretor['name']) ?></td>
                        <td><?= htmlspecialchars($corretor['cpf']) ?></td>
                        <td><?= htmlspecialchars($corretor['creci']) ?></td>
                        <td>
                            <a href="index.php?delete=<?= $corretor['id'] ?>" class="delete">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>