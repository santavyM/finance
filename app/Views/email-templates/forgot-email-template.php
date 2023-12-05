<p>Drahy <?= $mail_data['user']->name?>,</p>
<p>
    dostali jsme request na zmenu hesla na email:<i><?= $mail_data['user']->email ?></i>
    muzes si ho zmenit kliknutim zde.
    <br>
    <a href="<?= $mail_data['actionLink'] ?>" style="color:#fff;border-color:#22bc66;border-style:solid;border-width:5px 10px;background-color:#22bc66;display: inline-block;
    text-decoration:none;border-radius:3px;box-shadow:0 2px 3px rgba(0,0,0,0.16);-webkit-text-size-adjust:none;box-sizing:border-box;" targer="_blank">zmenit heslo</a>
    <br>
    <b>NV: </b> Tento link je dostupny jen pro nasledujic
    <br>
    jestli si o to nezazadal prosim neklikej na nic
</p>