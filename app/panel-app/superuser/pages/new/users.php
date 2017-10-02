<form name="newProject" method="POST" enctype="multipart/form-data" class="ng-cloak" >
    <div class="form-group">
        <p class="lead">Envio arquivo com usuários a serem adicionados ao projeto</p>
        <div uib-alert ng-repeat="alert in alerts" ng-class="'alert-' + (alert.type || 'warning')">
            {{alert.msg}}
        </div>
        <div class="form-inline">
            <input nv-file-select uploader="uploader" options="file" type="file" name="userFile" class="form-control btn-sm btn-file mr-sm-2" ng-model="fileInput" >            
            
            <div class="col" ng-repeat="item in uploader.queue">
                <div class="row">
                    
                    <button class="col-md-auto btn btn-primary" 
                            ng-click="item.upload()">upload</button>

                    <div class="col-9">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:{{fileUploadProgress}}%" >{{fileUploadProgress}}%</div>   
                        </div>
                    </div>                   

                </div>                                                 
            </div>               
                     
        </div>
    </div><!-- formulário de upload -->
</form>