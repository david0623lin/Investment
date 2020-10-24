<nav class="navbar navbar-expand-lg  bg-dark navbar-dark">
	<a class="navbar-brand" href="#">股票後台</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="main_nav">
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">股票管理 </a>
				<ul class="dropdown-menu" role="menu">
					<li><a class="dropdown-item" href="{{action('TicketController@run')}}">觀察列表</a></li>
				</ul>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">監控管理 </a>
				<ul class="dropdown-menu" role="menu">
					<li><a class="dropdown-item" href="{{action('MonitorController@run')}}">設定監控</a></li>
				</ul>
			</li>
		</ul>
	</div> <!-- navbar-collapse.// -->
</nav>