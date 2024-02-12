<?= $this->extend('frontend/layout/pages-layout') ?>
<?= $this->section('page_meta') ?>
 <meta name="robots" content="index,follow"/>
 <meta name="title" content="<?= get_settings()->blog_title ?>"/>
 <meta name="description" content="<?= get_settings()->blog_meta_description ?>"/>
 <meta name="author" content="<?= get_settings()->blog_title ?>"/>
 <link rel="canonical" href="<?= base_url() ?>"/>
 <meta property="og:title" content="<?= get_settings()->blog_title ?>"/>
 <meta property="og:type" content="website"/>
 <meta property="og:description" content="<?= get_settings()->blog_meta_description ?>"/>
 <meta property="og:url" content="<?= base_url() ?>"/>
 <meta property="og:image" content="<?= base_url('images/blog/'.get_settings()->blog_logo) ?>"/>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section>
<h1 class="title">Blog</h1>
<div class="grid-container">
    <div class="flip-card">
        <div class="main-post">
            <img loading="lazy" decoding="async" src="/images/posts/<?= get_home_main_latest_post()->featured_image ?>" alt="Post Thumbnail" class="w-100">
            <div class="text"><?= get_home_main_latest_post()->title ?></div>
        </div>
        <div class="main-post-back">
        <span class="text-uppercase"><?= date_formatter(get_home_main_latest_post()->created_at) ?></span>
                            <span class="text-uppercase"><?= get_reading_time(get_home_main_latest_post()->content) ?></span>
        <h2 class="h1"><a class="post-title" href="<?= route_to('read-post',get_home_main_latest_post()->slug) ?>"><?= get_home_main_latest_post()->title ?></a></h2>
        <img loading="lazy" decoding="async" src="/images/posts/<?= get_home_main_latest_post()->featured_image ?>" alt="Post Thumbnail">
                    <p class="card-text"><?= limit_words(get_home_main_latest_post()->content,35) ?></p>
                    <a href="<?= route_to('read-post',get_home_main_latest_post()->slug) ?>"><button class="btn btn-color2 project-btn">přečíst</button></a>
        </div>
    </div>
    
    <div class="grid-item category-sidebar">
        <div class="grid-button-container">
            <h2 class="section-title">Categories</h2>
            <?php foreach( get_sidebar_categories() as $category ): ?>
                <a href="<?= route_to('category-posts',$category->id) ?>"><button class="btn btn-color2 project-btn"><?= $category->name ?><span>(<?= posts_by_category_id($category->id) ?>)</span></button></a>
            <?php endforeach; ?>
        </div>            
    </div>

    <?php if( count(get_6_home_latest_posts()) >0 ) : ?>
        <?php foreach( get_6_home_latest_posts()  as $post) : ?>
        <div class="latest-posts">
                <img loading="lazy" decoding="async" src="/images/posts/resized_<?= $post->featured_image ?>" alt="Post Thumbnail"
                            class="w-100">
                        <span class="text-uppercase"><?= date_formatter($post->created_at) ?></span>
                        <span class="text-uppercase"><?= get_reading_time($post->content) ?></span>
                    <h2><?= $post->title ?></h2>
                    <p class="card-text"><?= limit_words($post->content,13) ?></p>
                    <a href="<?= route_to('read-post',$post->slug) ?>"><button class="button btn-color2 project-btn">přečíst</button></a>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
</div>
</section>

<?= $this->endSection() ?>