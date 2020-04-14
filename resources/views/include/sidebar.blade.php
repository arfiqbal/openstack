<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
          
            <div class="sb-sidenav-menu-heading">Openstack</div>
            <a class="nav-link" href="{{route('allVM')}}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-server"></i>
                </div>
                View All Instances
            </a>
            <a class="nav-link" href="{{route('createVM')}}">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-laptop-code"></i>
                </div>
                Add Instance
            </a>
            <a class="nav-link" href="{{route('addImage')}}">
                <div class="sb-nav-link-icon">
                    <i class="fab fa-adn"></i>
                </div>
                Add Application
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{Auth::user()->name}}
    </div>
</nav>