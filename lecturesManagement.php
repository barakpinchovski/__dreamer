<?php

// Requirements
require_once ('config/constants.php');
require_once ('config/database/MySqlConnector.php');
require_once ('src/classes/LectureManager.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lectures Management</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <meta charset="UTF-8"/>
    <style>
        body {
            font-family: "Segoe UI";
        }
        input {
            cursor: pointer;
            font-family: "Segoe UI";
            margin: 5px 5px 5px 0;
            border-radius: 5px;
            height: 32px;
            border: 1px solid #b3b3b3;
            font-size: 18px;
            padding: 5px 15px;
            transition: linear 0.1s;
        }
        input:hover, input:focus {
            border: 1px solid #3683ff;
            background-color: rgba(175, 229, 255, 0.2);
        }
        input.url {
            width: 900px;
        }
        input.description {
            direction: rtl;
        }
        button {
            cursor: pointer;
            font-family: "Segoe UI";
            border-radius: 40px;
            padding: 10px 20px;
            margin: 10px;
            border: 1px solid white;
            color: white;
            background-color: #3683ff;
            font-size: 18px;
            transition: linear 0.1s;
        }
        button:hover {
            color: #3683ff;
            border: 1px solid #3683ff;
            background-color: white;
        }
        input[type="checkbox"] + label { cursor: pointer; }
        input[type="checkbox"]:checked +label .fa-css3-alt { color: #3683ff; }
        input[type="checkbox"]:checked +label .fa-js-square { color: orangered; }
        .css-checkbox i, .js-checkbox i { color: darkgray; margin: 5px;  }
        legend {
            font-size: 20px;
            font-weight: bold;
            color: #3683ff;
        }
    </style>

</head>
<body>
    <?php
    if (isset($_POST['submitted'])) {
        $diff = array_diff($_POST, ['submitted' => '']);
        for ($i = 1; $i <= $_POST['total_fields'];  $i++) {
            $query = 'REPLACE INTO `embedded_lectures` VALUES ("' . $i . '","' . $diff['id'.$i] . '","' . $diff['description'.$i] . '","' . $diff['url'.$i] . '","' . (isset($diff['css'.$i]) ? '1' : '0') . '","' . (isset($diff['js'.$i]) ? '1' : '0') . '")';
            MySqlConnector::query($query);
        }
    }
    elseif (isset($_POST['remove'])) {
        $query = 'DELETE FROM `embedded_lectures` WHERE `id`="' . $_POST['remove'] . '"';
        MySqlConnector::query($query);
    }

    $lectureManager = new LectureManager();
    $lectures = $lectureManager->getLectures();

    $fields = '';
    foreach ($lectures as $lectureNumber => $lectureDetails) {
        //var_dump($lectures);
        $fields .= "<input placeholder='מספר ההרצאה' autocomplete='off' name='id" . $lectureDetails['id'] . "' value='" . $lectureNumber ."' required/>";
        $fields .= "<input placeholder='שם ההרצאה' autocomplete='off' class='description' name='description" . $lectureDetails['id'] . "' value='" . $lectureDetails['description'] ."'/>";
        $fields .= "<input placeholder='קישור להרצאה' autocomplete='off' class='url' name='url" . $lectureDetails['id'] ."' value='" . $lectureDetails['url'] . "' required/>";
        $fields .= "<input hidden type='checkbox' id='css-checkbox" . $lectureDetails['id'] ."' class='checkbox ' name='css" . $lectureDetails['id'] ."' value='" . $lectureDetails['css'] ."'" . ($lectureDetails['css'] ? ' checked' : '') . "/><label class='css-checkbox' for='css-checkbox" . $lectureDetails['id'] ."'><i class='fab fa-css3-alt fa-2x'></i></label>";
        $fields .= "<input hidden type='checkbox' id='js-checkbox" . $lectureDetails['id'] ."' class='checkbox' name='js" . $lectureDetails['id'] ."' value='" . $lectureDetails['js'] ."'" . ($lectureDetails['js'] ? ' checked' : '') . "/><label class='js-checkbox' for='js-checkbox" . $lectureDetails['id'] ."'><i class='fab fa-js-square fa-2x'></i></label>";
        $fields .= "<button type='submit' value='" . $lectureDetails['id'] . "' name='remove' class='remove'><i class=\"fa\">&#xf00d;</i></button>";
        $fields .= '<br/>';
    }
    $fields .= '<input hidden type="number" name="total_fields" value="' . count($lectures) . '"/>';
    ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset>
            <legend>Lectures URLs</legend>
            <?php echo $fields; ?>
        </fieldset>
        <button name="insert" type="button" onclick="insertNewLine()"><i class="fa fa-plus"></i></button>
        <button name="submitted" type="submit">Submit</button>
    </form>
    <script>
        var idCount = <?php echo count($lectures); ?> + 1;
        var fieldset = document.getElementsByTagName('fieldset')[0];
        var totalFields = document.getElementsByName('total_fields')[0];

        function insertNewLine() {
            var newLine = document.createElement("BR");
            var numberInput = document.createElement('input');
            numberInput.setAttribute('name', 'id' + idCount);
            numberInput.setAttribute('placeholder', 'מספר ההרצאה');
            numberInput.setAttribute('value', '');
            numberInput.setAttribute('required', 'true');
            numberInput.setAttribute('autocomplete', 'off');

            var descriptionInput = document.createElement('input');
            descriptionInput.className = 'description';
            descriptionInput.setAttribute('name', 'description' + idCount);
            descriptionInput.setAttribute('placeholder', 'שם ההרצאה');
            descriptionInput.setAttribute('value', '');
            descriptionInput.setAttribute('autocomplete', 'off');

            var urlInput = document.createElement('input');
            urlInput.className = 'url';
            urlInput.setAttribute('name', 'url' + idCount);
            urlInput.setAttribute('placeholder', 'קישור להרצאה');
            urlInput.setAttribute('value', '');
            urlInput.setAttribute('required', 'true');
            urlInput.setAttribute('autocomplete', 'off');

            var cssCheckbox = document.createElement('input');
            cssCheckbox.className = 'checkbox';
            cssCheckbox.setAttribute('name', 'css' + idCount);
            cssCheckbox.setAttribute('type', 'checkbox');

            var jsCheckbox = document.createElement('input');
            jsCheckbox.className = 'checkbox';
            jsCheckbox.setAttribute('name', 'js' + idCount);
            jsCheckbox.setAttribute('type', 'checkbox');

            idCount++;
            totalFields.value = parseInt(totalFields.value) + 1;
            fieldset.appendChild(numberInput);
            fieldset.appendChild(descriptionInput);
            fieldset.appendChild(urlInput);
            fieldset.appendChild(cssCheckbox);
            fieldset.appendChild(jsCheckbox);
            fieldset.appendChild(newLine);

            return false;
        }
    </script>
</body>
</html>

