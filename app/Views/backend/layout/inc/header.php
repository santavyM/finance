<div class="header">
			<div class="header-left">
				
			</div>
			<div class="header-right">
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a
							class="dropdown-toggle"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
							<span class="user-name ci-user-name"><?= get_user()->name ?></span>
						</a>
						<div
							class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
						>
							<a class="dropdown-item" href="<?= route_to('admin.profile'); ?>"
								><i class="dw dw-user1"></i> Profil</a
							>
							<a class="dropdown-item" href="<?= route_to('settings') ?>"
								><i class="dw dw-settings2"></i> Nastavení</a
							>
							
							<a class="dropdown-item" href="<?= route_to('admin.logout') ?>"
								><i class="dw dw-logout"></i> Odhlásit se</a
							>
						</div>
					</div>
				</div>
				<div class="github-link">
					<a href="https://github.com/dropways/deskapp" target="_blank"
						><img src="/backend/vendors/images/github.svg" alt=""
					/></a>
				</div>
			</div>
		</div>