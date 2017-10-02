<div class="block card main" ng-controller="addProject">

    <div class="new-project">
        <h2>Novo Projeto - Etapa {{page.currentPage}}</h2>            
        <div ng-model="pageTemplate" ng-include="page.templateUrl"></div> 
    </div>

</div>
