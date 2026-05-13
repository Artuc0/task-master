<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Task Master - Organizado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Task Master</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=create" class="form-group">
        <input type="text" name="title" placeholder="Título" required>
        <input type="text" name="description" placeholder="Descrição">
        <input type="date" name="due_date" required>
        <button type="submit">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?= $task['done'] ? 'done' : '' ?>">
                <div>
                    <strong><?= htmlspecialchars($task['title']) ?></strong>
                    <?php if (!empty($task['description'])): ?>
                        <p><?= htmlspecialchars($task['description']) ?></p>
                    <?php endif; ?>
                    <small>Vence em: <?= htmlspecialchars($task['due_date']) ?></small>
                </div>
                <div class="actions">
                    <?php if (!$task['done']): ?>
                        <a href="index.php?action=complete&id=<?= $task['id'] ?>">✅</a>
                    <?php endif; ?>
                    <a href="index.php?action=delete&id=<?= $task['id'] ?>" onclick="return confirm('Excluir?')">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>