<?php

include '../../../xtreme/library/bootstrap.php';

ob_clean();
if (X_LOGIN && $Xme->id > 0) {
    $Xme->email_confirmation();
    echo 1;
} else {
    echo 0;
}
die();
