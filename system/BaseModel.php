<?php

declare(strict_types=1);

namespace System;

use PDO;

class BaseModel extends Conexao
{
    protected string $table;

    protected array $fields;

    private Object $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::conn();
    }

    // Create
    protected function create(array $data): bool
    {
        $data = $this->fill($data);

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        return $stmt->execute();
    }

    // Read
    protected function read(array $conditions = []): array
    {
        $sql = "SELECT * FROM $this->table";
        if ($conditions) {
            $sql .= " WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($conditions as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update
    protected function update(array $data, array $conditions): bool
    {
        $set = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $where = implode(' AND ', array_map(function ($key) {
            return "$key = :cond_$key";
        }, array_keys($conditions)));

        $sql = "UPDATE $this->table SET $set WHERE $where";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        foreach ($conditions as $key => &$value) {
            $stmt->bindParam(":cond_$key", $value);
        }

        return $stmt->execute();
    }

    // Delete
    protected function delete(array $conditions): bool
    {
        $where = implode(' AND ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($conditions)));

        $sql = "DELETE FROM $this->table WHERE $where";

        $stmt = $this->pdo->prepare($sql);

        foreach ($conditions as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        return $stmt->execute();
    }

    /**
     * $sql = "SELECT * FROM users WHERE age = :age and name = :name";
     * $where = [
     *  'age' => 20,
     *  'age' => 'josé'
     * ]
     */
    protected function query($sql, $where = [])
    {
        $stmt = $this->pdo->prepare($sql);

        foreach ($where as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function fill(array $assocArray): array {

        $keys = $this->fields;
        $result = [];
    
        foreach ($keys as $key) {
            if (array_key_exists($key, $assocArray)) {
                $result[$key] = $assocArray[$key];
            }
        }
    
        return $result;
    }
}
