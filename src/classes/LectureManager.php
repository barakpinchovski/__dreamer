<?php

// Requirements
require_once ('LectureConfiguration.php');

class LectureManager {
    private const LECTURE_SELECTOR = "src/pages/lectureSelector.php";
    private $lectures = [];

    /**
     * LectureManager constructor.
     */
    public function __construct() {
        $this->initLectures();
    }

    private function initLectures() {
        if ($embeddedLectures = LectureConfiguration::getEmbeddedLecturesURLs()) {
            while ($lecture = mysqli_fetch_assoc($embeddedLectures)) {
                $this->lectures[$lecture['number']] = [
                    'id' => $lecture['id'],
                    'description' => $lecture['description'],
                    'url' => $lecture['url'],
                    'css' => isset($lecture['css']) ? $lecture['css'] : NULL,
                    'js' => isset($lecture['js']) ? $lecture['js'] : NULL
                ];
            }
        }

    }

    public function getLectures($id = NULL) {
         return empty($id) ? $this->lectures : $this->lectures[$id];
     }

     public static function getLectureSelectorConst() {
        return self::LECTURE_SELECTOR;
     }
}