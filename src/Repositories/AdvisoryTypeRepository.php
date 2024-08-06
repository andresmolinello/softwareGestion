<?php

namespace App\Repositories;

use PDO;
use App\Models\AdvisoryType;

class AdvisoryTypeRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM advisoryType WHERE status= 1");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($row) {
            return new AdvisoryType($row['id'], $row['name'], $row['status']);
        }, $results);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM advisoryType WHERE id = ? AND status = 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AdvisoryType($row['id'], $row['name'], $row['status']);
        }
        return null;
    }

    public function create($data)
    {
        $guid = $this->generateGUID();
        $stmt = $this->pdo->prepare("INSERT INTO advisoryType (id, name, status) VALUES (?, ?, ?)");
        $stmt->execute([$guid, $data['name'], $data['status']]);
        return $this->getById($guid);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE advisoryType SET name = ?, status = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['status'], $id]);
        return $this->getById($id);
    }

    public function partialUpdate($id, $data)
    {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $query = "UPDATE advisoryType SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $this->getById($id);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("UPDATE advisoryType set status= 0 WHERE id = ?");
        $stmt->execute([$id]);
        return ['status' => 'deleted', 'id' => $id];
    }

    private function generateGUID()
    {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            mt_srand((double) microtime() * 10000); // optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
            return $uuid;
        }
    }
}
