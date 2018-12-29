<?php

if (is_file('../../../xtreme/library/bootstrap.php')) {
    include_once '../../../xtreme/library/bootstrap.php';
}

Xlogin::session('userid', 0);

if (isset($_GET['redirect']) && is_string($_GET['redirect'])) {
    Utilities::redirect(Utilities::validate($_GET['redirect']));
}

die;
