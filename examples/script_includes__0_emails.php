<?php

//Email-Class
class Emails {

    const EMAIL_TITLE = 'Projektname';
    const APP_NAME = 'Projektname';
    const SENDER = 'noreply@projektname.de';
    
    public static $BASEURL = BASEURL;
    
    public static $data = array();

    public static $config = array(
        'confirmation' => null
    );

    /**
     * 
     * @param string $type | confirmation
     * @param string/array $recepients
     * @param array $data
     */
    public static function create($type = 'confirmation', $recepients = array(), $data = array()) {
        if(isset(Emails::$config[$type])) {
            Emails::$data = $data;
            $File_email_content = File::i(Emails::$config[$type]['content_file']);
            if($File_email_content->exists) {
                Emails::$config[$type]['content'] = trim($File_email_content->get_content());
            }
            Emails::$data = null;
            //
            if(is_string(Emails::$config[$type]['content']) && !empty(Emails::$config[$type]['content'])) {
                debug('Sending Email');
                debug(Emails::$config[$type]);
            }
        }
    }

}

//Emails-Configurations
Emails::$config['confirmation'] = array(
    'title' => 'Bestätigungs-Email - ' . Emails::APP_NAME,
    'content_file' => PROJECT_ROOT . 'emails/confirmation.php',
    'content' => null,
    'sender' => Emails::SENDER,
);

//Correct BASEURL
if(strstr(Emails::$BASEURL, 'plugins/login/')) {
    Emails::$BASEURL = @reset(explode('plugins/login/', Emails::$BASEURL));
}
