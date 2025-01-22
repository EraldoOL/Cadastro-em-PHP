<?php
require_once 'functions.php';

$message = "";
$action = 'insert';  // Ação padrão para inserção de novos corretores
$buttonText = 'Enviar';  // Texto do botão padrão

// Variáveis para preencher o formulário
$name = '';
$cpf = '';
$creci = '';

// Verificar se estamos editando um corretor
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    
    // Buscar os dados do corretor no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM corretores WHERE id = ?");
    $stmt->execute([$id]);
    $corretor = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($corretor) {
        $name = $corretor['name'];
        $cpf = $corretor['cpf'];
        $creci = $corretor['creci'];
        $action = 'update';
        $buttonText = 'Salvar';
    } else {
        $message = "Corretor não encontrado!";
    }
}

// Processar o envio do formulário (inserção ou atualização)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $creci = $_POST['creci'];

    if (strlen($cpf) === 11 && strlen($name) >= 2 && strlen($creci) >= 2) {
        if ($action == 'update') {
            // Atualizar o corretor
            if (atualizarCorretor($id, $name, $cpf, $creci)) {
                $message = "Corretor atualizado com sucesso!";
            } else {
                $message = "Erro ao atualizar corretor.";
            }
        } else {
            // Inserir um novo corretor
            if (inserirCorretor($name, $cpf, $creci)) {
                $message = "Corretor cadastrado com sucesso!";
            } else {
                $message = "Erro ao cadastrar corretor.";
            }
        }
    } else {
        $message = "Por favor, preencha os campos corretamente.";
    }
}

// Verificar se estamos excluindo um corretor
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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Corretores</h1>
        
        <!-- Formulário de cadastro/edição -->
        <form action="index.php" method="POST">
    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" maxlength="11" value="<?= htmlspecialchars($cpf) ?>" required>
    </div>
    <div class="form-group">
        <label for="creci">Creci:</label>
        <input type="text" id="creci" name="creci" minlength="2" value="<?= htmlspecialchars($creci) ?>" required>
    </div>
    
    <!-- Campo de nome, sem alterações -->
    <div class="form-group">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" minlength="2" value="<?= htmlspecialchars($name) ?>" required>
    </div>
    <button type="submit"><?= $buttonText ?></button>
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
                    <th>CRECI</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Buscar os dados dos corretores no banco
                $stmt = $pdo->query("SELECT * FROM corretores");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['cpf'] . "</td>";
                    echo "<td>" . $row['creci'] . "</td>";
                    echo "<td>
                        <a href='?edit=" . $row['id'] . "'>Editar</a> | 
                        <a href='?delete=" . $row['id'] . "'>Excluir</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>