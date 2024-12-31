<!-- Header Navbar -->
<header class="navbar navbar-static-top">
	<div class="app-menu">
		<nav>
			<ol class="breadcrumb m-0">
				<li class="breadcrumb-item" aria-current="page">Application</li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $page_name; ?></li>
			</ol>
		</nav>
	</div>	
	
	<div class="ms-auto r-side">
		<ul class="nav">	
			<li class="dropdown user user-menu ">
				<a href="#" class="waves-effect waves-light dropdown-toggle zoom-in shadow-lg " data-bs-toggle="dropdown" title="User">
				<img src="img/logo-icon.png" width="32px" class="">
				</a>
				<ul class="dropdown-menu animated ">
					<li class="user-body">
						<a class="dropdown-item" href="#"><i class="ti-user text-muted me-2"></i> Profile</a>
						<a class="dropdown-item" href="#"><i class="ti-wallet text-muted me-2"></i> My Wallet</a>
						<a class="dropdown-item" href="#"><i class="ti-settings text-muted me-2"></i> Settings</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="logout.php"><i class="ti-lock text-muted me-2"></i> Logout</a>
					</li>
			    </ul>
			</li>
		</ul>
	</div>
</header>