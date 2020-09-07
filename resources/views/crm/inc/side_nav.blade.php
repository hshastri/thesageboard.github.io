<!-- Sidebar mobile toggler -->
<div class="sidebar-mobile-toggler text-center">
	<a href="#" class="sidebar-mobile-main-toggle">
		<i class="icon-arrow-left8"></i>
	</a>
	Navigation
	<a href="#" class="sidebar-mobile-expand">
		<i class="icon-screen-full"></i>
		<i class="icon-screen-normal"></i>
	</a>
</div>
<!-- /sidebar mobile toggler -->
<!-- Sidebar content -->
<div class="sidebar-content">
	<!-- Main navigation -->
	<div class="card card-sidebar-mobile">
		<ul class="nav nav-sidebar" data-nav-type="accordion">
			<!-- Main -->
			<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
			<li class="nav-item">
				<a href="{{route('crm.dashboard')}}" class="nav-link {{ areActiveRoutes(['crm.dashboard'])}}">
					<i class="icon-home4"></i>
					<span>
						Dashboard
					</span>
				</a>
			</li>

			<li class="nav-item nav-item-submenu {{ areActiveNavs(['category.index','subcategory.index','tags.index','question.index','question.create','question.edit'])}}">
				<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Questions</span></a>

				<ul class="nav nav-group-sub" data-submenu-title="Layouts">
					<li class="nav-item"><a href="{{route('category.index')}}" class="nav-link {{ areActiveRoutes(['category.index'])}}">Category</a></li>
					<li class="nav-item"><a href="{{route('subcategory.index')}}" class="nav-link {{ areActiveRoutes(['subcategory.index'])}}">Subcategory</a></li>
					<li class="nav-item"><a href="{{route('tags.index')}}" class="nav-link {{ areActiveRoutes(['tags.index'])}}">Tags</a></li>
					<li class="nav-item"><a href="{{route('question.index')}}" class="nav-link {{ areActiveRoutes(['question.index','question.create','question.edit'])}}">Admin Questions</a></li>
				</ul>
			</li>

            <li class="nav-item nav-item-submenu {{ areActiveNavs(['users.index', 'invite.index','badge.index'])}}">
                <a href="#" class="nav-link"><i class="icon-user"></i> <span>Users</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a href="{{route('invite.index')}}" class="nav-link {{ areActiveRoutes(['invite.index'])}}">Invite User</a></li>
                    <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link {{ areActiveRoutes(['users.index'])}}">User List</a></li>
                    <li class="nav-item"><a href="{{route('badge.index')}}" class="nav-link {{ areActiveRoutes(['badge.index'])}}">Badge Config</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{route('crm.ask-question')}}" class="nav-link {{ areActiveRoutes(['crm.ask-question','crm.questions.details'])}}">
                    <i class="icon-question3"></i>
                    <span>
						User Ask Question
					</span>
                </a>
            </li>

            <li class="nav-item nav-item-submenu {{ areActiveNavs(['crm.transaction', 'crm.withdrawal-requests', 'crm.refund-requests', 'crm.refund-details'])}}">
                <a href="#" class="nav-link"><i class="icon-paypal"></i> <span>Payment Details</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a href="{{route('crm.transaction')}}" class="nav-link {{ areActiveRoutes(['crm.transaction'])}}">Transaction Details</a></li>
                    <li class="nav-item"><a href="{{route('crm.withdrawal-requests')}}" class="nav-link {{ areActiveRoutes(['crm.withdrawal-requests'])}}">Withdrawals</a></li>
                    <li class="nav-item"><a href="{{route('crm.refund-requests')}}" class="nav-link {{ areActiveRoutes(['crm.refund-requests'])}}">Refunds</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{route('crm.user-feedback')}}" class="nav-link {{ areActiveRoutes(['crm.user-feedback'])}}">
                    <i class="icon-point-right"></i>
                    <span>
						User Feedback
					</span>
                </a>
            </li>


            {{--Settings Menu Start--}}
            <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Settings</div> <i class="icon-menu" title="Main"></i></li>
            <li class="nav-item nav-item-submenu {{ areActiveNavs(['crm.payment_settings','crm.business_settings'])}}">
                <a href="#" class="nav-link"><i class="icon-wrench3"></i> <span> Basic Settings</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a href="{{route('crm.payment_settings')}}" class="nav-link {{ areActiveRoutes(['crm.payment_settings'])}}">Payment Method</a></li>
                    <li class="nav-item"><a href="{{route('crm.business_settings')}}" class="nav-link {{ areActiveRoutes(['crm.business_settings'])}}">Business Settings</a></li>
                   {{-- <li class="nav-item"><a href="" class="nav-link ">SMTP Settings</a></li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link">Email Template Settings</a>
                        <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="" class="nav-link">Invitation Mail Template</a></li>
                        </ul>
                    </li>--}}
                </ul>
            </li>


            <li class="nav-item nav-item-submenu {{ areActiveNavs(['crm.policy_settings',])}}">
                <a href="#" class="nav-link"><i class="icon-wrench3"></i> <span> Frontend Settings</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    <li class="nav-item"><a href="" class="nav-link ">General Settings</a></li>
                    <li class="nav-item"><a href="" class="nav-link">About Us Page</a></li>
                    <li class="nav-item"><a href="{{route('crm.policy_settings')}}" class="nav-link {{ areActiveRoutes(['crm.business_settings'])}}">Policy Page</a></li>
                </ul>
            </li>
			<!-- /page kits -->

		</ul>
	</div>
	<!-- /main navigation -->
</div>
<!-- /sidebar content -->
