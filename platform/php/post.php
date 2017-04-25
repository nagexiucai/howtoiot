<?php

echo '$_POST["account"]====='.$_POST["account"];
echo "<br/>";
echo 'file_get_contents("php://input")====='.file_get_contents("php://input");
echo "<br/>";
echo '$GLOBALS["HTTP_RAW_POST_DATA"]====='.$GLOBALS["HTTP_RAW_POST_DATA"];