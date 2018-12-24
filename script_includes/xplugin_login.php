<?php

include PROJECT_ROOT . 'plugins/login/kickstart.php';


#Start Database
$XLDB = new Xlogin_DB();

#Create Current User
$Xme = new Xuser(X_LOGIN_ID);
