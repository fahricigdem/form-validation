<?php

    // connect database
    $conn = mysqli_connect('localhost','fahricigdem','1234','pizza');

    // controll connection
    if (!$conn) echo mysqli_connect_error();
?>