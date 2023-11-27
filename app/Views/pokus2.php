

<?=$this->extend("layout/master")?>

<?=$this->section("content")?>

<h1>Welcome to About us page</h1>
<p>
    This is a sample page of our website
</p>
<p><?= anchor('pokus', 'link'); ?></p>
<?=$this->endSection()?>