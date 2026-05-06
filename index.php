<?php
require_once 'Task.php';

$pdo = new PDO('sqlite:' . __DIR__ . '/tasks.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$taskModel = new Task($pdo);
$error = '';

// Processamento de Ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $taskModel->add($_POST['title'] ?? '');
    if ($result !== true) $error = $result;
    else header("Location: index.php");
}

if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'complete') $taskModel->toggleDone($id);
    if ($_GET['action'] === 'delete') $taskModel->delete($id);
    header("Location: index.php");
}

$tasks = $taskModel->getAll();

// Agora chamamos a View (a parte visual)
include 'tasks-view.php';