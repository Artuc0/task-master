<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Task Master - Organizado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Task Master (Clean Edition)</h1>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="title" placeholder="O que precisa ser feito?">
            <button type="submit">Adicionar</button>
        </form>

        <ul>
            <?php foreach ($tasks as $task): ?>
                <li class="<?= $task['done'] ? 'done' : '' ?>">
                    <span><?= htmlspecialchars($task['title']) ?></span>
                    <div class="actions">
                        <a href="?action=complete&id=<?= $task['id'] ?>">✅</a>
                        <a href="?action=delete&id=<?= $task['id'] ?>" onclick="return confirm('Excluir?')">❌</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>