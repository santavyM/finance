<?= $this->extend('frontend/layout/pages-layout') ?>
<?= $this->section('page_meta') ?>
<meta name="decription" content="<?= $post->meta_description ?>" />
<meta name="keywords" content="<?= $post->meta_keywords ?>" />
<link rel="canonical" href="<?= current_url() ?>">
<meta itemprop="name" content="<?= $post->title ?>" />
<meta itemprop="description" content="<?= $post->meta_description ?>" />
<meta itemprop="image" content="<?= base_url('images/posts/'.$post->featured_image) ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= $post->title ?>" />
<meta property="description" content="<?= $post->meta_description ?>" />
<meta property="og:image" content="<?= base_url('images/posts/'.$post->featured_image) ?>" />
<meta property="og:url" content="<?= current_url() ?>" />
<?= $this->endSection() ?>
<?= $this->section('content') ?>


<div class="post-grid-container">
    <div class="main-content gird-item" style="grid-row: 1/<?=7+get_reading_time_grid($post->content)*2?>">
        <img loading="lazy" decoding="async" src="/images/posts/resized_<?= $post->featured_image ?>" alt="Post Thumbnail" class="w-100">
        <div style="padding: 5px">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor "
                style="margin-right:5px;margin-top:-4px" viewBox="0 0 16 16">
                <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"></path>
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z">
                </path>
                <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z">
                </path>
            </svg> <span><?= date_formatter($post->created_at) ?></span>
        </div>
        <h1 class="my-3"><?= $post->title ?></h1>

        <?php if( count(get_tags_by_post_id($post->id)) ): ?>
        <ul class="post-meta mb-4">
            <?php foreach( get_tags_by_post_id($post->id) as $tag ): ?>
            <li> <?= $tag ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <div class="content text-left" style="padding:2rem">
            <?= $post->content; ?>
        </div>
        <div class="prev-next-posts">
            <div class="posts-container">
                <div class="post-item">
                    <?php if( !empty(get_previous_post($post->id)) ): ?>
                    <a href="<?= route_to('read-post',get_previous_post($post->id)->slug) ?>"><h4>&laquo; Předchozí</h4></a>
                    <?php endif; ?>
                </div>
                <div class="post-item">
                    <?php if( !empty(get_next_post($post->id)) ): ?>
                    <a href="<?= route_to('read-post',get_next_post($post->id)->slug) ?>"><h4>Další &raquo;</h4></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php foreach( sidebar_latest_posts($post->id) as $post ): ?>
        <div class="grid-random-posts">
        <a href="<?= route_to('read-post',$post->slug) ?>">
            <img loading="lazy" decoding="async" src="/images/posts/thumb_<?= $post->featured_image ?>" alt="Post Thumbnail" class="w-100">
        </a>
        <h4 class="text"><?= $post->title ?></h4>
        </div>
    <?php endforeach; ?>

<?php if( count(get_6_home_latest_posts()) >0 ) : ?>
        <?php foreach( get_6_home_latest_posts()  as $post) : ?>
        <div class="latest-posts">
                <img loading="lazy" decoding="async" src="/images/posts/resized_<?= $post->featured_image ?>" alt="Post Thumbnail"
                            class="w-100">
                        <span class="text-uppercase"><?= date_formatter($post->created_at) ?></span>
                        <span class="text-uppercase"><?= get_reading_time($post->content) ?></span>
                    <h2><?= $post->title ?></h2>
                    <p class="card-text"><?= limit_words($post->content,11) ?></p>
                    <a href="<?= route_to('read-post',$post->slug) ?>"><button class="button btn-color2 project-btn">přečíst</button></a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        
</div>

<?= $this->endSection() ?>
<?= $this->section('stylesheets') ?>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<?= $this->endSection() ?>