<?php

if (!strlen($_SESSION["SESSION_TOKEN"]) > 0) {
header("Location: login_form.php?return_url=".$strReturnURL."&error_msg=".urlencode($strErrorMessage));
exit
}

?>