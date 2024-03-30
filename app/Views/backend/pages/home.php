<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<?php
header('Location: '.base_url().'admin/profile');
exit;
?>

<?= $this->endSection() ?>