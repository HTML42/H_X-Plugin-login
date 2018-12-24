<!DOCTYPE ->
<html>
    <head>
        <meta charset="utf-8" />
        <title>Email-Bestätigung | <?= Emails::EMAIL_TITLE ?></title>
    </head>
    <body>
        <h2>Email-Bestägigung für <?= Emails::APP_NAME ?></h2>
        <p>
            Klicken sie auf folgenden Link um Ihre E-Mail zu bestätigen:
        </p>
        <p>
            <a href="<?= BASEURL ?>email_confirmation.html"><?= BASEURL ?>email_confirmation.html</a>
        </p>
        <p>
            Vielen Dank,<br/>
            Ihr <?= Emails::APP_NAME ?>-Team
        </p>
    </body>
</html>