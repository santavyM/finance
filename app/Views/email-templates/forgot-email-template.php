<p>Ahoj, <?= $mail_data['user']->name ?></p>
<p>
    zmena hesla pro <i><?= $mail_data['user']->email ?></i>.
    Pro zmenu hesla kliknete na tlacitko:
    <br><br>
    <a href="<?= $mail_data['actionLink'] ?>" style="color:#fff;border-color:#22bc66;border-style:solid;border-width:5px 10px;background-color:#22bc66;display:inline-block;text-decoration:none;border-radius:3px;box-shadow:0 2px 3px rgba(0,0,0,0.16);-webkit-text-size-adjust:none;box-sizing:border-box;" target="_blank">Reset password</a>
    <br><br>
    Link je platny na 15 minut.
    <br><br>
    Jestli jsi o zmenu hesla nepozadal, tento email ignoruj.
</p>