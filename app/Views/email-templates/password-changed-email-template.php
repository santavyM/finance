<p>Drahy <?= $mail_data['user']->name?>,</p>
<p>
    Změnil jsi svoje heslo
    <br>
    
    <b>Login ID: </b> <?= $mail_data['user']->email ?> or <?= $mail_data['user']->username ?>
    <br>
    <b>Password: </b> <?= $mail_data['new_password'] ?>
</p>