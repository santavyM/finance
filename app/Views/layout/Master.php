<html>

    <head>
        <meta charset="UTF-8" />


        <title>Finance</title>
        
        <link rel="stylesheet/less" type="text/css" href="<?= base_url('themes/')?><?=getActiveTheme()?>">
        <script src="https://cdn.jsdelivr.net/npm/less" ></script>
        <link rel="icon" href="/images/blog/<?= get_settings()->blog_favicon ?>" type="image/x-icon">
        <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/jquery.js'); ?>"></script>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/mediaqueries.css'); ?>">
        <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/kalkulacky.js'); ?>"></script>
    </head>

    <body>
        <?= $this->include('layout/navbar'); ?>
        <div class="container-fluid">
            <!--Area for dynamic content -->
            <?= $this->renderSection("content"); ?>
            <?= $this->include('layout/footer'); ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/script.js'); ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/kalkulacka1.js'); ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/kalkulacka2.js'); ?>"></script>
    </body>

</html>