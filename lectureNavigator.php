<?php
    // Requirements
    require_once ('config/constants.php');
    require_once ('src/classes/LectureManager.php');
    $lectureManager = new LectureManager();
    $currentLecture = isset($_GET['l']) && !empty($_GET['l']) ? $_GET['l'] : '1.1';
    $lectures = $lectureManager->getLectures();
    $currentLectureIndex = array_search($currentLecture, array_keys($lectures));
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            :root {
                --main-blue-color: #4d87e4;
            }
            body, nav {
                width: 100%;
                text-align: center;
                overflow: hidden;
                font-family: "Segoe UI";
            }
            nav, main, menu { display: inline-block; }
            main { padding-left: 13%; }
            select, input, button { font-family: "Segoe UI";  border-radius: 40px; border: 1px solid var(--main-blue-color); cursor: pointer; transition: linear 0.1s; }
            menu { position: absolute; right: 0; margin: 0;  cursor: pointer; }
            menu i { color: var(--main-blue-color); transition: linear 0.1s; }
            menu i:hover { transform: scale(1.2); }
            select {
                text-align: center;
                font-weight: bold;
                color: white;
                background-color: var(--main-blue-color);
                margin: 0 5px;
            }
            button {
                color: var(--main-blue-color);
                background-color: white;
            }
            select:hover,  select:focus {
                color: var(--main-blue-color);
                border: 1px solid var(--main-blue-color);
                background-color: white;
            }
            button:hover, button:focus {
                color: white;
                border: 1px solid var(--main-blue-color);
                background-color: var(--main-blue-color);
            }
            .pre-title { color: var(--main-blue-color); font-weight: bold; }
            .prev-lecture, .next-lecture { position: absolute; margin: 0 50px; }
            .prev-lecture { right: 2%; }
            .next-lecture { left: 2%; }
        </style>
    </head>
    <body dir="rtl">
        <nav>
            <menu><span onclick="goToManagementPage()" title="Manage Lectures"><i class="fa fa-cog"></i></span></menu>
            <?php
                if ($currentLectureIndex > 0) {
                    echo '<button class="prev-lecture" title="להרצאה הקודמת" onclick="prevLecture()">< להרצאה הקודמת</button>';
                }
            ?>
            <span>
                <span class="pre-title">הרצאה:</span>
                <select onchange="goToLecture()">
                <?php
                    $options = '';
                    foreach($lectures as $lectureNumber => $lectureDetails) {
                        $selected = $lectureNumber === $currentLecture ? 'selected' : '';
                        $options .= "<option {$selected} value='{$lectureNumber}'>{$lectureNumber}: {$lectures[$lectureNumber]['description']}</option>";
                    }
                    echo $options;
                ?>
                </select>
            </span>
            <?php
                if ($currentLectureIndex !== count($lectures) - 1) {
                    echo '<button class="next-lecture" title="להרצאה הבאה" onclick="nextLecture()">להרצאה הבאה ></button>';
                }
            ?>
        </nav>
        <script>
            var select = document.getElementsByTagName('select')[0];
            var lecturesNumbers ="<?php echo implode(',', array_keys($lectures)); ?>".split(',');
            var currentLectureIndex = lecturesNumbers.indexOf(select.value);

            function goToManagementPage() {
                parent.document.location = 'http://localhost/bgu/lectures/lecturesmanagement.php';
            }
            function goToLecture() {
                parent.document.location = 'http://localhost/bgu/lectures/index.php?l=' + select.value;
            }

            function prevLecture() {
                select.value = lecturesNumbers[currentLectureIndex - 1];
                goToLecture();
            }

            function nextLecture() {
                select.value = lecturesNumbers[currentLectureIndex + 1];
                goToLecture();
            }
        </script>
    </body>
</html>
