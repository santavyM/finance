<div class="left-side-bar">
			<div class="brand-logo">
				<a href="/">
					<img src="/images/blog/<?= get_settings()->blog_logo ?>" alt="" class="dark-logo" />
					<img
						src="/images/blog/<?= get_settings()->blog_logo ?>"
						alt=""
						class="light-logo"
					/>
				</a>
				<div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
						<li>
							<a href="<?= route_to('categories') ?>" class="dropdown-toggle no-arrow <?= current_route_name() == 'categories' ? 'active' : '' ?>">
								<span class="micon dw dw-list"></span
								><span class="mtext">Kategorie</span>
							</a>
						</li>
					    
					    <li>
							<a href="<?= route_to('all-posts') ?>" class="dropdown-toggle no-arrow <?= current_route_name() == 'all-posts' ? 'active' : '' ?>">
								<span class="micon dw dw-newspaper"></span
								><span class="mtext">Články</span>
							</a>
						</li>
					    
						<li>
							<div class="dropdown-divider"></div>
						</li>
						<li>
							<div class="sidebar-small-cap">Settings</div>
						</li>
					
						<li>
							<a
								href="<?= route_to('admin.profile'); ?>"
								
								class="dropdown-toggle no-arrow <?= current_route_name() == 'admin.profile' ? 'active' : '' ?>"
							>
								<span class="micon dw dw-user"></span>
								<span class="mtext"
									>Profil
									</span>
							</a>
						</li>
						<li>
							<a
								href="<?= route_to('settings') ?>"
								
								class="dropdown-toggle no-arrow <?= current_route_name() == 'settings' ? 'active' : '' ?>"
							>
								<span class="micon dw dw-settings"></span>
								<span class="mtext"
									>Nastavení
									</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>