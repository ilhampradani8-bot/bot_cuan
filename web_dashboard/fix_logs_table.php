<?php
// FILE: web_dashboard/fix_logs_table.php (v2)
// One-time script to fix the user_logs table by adding the missing 'timestamp' column.

echo "<pre>"; 

require_once __DIR__ . '/components/database.php';

try {
    echo "⚙️  Attempting to add 'timestamp' column to 'user_logs' table...\n";

    // SQLite compliant: Add the column without a non-constant default value.
    $sql = "ALTER TABLE user_logs ADD COLUMN timestamp DATETIME";

    $pdo->exec($sql);

    echo "✅  SUCCESS!\n";
    echo "Column 'timestamp' was added successfully.\n\n";
    echo "You can now delete this file (fix_logs_table.php).";

} catch (PDOException $e) {
    if (str_contains($e->getMessage(), 'duplicate column name')) {
        echo "✅  INFO:\n";
        echo "The column 'timestamp' already exists. No action was needed.\n\n";
        echo "You can now delete this file (fix_logs_table.php).";
    } else {
        echo "❌  ERROR:\n";
        echo "An unexpected database error occurred: " . $e->getMessage();
    }
}

echo "</pre>";
?>
