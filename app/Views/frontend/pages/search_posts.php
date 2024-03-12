<?= $this->extend('frontend/layout/pages-layout') ?>
<?= $this->section('content') ?>


<div class="col-12">
    <h1 class="mb-4 border-bottom border-primary d-inline-block">Search for: <?= $search ?></h1>
</div>
<div class="grid-container">
    <?php foreach( $posts  as $post) : ?>
    <div class="latest-posts">
            <a href="<?= route_to('read-post',$post->slug) ?>">
            <img loading="lazy" decoding="async" src="/images/posts/resized_<?= $post->featured_image ?>" alt="Post Thumbnail"
                        class="w-100">
                    <span class="text-uppercase"><?= date_formatter($post->created_at) ?></span>
                    <span class="text-uppercase"><?= get_reading_time($post->content) ?></span>
            </a>
                <h2><a class="post-title" href="<?= route_to('read-post',$post->slug) ?>"><?= $post->title ?></a></h2>
                <p class="card-text"><?= limit_words($post->content,13) ?></p>
                <a href="<?= route_to('read-post',$post->slug) ?>"><button class="button btn-color2 project-btn">přečíst</button></a>
    </div>
    <?php endforeach; ?>
</div>


<?= $this->endSection() ?>