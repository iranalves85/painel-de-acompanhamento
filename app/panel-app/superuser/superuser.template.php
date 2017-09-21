<div class="app-main">

    <header class="topo">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <img src="assets/images/gptw-logo-app.png" width="45px" alt="GPTW - Painel de Acompanhamento" /><strong class="panel-name">Painel de Acompanhamento</strong>
                </div>
                <div class="col-6">
                    <ul class="list-inline float-right">
                        <li class="list-inline-item btn btn-sm">Bem vindo, <b>{{manager.user}}</b></li>
                        <li class="list-inline-item"><a class="btn btn-sm btn-outline-light" href="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

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

        <div ng-view></div>
        <!-- carrega templates -->

    </section>

</div>
<!-- main -->

<footer class="footer">
    <div class="row">
        <div class="col-12">
            <h6>
                GPTW - Painel de Acompanhamento - v0.1
            </h6>
        </div>
    </div>
</footer>