<div class="app-main">

    <section class="content">

        <div class="menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-text navbar-light">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" ng-repeat="nav in navs">
                            <a class="nav-link" href="{{nav.link}}">{{nav.title}}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- menu -->

        <div class="container">
            <div ng-view></div>
        </div><!-- container -->        

    </section>

</div>
<!-- main -->