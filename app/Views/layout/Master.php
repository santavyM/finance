<html>

    <head>
        <meta charset="UTF-8" />


        <title>Finance</title>
        
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/style.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/mediaqueries.css'); ?>">
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
    </body>

</html>