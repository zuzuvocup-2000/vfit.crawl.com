<?php $main_nav = get_menu(array('keyword' => 'main-menu','language' => 'vi', 'output' => 'array')); ?>
<?php $cookie = (isset($_COOKIE[AUTH.'member']) ? json_decode($_COOKIE[AUTH.'member'], true) : []) ?>
<header class="uk-visible-large pc-header">
	<div class="uk-container uk-container-center">
		<div class="uk-flex uk-flex-middle uk-flex-space-between">
			<div class="logo">
				<?php echo logo() ?>
			</div>
			<div class="widget uk-flex uk-flex-middle">
				<div class="uk-position-relative">
					<button class="button c-button uk-flex uk-flex-middle open-category">
						<p class="c-text">All Categories</p>
						<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-ml-1 _1Dn_Q68wsFGZyARSZVjjm2"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.47 8.845a.75.75 0 011.06 0l5.47 5.47 5.47-5.47a.75.75 0 111.06 1.06l-6 6a.75.75 0 01-1.06 0l-6-6a.75.75 0 010-1.06z" fill="currentColor"></path></svg>
					</button>
					<div class="list-menu-hd">
						<ul class="uk-list">
							<?php if(isset($main_nav['data']) && is_array($main_nav['data']) && count($main_nav['data'])){foreach ($main_nav['data'] as $value) { ?>
								<li><a href="<?php echo $value['canonical'] ?>" title="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
							<?php }} ?>
						</ul>
					</div>
				</div>
				<div class="uk-flex uk-flex-middle ml20 ">
					<div class="uk-position-relative">
						<button class="c-button open-search-hd c-button--link c-button--sm mc-px-3 uk-flex uk-flex-middle mr20">
							<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-mr-1 _1Dn_Q68wsFGZyARSZVjjm2"><path fill-rule="evenodd" clip-rule="evenodd" d="M11 6.75a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5zM5.25 11a5.75 5.75 0 1111.5 0 5.75 5.75 0 01-11.5 0z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M14.47 14.47a.75.75 0 011.06 0l3 3a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06z" fill="currentColor"></path></svg>
							<p class="mc-text-h7 mc-text--capitalize">Search</p>
						</button>
						<div class="search-hd">
							<form class="uk-search" action="<?php echo HTSEARCH.HTSUFFIX ?>" data-uk-search="{}">
								<label class="uk-flex uk-flex-middle mc-w-100">
									<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-opacity--muted"><path fill-rule="evenodd" clip-rule="evenodd" d="M11 6.75a4.25 4.25 0 100 8.5 4.25 4.25 0 000-8.5zM5.25 11a5.75 5.75 0 1111.5 0 5.75 5.75 0 01-11.5 0z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M14.47 14.47a.75.75 0 011.06 0l3 3a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06z" fill="currentColor"></path></svg>
									<input type="text" placeholder="Search instructors, classes, topics" name="keyword" value="<?php echo (isset($_GET['keyword']) ? $_GET['keyword'] : '') ?>">
								</label>
							</form>
						</div>
					</div>
					<!-- <a class="c-link" href="."><p class="mc-text-h7 mc-text--capitalize">View Plans</p></a> -->
				</div>
			</div>
			<div class="menu-container uk-flex uk-flex-middle">
				<!-- <a href="" title="">For Business</a> -->
				<!-- <div id="nav_more_menu" class="c-clickable uk-flex uk-flex-middle">
					<span class="mc-text-h6 mc-pr-1 ">Menu</span>
					<img src="public/frontend/resources/img/bar.svg">
				</div> -->
				<?php if(isset($cookie) && is_array($cookie) && count($cookie)){ ?>
					<span class="white mr5"><?php echo $cookie['email'] ?>,</span> <a href="logout.html" title="Logout">Logout</a>
				<?php }else{ ?>
					<a class="btn-loginm2" href="#login_hd" title="login" data-uk-modal>Login</a>
				<?php } ?>
			</div>
		</div>
	</div>
</header>

 <!-- MOBILE HEADER -->
 <header class="mobile-header uk-hidden-large">
 	<section class="upper">
 		<a class="moblie-menu-btn skin-1" href="#offcanvas" class="offcanvas" data-uk-offcanvas="{target:'#offcanvas'}">
 			<span>Menu</span>
 		</a>
 		<div class="logo">
 			<a href="" title="logo" class="img img-cover">
				<img src="<?php echo $general['homepage_logo'] ?>">
			</a>
		</div>
		<?php if(isset($cookie) && is_array($cookie) && count($cookie)){ ?>
			<a href="logout.html" title="Logout" class="white btn-mobile-login"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
		<?php }else{ ?>
			<a class="btn-loginm2 white btn-mobile-login" href="#login_hd" title="login" data-uk-modal><i class="fa fa-user" aria-hidden="true"></i></a>
		<?php } ?>
 	</section><!-- .upper -->
 </header><!-- .mobile-header -->



<?php echo view('frontend/homepage/common/login') ?>