<?php

    use app\core\Application;

    class m0001_initial {

        public function up () {

            $database = Application::$app->database;
            $database->pdo->exec(
                'CREATE TABLE Users (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              email VARCHAR(255) NOT NULL,
                              firstname VARCHAR(255) NOT NULL,
                              lastname VARCHAR(255) NOT NULL,
                              password VARCHAR(255) NOT NULL,
                              status TINYINT NOT NULL,
                              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                           )ENGINE=InnoDB AUTO_INCREMENT=1000001 DEFAULT CHARSET="utf8mb4" COLLATE="utf8mb4_bin" '
            );
        }

        public function down () {
            $database = Application::$app->database;
            $database->pdo->exec(
                'DROP TABLE Users; '
            );
        }

    }