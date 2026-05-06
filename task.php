<?php
class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->createTable();
    }

    private function createTable() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            done INTEGER DEFAULT 0
        )");
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM tasks ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($title) {
        if (empty(trim($title))) return "O título não pode ser vazio!";
        
        $stmt = $this->pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->execute([':title' => $title]);
        return true;
    }

    public function toggleDone($id) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET done = 1 WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}