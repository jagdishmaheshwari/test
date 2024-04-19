<?php
require_once 'conn.php'; // Include the Database class

class DB extends Database
{

    public function insert($table, $data)
    {
        $conn = parent::getConnection();

        // Validate table name and data
        if (empty($table) || !is_array($data) || empty($data)) {
            throw new InvalidArgumentException('Invalid table name or data.');
        }

        // Build the SQL query
        $columns = implode(", ", array_keys($data));
        $placeholders = str_repeat("?, ", count($data) - 1) . "?";
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        // Prepare and execute the SQL query using prepared statements
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('Failed to prepare statement: ' . $conn->error);
        }

        $types = str_repeat("s", count($data)); // Assuming all values are strings
        $stmt->bind_param($types, ...array_values($data));

        $stmt->execute();
        if ($stmt->error) {
            throw new RuntimeException('Failed to execute statement: ' . $stmt->error);
        }

        $stmt->close();
        // Consider closing connection based on application logic
        // parent::closeConnection();
    }

    public function get($table, $conditions = [])
    {
        $conn = parent::getConnection();
        if (empty($table) || !is_array($conditions)) {
            throw new InvalidArgumentException('Invalid table name or conditions.');
        }

        $sql = "SELECT * FROM $table";
        $params = []; // Array to store prepared statement parameters

        if (!empty($conditions)) {
            $sql .= " WHERE ";

            $whereConditions = [];
            foreach ($conditions as $column => $value) {
                $whereConditions[] = "$column = ?";
                $params[] = $value;
            }

            $sql .= implode(" AND ", $whereConditions);
        }
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('Failed to prepare statement: ' . $conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat("s", count($params)); // Assuming all values are strings
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        if ($stmt->error) {
            throw new RuntimeException('Failed to execute statement: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        // parent::closeConnection();

        return $rows;
    }

    public function update($table, $data, $conditions = [])
    {
        $conn = parent::getConnection();

        if (empty($table) || !is_array($data) || empty($data)) {
            throw new InvalidArgumentException('Invalid table name or data.');
        }

        $setValues = [];
        foreach ($data as $key => $value) {
            $setValues[] = "$key = ?";
        }
        $setClause = implode(", ", $setValues);

        $sql = "UPDATE $table SET $setClause";

        $whereConditions = [];
        foreach ($conditions as $field => $value) {
            $whereConditions[] = "$field = ?";
        }
        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('Failed to prepare statement: ' . $conn->error);
        }

        $types = str_repeat("s", count($data) + count($conditions));
        $bindParams = array_merge(array_values($data), array_values($conditions));
        $stmt->bind_param($types, ...$bindParams);

        $stmt->execute();
        if ($stmt->error) {
            throw new RuntimeException('Failed to execute statement: ' . $stmt->error);
        }

        $stmt->close();

        return $stmt->affected_rows;
    }


    public function delete($table, $conditions = [])
    {
        $conn = parent::getConnection();
        if (empty($table)) {
            throw new InvalidArgumentException('Invalid table name.');
        }
        $sql = "DELETE FROM $table";
        $whereConditions = [];
        foreach ($conditions as $field => $value) {
            $whereConditions[] = "$field = ?";
        }
        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('Failed to prepare statement: ' . $conn->error);
        }
        if (!empty($conditions)) {
            $types = str_repeat("s", count($conditions));
            $stmt->bind_param($types, ...array_values($conditions));
        }
        $stmt->execute();
        if ($stmt->error) {
            throw new RuntimeException('Failed to execute statement: ' . $stmt->error);
        }
        $stmt->close();
        return $stmt->affected_rows;
    }
}

if (!function_exists('prd')) {
    function prd($a)
    {
        echo "<pre>";
        if (is_array($a)) {
            print_r($a);
        } else {
            echo $a;
        }
        echo "</pre>";
        die();
    }
}

?>