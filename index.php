<?php

class index {

    /**
     * index constructor.
     */
    public function __construct() {
        $lectureSelector = LectureManager::getLectureSelectorConst();
        require_once ($lectureSelector);
    }
}

// Requirements
require_once ('config/constants.php');
require_once ('src/classes/LectureManager.php');

new index();