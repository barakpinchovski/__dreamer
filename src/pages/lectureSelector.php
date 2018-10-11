<?php
    $lectureManager = new LectureManager();
    $lecture = isset($_GET['l']) && !empty($_GET['l']) ? $_GET['l'] : '1.1';
    $currentLecture = $lectureManager->getLectures($lecture);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>WEB 2019a - L<?php echo $lecture; ?></title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <script>
            window.onload = function() {
                document.getElementById('thing').onmousedown = function(e) {
                    document.getElementsByName('ppts')[0].style.pointerEvents = 'none';
                };
                document.getElementById('thing').onmouseup = function(e) {
                    document.getElementsByName('ppts')[0].style.pointerEvents = 'auto';
                };
            };
        </script>
    </head>
    <frameset rows="4%, 0%, 96%" id="thing">
        <frame src="lectureNavigator.php?l=<?php echo $lecture; ?>"/>
        <frame src="src/pages/html_interpreter/html_interpreter.html"/>
        <frameset cols="0%, 100%"  id="thing" >
            <frame src="src/pages/html_interpreter/html_interpreter.html"/>
            <frame name="ppts" src="<?php echo $currentLecture['url']; ?>"/>
        </frameset>
    </frameset>
</html>

