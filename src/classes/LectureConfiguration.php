<?php

require_once DB_CONF_PATH . '/MySqlConnector.php';

class LectureConfiguration {
    private const LECTURES_TABLE = 'embedded_lectures';

    /**
     * LectureConfiguration constructor.
     */
    public function __construct() {

    }

    public static function getEmbeddedLecturesURLs() {
        $query = "SELECT * FROM " . self::LECTURES_TABLE;
        return MySqlConnector::query($query);
    }

}