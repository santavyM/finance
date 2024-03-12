
<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
	<meta charset="utf-8">
	<title><?= isset($pageTitle) ? $pageTitle : 'New page title' ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" >
	<?= $this->renderSection('page_meta') ?>
	<link rel="icon" href="/images/blog/<?= get_settings()->blog_favicon ?>" type="image/x-icon">
  
  <!-- theme meta -->
  <meta name="theme-name" content="reporter" />

	

	<!-- # CSS Plugins -->
	<link rel="stylesheet" href="/frontend/plugins/bootstrap/bootstrap.min.css">

	<!-- # Main Style Sheet -->
	<link rel="stylesheet" href="/frontend/css/style.css">
	<link rel="stylesheet" href="/frontend/css/mediaqueries.css">
    <?= $this->renderSection('stylesheets') ?>
</head>

<body>

<?php include('inc/blog-header.php') ?>

<main>
  <section class="section">
    <div class="container">
       <?= $this->renderSection('content') ?>
    </div>
  </section>
</main>

<?php include('inc/blog-footer.php') ?>


<!-- # JS Plugins -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/bootstrap/js/script.js'); ?>"></script>
<script src="/frontend/plugins/jquery/jquery.min.js"></script>
<script src="/frontend/plugins/bootstrap/bootstrap.min.js"></script>

<!-- Main Script -->
<script src="/frontend/js/script.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
