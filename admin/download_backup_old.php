<?php
include ('../conn.php');
function exportDatabaseStructureWithData($conn)
{
    $databaseName = $conn->query('SELECT DATABASE()')->fetch_row()[0];

    // Initialize the output string
    $output = '';

    // Get table names in the database
    $tablesResult = $conn->query("SHOW TABLES");
    while ($tableRow = $tablesResult->fetch_row()) {
        $tableName = $tableRow[0];

        // Get table structure
        $output .= "-- Table structure for table `$tableName` --\n";
        $output .= "CREATE TABLE IF NOT EXISTS `$tableName` (\n";

        // Get table columns
        $columnsResult = $conn->query("SHOW COLUMNS FROM $tableName");
        $fields = [];
        $autoIncrementField = null;
        while ($columnRow = $columnsResult->fetch_assoc()) {
            $field = $columnRow['Field'];
            $type = $columnRow['Type'];
            $null = $columnRow['Null'] == 'NO' ? 'NOT NULL' : 'NULL';
            $default = isset($columnRow['Default']) ? "DEFAULT {$columnRow['Default']}" : '';
            $extra = $columnRow['Extra'];

            // Check if column is auto-increment
            if ($extra === 'auto_increment') {
                $autoIncrementField = $field;
                $fields[] = "`$field` $type NOT NULL AUTO_INCREMENT";
            } else {
                $fields[] = "`$field` $type $null $default";
            }
        }

        // If an auto-increment field was found, define it as part of the primary key
        if ($autoIncrementField !== null) {
            $fields[] = "PRIMARY KEY (`$autoIncrementField`)";
        }

        $output .= implode(",\n", $fields);
        $output .= "\n);\n\n";

        // Get data for the table
        $dataResult = $conn->query("SELECT * FROM $tableName");
        if ($dataResult->num_rows > 0) {
            $output .= "-- Data for table `$tableName` --\n";
            while ($row = $dataResult->fetch_assoc()) {
                $values = [];
                foreach ($row as $key => $value) {
                    $values[] = "'" . $conn->real_escape_string($value) . "'";
                }
                $output .= "INSERT INTO `$tableName` VALUES (" . implode(', ', $values) . ");\n";
            }
            $output .= "\n";
        }
    }

    // Generate a filename for the exported structure
    $filename = 'database_structure_with_data_' . $databaseName . '_' . date('Y_m_d_H_i_s') . '.sql';

    // Set headers for file download
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"$filename\"");

    // Output the content
    echo $output;
}
exportDatabaseStructureWithData($conn);
?>