<form name="newProject" method="POST" enctype="multipart/form-data" class="ng-cloak" >
    <div class="form-group">
        <p class="lead">Envio arquivo com usuários a serem adicionados ao projeto</p>
        <div class="form-inline">
            <input nv-file-select uploader="uploader" options="file" type="file" name="userFile" class="form-control btn-file mr-sm-2" >
            <ul class="list-inline">
                <li class="list-inline-item" ng-repeat="item in uploader.queue">
                    <button class="btn btn-primary" ng-click="item.upload()">upload</button>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:{{fileUploadProgress}}%" ></div>
                    </div>
                </li>                
            </ul>
            <input type="hidden" ng-model="page.projectData.company" ng-value="page.projectData.company" /> 
            <input type="hidden" ng-model="page.projectData.model" 
            ng-value="page.projectData.model" />             
        </div>
    </div><!-- formulário de upload -->
</form>