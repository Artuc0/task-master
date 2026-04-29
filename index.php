<?php
// ==========================================
// AULA 01: O CÓDIGO SPAGHETTI (Tudo misturado)
// ==========================================

// 1. CONEXÃO COM O BANCO DE DADOS E CRIAÇÃO DA TABELA (Acoplamento de Infraestrutura)
$dbFile = __DIR__ . '/tasks.sqlite';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    done INTEGER DEFAULT 0
)");

// 2. LÓGICA DE NEGÓCIO E CONTROLE DE REQUISIÇÕES MISTURADOS
$error = '';

// Criar nova tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    
    // TODO: Regra de negócio solta no meio do arquivo
    if (empty($title)) {
        $error = "O título da tarefa não pode estar vazio!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->bindValue(':title', $title);
        $stmt->execute();
        
        // TODO: Redirecionamento misturado com a lógica
        header("Location: index.php");
        exit;
    }
}

// Concluir ou excluir tarefa
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    if ($_GET['action'] === 'complete') {
        $pdo->exec("UPDATE tasks SET done = 1 WHERE id = $id");
    } elseif ($_GET['action'] === 'delete') {
        $pdo->exec("DELETE FROM tasks WHERE id = $id");
    }
    
    header("Location: index.php");
    exit;
}

// 3. BUSCA DE DADOS MISTURADA COM A VISUALIZAÇÃO
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Master - Spaghetti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Task Master (Spaghetti Edition)</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php" class="form-group">
        <input type="text" name="title" placeholder="O que precisa ser feito?" autocomplete="off">
        <button type="submit">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?php echo $task['done'] ? 'done' : ''; ?>">
                <span><?php echo htmlspecialchars($task['title']); ?></span>
                
                <div class="actions">
                    <?php if (!$task['done']): ?>
                        <a href="?action=complete&id=<?php echo $task['id']; ?>" title="Concluir">✅</a>
                    <?php endif; ?>
                    <a href="?action=delete&id=<?php echo $task['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');" title="Excluir">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>