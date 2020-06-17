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
            {{--  <a class="nav-link" href="{{route('addImage')}}">
                <div class="sb-nav-link-icon">
                    <i class="fab fa-adn"></i>
                </div>
                Add Application
            </a>  --}}
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon">
                    <i class="fas fa-columns"></i>
                </div>
                Application Image
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('allImages')}}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-table"></i>
                        </div>
                        All Images
                    </a>
                    <a class="nav-link" href="{{route('addImage')}}">
                        <div class="sb-nav-link-icon">
                            <i class="fab fa-adn"></i>
                        </div>
                        Add Images
                    </a>
                </nav>
            </div>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{Auth::user()->name}}
    </div>
</nav>