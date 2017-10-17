<div class="app-main">

    <section class="content">

        <div ng-controller="showComponents">

            <human-resources-app ng-if="isResponsible"></human-resources-app>

            <div class="container">
                <div ng-view ng-if="isResponsible == false"></div>
            </div><!-- container -->

        </div> 

    </section>

</div>
<!-- main -->