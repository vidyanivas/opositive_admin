<aside class="main-sidebar">
	<!-- sidebar-->
	<a href="dashboard.php" class="logo">
		<!-- logo-->
		<div class="logo-lg text-center py-3">
		  <span class="light-logo"><img src="img/logo.png" alt="logo"></span>
		</div>
	</a>	
    <section class="sidebar position-relative">	
	  	<div class="multinav">
		    <div class="multinav-scroll" style="height: 100%;">	
				<hr>
				<!-- sidebar menu-->
				<ul class="sidebar-menu" data-widget="tree">	

					<li class="menu-item ">
						<a href="dashboard.php" class="menu-link <?php if($fname=='dashboard.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-house"></i> <span><span> Dashboard</span></span>
						</a>
					</li>
					<li class="treeview <?php if($fname=='admins.php'){ ?>menu-open<?php } ?>">
						<a href="#"> <i class="fa-light fa-user"></i> <span>System User</span>
						<span class="pull-right-container">
						<i class="fa-light fa-angle-down"></i>
						</span>
						</a>
						<ul class="treeview-menu" <?php if($fname=='admins.php'){echo "style='display:block;'";} ?>>
						    <li class="menu-item">
							<a href="admins.php" class="menu-link <?php if($fname=='admins.php'){ ?>active<?php } ?>">
							<i class="fa-regular fa-wave-pulse"></i> Admins</a>
							</li>
						</ul>
					</li>
				    <hr>
					<li class="menu-item">
						<a href="category.php" class="menu-link <?php if($fname=='category.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-box"></i> <span>Category</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="appointments.php" class="menu-link <?php if($fname=='appointments.php'){ ?>active<?php } ?>">
						<i class="fa-regular fa-calendar-days"></i> <span> Appointment</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="conditions.php" class="menu-link <?php if($fname=='conditions.php'){ ?>active<?php } ?>">
						<i class="fa-regular fa-square-plus"></i> <span> Conditions</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="treatments.php" class="menu-link <?php if($fname=='treatments.php'){ ?>active<?php } ?>">
						<i class="fa-regular fa-square-plus"></i> <span> Treatments</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="doctors.php" class="menu-link <?php if($fname=='doctors.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-user-doctor"></i> <span> Doctors</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="hospitals.php" class="menu-link <?php if($fname=='hospitals.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-hospital"></i> <span> Hospital</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="sliders.php" class="menu-link <?php if($fname=='sliders.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-image"></i> <span> Slider</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="blogs.php" class="menu-link <?php if($fname=='blogs.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-image"></i> <span> Blogs</span>
						</a>
					</li>
					<li class="menu-item">
						<a href="review.php" class="menu-link <?php if($fname=='review.php'){ ?>active<?php } ?>">
						<i class="fa-light fa-star"></i> <span> Review</span>
						</a>
					</li>
					
					
					<hr>
					<li class="menu-item">
						<a href="settings.php" class="menu-link">
						<i class="fa-light fa-gear"></i> <span> Setting</span>
						</a>
					</li>              
			    </ul>
		    </div>
		</div>
    </section>	
</aside>