<?=$this->extend("layout/master")?>

<?=$this->section("content")?>

<section id="profile">
<div class="section__pic-container">
    <img src="<?= '/images/users/'.get_user_1()->picture ?>" alt="financni poradce fotka">
</div>
<div class="section__text">
<p class="section__text__p1">Ahoj, já jsem</p>
<h1 class="title"><?= get_user_1()->name ?></h1>
<p class="section__text__p2">Finanční poradce</p>
<div class="btn-cotainer">
    <button class="btn btn-color2" onclick="window.open('<?= base_url('assets/photo/resume.pdf'); ?>')">Download CV</button>
    <button class="btn btn-color1" href="mailto:<?= get_settings()->blog_email ?>">Contact Me</button>
</div>
<div id="socials-container">
<a href="<?= get_social_media()->linkedin_url ?>" target="_blank">
    
    <img src="<?= base_url('assets/assety/linkedin.png'); ?>" alt="LinkedIn profile" class="icon"></a>
<a href="<?= get_social_media()->github_url?>" target="_blank">
    <img src="<?= base_url('assets/assety/github.png'); ?>" alt="Git profile" class="icon"></a>
</div>
</div>
<img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#about'">
</section>

<section id="about">
    <p class="section__text__p1">Zjisti o mé práci více</p>
    <h1 class="title">O mně</h1>
        <div class="section-container">
            <div class="section__pic-container">
            <img src="<?= '/images/users/'.get_user_1()->picture ?>" alt="financni poradce fotka" class="about-pic">
            </div>

            <div class="about-details-container">
                <div class="about-containers">
                    <div class="details-container">
                        <img src="<?= base_url('assets/assety/experience.png'); ?>" alt="exp icon" class="icon">
                        <h3>Zkušenosti</h3>
                        <p>2+ let <br> Finanční poradenství</p>
                    </div>
                    <div class="details-container">
                        <img src="<?= base_url('assets/assety/education.png'); ?>" alt="edu icon" class="icon">
                        <h3>Vzdělání</h3>
                        <p>Ing. a Bc.<br>Vysoká škola života</p>
                    </div>
                </div>
                <div class="text-container">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo accusamus blanditiis dolores tenetur, a, minima alias hic enim inventore, asperiores maxime distinctio ut pariatur commodi expedita ullam. Facilis, molestias eum.</p>
                </div>
            </div>
        </div>
        <img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#projects'">
</section>

<section id="projects">
    <p class="section__text__p1">Kalkulačky</p>
    <h1 class="title">Kalkulačky</h1>
    <div class="experience-details-container">
        <div class="section-container">
            <div class="about-containers">
                <div class="details-container color-container">
                    <div class="article-container">
                    <img src="<?= base_url('assets/assety/chart-pie-solid.svg'); ?>" alt="financni poradce fotka" class="project-img">
                    </div>
                    <h2 class="experience-sub-title project-title">Hypotéka</h2>
                    <div class="btn-container">
                    <a href="hypotecni-kalkulacka">
                        <button class="btn btn-color2 project-btn">Otevřít</button></a>
                    </div>
                </div>
                <div class="details-container color-container">
                    <div class="article-container">
                    <img src="<?= base_url('assets/assety/chart-line-solid.svg'); ?>" alt="financni poradce fotka" class="project-img">
                    </div>
                    <h2 class="experience-sub-title project-title">ROI</h2>
                    <div class="btn-container">
                    <a href="investicni-kalkulacka" target="_blank">
                        <button class="btn btn-color2 project-btn">ROI</button></a>
                    </div>
                </div>
                <div class="details-container color-container">
                    <div class="article-container">
                    <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka" class="project-img">
                    </div>
                    <h2 class="experience-sub-title project-title">Kolik investovat?</h2>
                    <div class="btn-container">
                    <a href="kolik-investicni-kalkulacka" target="_blank">
                        <button class="btn btn-color2 project-btn">ROI</button></a>
                    </div>
                </div>
                <div class="details-container color-container">
                    <div class="article-container">
                    <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka" class="project-img">
                    </div>
                    <h2 class="experience-sub-title project-title">Renta</h2>
                    <div class="btn-container">
                    <a href="rent-kalkulacka" target="_blank">
                        <button class="btn btn-color2 project-btn">ROI</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#experience'">
</section>

<section id="experience">
<p class="section__text__p1">Mé poslední články</p>
<h1 class="title">Blog</h1>
<div class="experience-details-container">
        <div class="about-containers">
        <?php foreach( sidebar_latest_posts() as $post ): ?>
            <div class="details-container color-container">
                <div class="article-container">
                <a class="media align-items-center" href="<?= route_to('read-post',$post->slug) ?>">
                <img loading="lazy" decoding="async" src="/images/posts/thumb_<?= $post->featured_image ?>" alt="Post Thumbnail" class="w-100"></a>
                </div>
                <div class="media-body ml-3">
                <h3 style="margin-top:-5px"><?= $post->title ?></h3>
                <p class="mb-0 small"><?= limit_words($post->content,6) ?></p>
            </div>
            </div>
            <?php endforeach; ?>
    </div>
</div>
<a href="<?= route_to('blog') ?>">
<div class="contact-info-upper-container">
    <div class="contact-info-container">
        <h2>otevřít blog</h2>
    </div>
</div>
</a>
<img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#contact'">
</section>

<section id="contact">
    <p class="section__text__p1">Kontaktuj mě</p>
    <h1 class="title">Kontakt</h1>
    <div class="contact-info-upper-container">
        <div class="contact-info-container">
            <img src="<?= base_url('assets/assety/email.png'); ?>" alt="email icon email-icon" class="icon contact-icon email-icon">
            <p><a href="mailto:<?= get_settings()->blog_email ?>" target="_blank"><?= get_settings()->blog_email ?></a></p>
        </div>
        <div class="contact-info-container">
            <img src="<?= base_url('assets/assety/linkedin.png'); ?>" alt="linkedin icon" class="icon contact-icon">
            <p><a href="https://www.linkedin.com" target="_blank">linkedin</a></p>
        </div>
    </div>
    <img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#profile'" style="transform: rotate(180deg)">
</section>
<?=$this->endSection()?>
