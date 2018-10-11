<?php
    require_once 'databaseConfig.php';

    class MySqlConnector {
        private static $con;

        public static function connect() {
            self::$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if (mysqli_connect_errno()) {
                echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
                die();
            }
            return self::$con ;
        }

        public static function disconnect() {
            mysqli_close(self::$con);
        }

        public static function query($query) {
            self::connect();
            $dataSet = mysqli_query(self::$con, $query);
            self::disconnect();
            return $dataSet;
        }
    }