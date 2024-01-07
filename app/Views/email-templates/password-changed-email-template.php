<p>ahoj, <b><?= $mail_data['user']->name ?></b></p>
<br>
<p>
    Heslo bylo uspesne zmeneno:
    <br><br>
    <b>Login : </b> <?= $mail_data['user']->username ?> nebo <?= $mail_data['user']->email ?>
    <br>
    <b>Heslo: </b> <?= $mail_data['new_password'] ?>
</p>
<br>
<br>
------------------------------------------------------
<p>
    Email byl automaticky zaslán.
</p>