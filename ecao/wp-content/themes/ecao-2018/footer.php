
		<footer>
			<div class="container">
				<nav id="footer-nav" role="navigation">
					<div class="row">
						
							<!--<ul>
								<div class="col-md-3 col-sm-3">
								<li><a href="account-dashboard.php"><h4>About Us</h4></a>
									<ul>
										<li><a href="post-listing.php">Why another society?</a>
										<li><a href="review-order.php">How we differ</a>
										<li><a href="confirm-order.php">ECAO background</a>
									</ul>
								</li>
								</div>
								<div class="col-md-3 col-sm-3">
								<li><a href="listings-jobs.php"><h4>Membership Requirements</h4></a>
									<ul>
										<li><a href="job-listing.php">Tiers of membership</a>
									</ul>
								</div>
								<div class="col-md-3 col-sm-3">
								<li><a href="listings-profiles.php"><h4>Progression</h4></a>
									<ul>
										<li><a href="company-profile.php">Progression principles</a>
									</ul>
								</div>
								<div class="col-md-3 col-sm-3">
								<li><a href="login.php"><h4>Related Information</h4></a>
									<ul>
										<li><a href="company-profile.php">FAQ</a>
									</ul>
								</div>
							</ul>-->
							
						<?php wp_nav_menu( array(
							'theme_location' => 'footer_menu' ,
							'menu' => 'Footer Menu' ,
							'container' => 'ul'
						) ); ?>
					</div>	
				</nav>
				<span class="float-right" id="footer-field">&copy;2018 ECAO (5KIQ) <a href="http://ecao.us/log-in">Log In</a></span>
			</div>
		</footer>

	</body>
</html>