<nav id="desktop-nav">
<a href="<?= base_url() ?>">
<img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-width:170px">
</a>
  <div>
    <ul class="nav-links">
      <li><a href=<?= base_url("#about") ?>>O Mně</a></li>
      <li><a href=<?= base_url("#contact") ?>>Kontakt</a></li>
      <li><a href=<?= base_url('#projects') ?>>Kalkulačky</a></li>
      <li><a href="<?= route_to('blog') ?>">Blog</a></li>
    </ul>
  </div>
</nav>
<nav id="hamburger-nav">
<a href="<?= base_url() ?>">
<img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-width:170px">
</a>
  <div class="hamburger-menu">
    <div class="hamburger-icon" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div class="menu-links">
      <li><a href="#about" onclick="toggleMenu()">About</a></li>
      <li><a href="#about" onclick="toggleMenu()">About</a></li>
      <li><a href="#about" onclick="toggleMenu()">About</a></li>
      <li><a href="#about" onclick="toggleMenu()">About</a></li>
    </div>
  </div>
</nav>
