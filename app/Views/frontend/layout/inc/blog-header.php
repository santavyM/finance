

<nav id="desktop-nav">
<a href="<?= base_url() ?>">
<img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-width:170px"></a>
  <div>
    <ul class="nav-links">
      <li><a href="#about">About</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#about">About</a></li>
    </ul>
  </div>
</nav>
<nav id="hamburger-nav">
<img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-width:170px">
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
