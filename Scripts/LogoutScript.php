<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 01/02/18
 * Time: 15:09
 */
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");