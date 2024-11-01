<?php
session_start();
if ($_REQUEST["captcha"] == $_SESSION["vercode"] AND $_SESSION["vercode"] !='')  {
    exit('true');
} else {
    exit('false');
};
?>
