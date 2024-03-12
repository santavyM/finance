

<nav id="desktop-nav">
<a href="<?= base_url() ?>">
<img loading="prelaod" decoding="async" class="img-fluid" src="/images/blog/<?= get_settings()->blog_logo ?>" alt="<?= get_settings()->blog_title ?>" style="max-width:170px"></a>
  <div>
    <ul class="nav-links">
    <?php foreach( get_sidebar_categories() as $parent_category ): ?>
          <li> <a class="nav-link" href="<?= route_to('category-posts',$parent_category->id) ?>" role="button">
              <?= $parent_category->name ?>
            </a>
          </li>
          <?php endforeach ?>
      <li>
        <form action="<?= route_to('search-posts') ?>" method="get" class="search order-lg-3 order-md-2 order-3 ml-auto">
        <input id="search-query" name="q" type="search" placeholder="Search..." autocomplete="off" value="<?= isset($search) ? $search : '' ?>">
      </form>
      </li>
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
    <?php foreach( get_sidebar_categories() as $parent_category ): ?>
          <li> <a class="nav-link" href="<?= route_to('category-posts',$parent_category->id) ?>" role="button">
              <?= $parent_category->name ?>
            </a>
          </li>
          <?php endforeach ?>
    </div>
  </div>
</nav>
