<?=$this->extend("layout/master")?>

<?=$this->section("content")?>

<section id="profile">
<div class="section__pic-container">
    <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka">
</div>
<div class="section__text">
<p class="section__text__p1">Ahoj, já jsem</p>
<h1 class="title">finanční poradce</h1>
<p class="section__text__p2">Finanční poradce</p>
<div class="btn-cotainer">
    <button class="btn btn-color2" onclick="window.open('<?= base_url('assets/photo/resume.pdf'); ?>')">Download CV</button>
    <button class="btn btn-color1" onclick="window.open('<?= base_url('assets/photo/resume.pdf'); ?>')">Contact Info</button>
</div>
<div id="socials-container">
<a href="https://www.linkedin.com" target="_blank">
    <img src="<?= base_url('assets/assety/linkedin.png'); ?>" alt="LinkedIn profile" class="icon"></a>
<a href="https://www.github.com" target="_blank">
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
            <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka" class="about-pic">
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
        <img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#experience'">
</section>

<section id="experience">
<h1 class="title">Zkušenosti</h1>
<div class="experience-details-container">
    <div class="about-containers">
        <div class="details-container">
            <h2 class="experience-sub-title">Finance</h2>
            <div class="article-container">
                <article>
                <img src="<?= base_url('assets/assety/checkmark.png'); ?>" alt="checkmark icon" class="icon">
                    <div>
                        <h3>Certifikát</h3>
                        <p>Finanční specialista</p>
                    </div>
                </article>
                <article>
                <img src="<?= base_url('assets/assety/checkmark.png'); ?>" alt="checkmark icon" class="icon">
                    <div>
                        <h3>Certifikát</h3>
                        <p>ČNB finance</p>
                    </div>
                </article>
            </div>
        </div>
        <div class="details-container">
            <h2 class="experience-sub-title">Právo</h2>
            <div class="article-container">
                <article>
                <img src="<?= base_url('assets/assety/checkmark.png'); ?>" alt="checkmark icon" class="icon">
                    <div>
                        <h3>Certifikát</h3>
                        <p>Finanční specialista</p>
                    </div>
                </article>
                <article>
                <img src="<?= base_url('assets/assety/checkmark.png'); ?>" alt="checkmark icon" class="icon">
                    <div>
                        <h3>Certifikát</h3>
                        <p>ČNB finance</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
<img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#projects'">
</section>
<section id="projects">
    <p class="section__text__p1">Kalkulačky</p>
    <h1 class="title">Kalkulačky</h1>
    <div class="experience-details-container">
        <div class="about-containers">
            <div class="details-container color-container">
                <div class="article-container">
                <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka" class="project-img">
                </div>
                <h2 class="experience-sub-title project-title">Hypotéka</h2>
                <div class="btn-container">
                <a href="kalkulacka">
                    <button class="btn btn-color2 project-btn">Otevřít</button></a>
                </div>
            </div>
            <div class="details-container color-container">
                <div class="article-container">
                <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka" class="project-img">
                </div>
                <h2 class="experience-sub-title project-title">ROI</h2>
                <div class="btn-container">
                <a href="https://www.github.com" target="_blank">
                    <button class="btn btn-color2 project-btn">ROI</button></a>
                </div>
            </div>
            <div class="details-container color-container">
                <div class="article-container">
                <img src="<?= base_url('assets/photo/12.png'); ?>" alt="financni poradce fotka" class="project-img">
                </div>
                <h2 class="experience-sub-title project-title">ROI</h2>
                <div class="btn-container">
                <a href="https://www.github.com" target="_blank">
                    <button class="btn btn-color2 project-btn">ROI</button></a>
                </div>
            </div>
        </div>
    </div>
    <img src="<?= base_url('assets/assety/arrow.png'); ?>" alt="arrow icon" class="icon arrow" onclick="location.href='#contact'">
</section>
<section id="contact">
    <p class="section__text__p1">Kontaktuj mě</p>
    <h1 class="title">Kontakt</h1>
    <div class="contact-info-upper-container">
        <div class="contact-info-container">
            <img src="<?= base_url('assets/assety/email.png'); ?>" alt="email icon email-icon" class="icon contact-icon email-icon">
            <p><a href="mailto:financniporadce@gmail.com" target="_blank">financniporadce@gmail.com</a></p>
        </div>
        <div class="contact-info-container">
            <img src="<?= base_url('assets/assety/linkedin.png'); ?>" alt="linkedin icon" class="icon contact-icon">
            <p><a href="https://www.linkedin.com" target="_blank">linkedin</a></p>
        </div>
    </div>
</section>
<?=$this->endSection()?>
