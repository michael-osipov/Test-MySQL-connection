<?php
    require_once 'parts_php/conn.php';

    // Обычные функции
    function show_header() {
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body>';
    }
    function show_footer() {
        echo '</body></html>';
    }


    function db_write() {
        global $pdo;

        $sql = 'INSERT into test (test_text) VALUES (?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([ '1' ]);
    }
    function db_select_last() {
        global $pdo;

        $sql = 'SELECT * FROM test ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function db_delete($result) {
        global $pdo;
        $delete_id = $result['id'];

        $sql = 'DELETE FROM test WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([ $delete_id ]);
    }
    function db_update($result) {
        global $pdo;
        $update_id = $result['id'];
        $update_text = bin2hex(random_bytes(8));

        $sql = "UPDATE test SET test_text = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([ $update_text, $update_id  ]);
        } catch (PDOException $e) {
            echo "Ошибка выполнения запроса: " . $e->getMessage();
        }
    }

    function display_result($result, $type_msg) {
        $result_id = $result['id'];
        $result_text = $result['test_text'];
        echo "$type_msg OK <br />";
        echo "ID: $result_id; TEXT: $result_text <br /><br />";
    }

    function show_test() {
        global $pdo;
        global $number_of_tests;

        $result = db_select_last();

        if (empty($result)) {
            echo 'DB is empty — SELECT OK';
            db_write();
        } 
        
        else {
            // WRITE
            echo 'WRITE OK <br /><br />';

            // SELECT
            $result = db_select_last();
            display_result($result, "SELECT");

            // DELETE
            $result = db_select_last();
            db_delete($result);

            $result = db_select_last();
            if (empty($result)) {
                echo "DELETE OK <br /><br />";
            }
            
            // WRITE
            db_write();

            $result = db_select_last();
            display_result($result, "WRITE");

            // UPDATE
            $result = db_select_last();
            db_update($result);

            $result = db_select_last();
            display_result($result, "UPDATE");
        } 
    }
    
    function init_tests() {
        show_header();
        show_test();
        show_footer();
    };