<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor SQL</title>
    <script src="../Assets/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="../Assets/angular.js"></script>
    <link rel="stylesheet" href="../Assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ng-table/1.0.0/ng-table.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ng-table/1.0.0/ng-table.min.css">
</head>

<body class="bg-secondary" ng-controller="Controller">
    <div class="card bg-secondary">
        <div ng-class="{ 'card-header bg-dark': darkMode, 'card-header bg-secondary': !darkMode }">
            <button class="btn btn-lg btn-warning" title="Executar Query" ng-click="executaQuery()"><i class="fa fa-bolt" aria-hidden="true"></i></button>
            <button class="btn btn-lg btn-dark pull-right" title="Modo Escuro" ng-click="darkMode = !darkMode"><i class="fa fa-moon-o" aria-hidden="true"></i></button>
        </div>
        <div ng-class="{ 'card-body bg-secondary': darkMode, 'card-body bg-light': !darkMode }">
            <div class="row">
                <form name="formSql">
                    <textarea name="sql" id="sql" cols="30" ng-attr-rows="{{linhasTextarea}}" ng-class="{ 'form-control bg-dark text-white': darkMode, 'form-control text-dark': !darkMode }" ng-model="sql"></textarea>
                </form>
            </div>
            <div class="row" style="margin-top: 1%" ng-show="resultados">
                <div class="col-lg-12">
                    <table ng-table="tableParams" name="dados" ng-class="{ 'table table-dark table-striped table-bordered': darkMode, 'table table-striped table-bordered': !darkMode }">
                        <thead>
                            <tr>
                                <th ng-repeat="(chave, valor) in resultados[0]">{{ chave }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="resultado in resultados">
                                <td ng-repeat="(chave, valor) in resultado">{{ valor }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-top: 1%" ng-show="erro">
                <div class="col-lg-12">
                    <table ng-table="tableParams" name="erro" ng-class="{ 'table table-dark table-striped table-bordered': darkMode, 'table table-striped table-bordered': !darkMode }">
                        <thead>
                            <tr>
                                <th>Erro ao executar SQL:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ erro }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    angular.module('myApp', [])
        .controller('Controller', function($scope, $http) {
            $scope.db = '';
            $scope.tables = [];
            $scope.views = [];
            $scope.procedures = [];
            $scope.functions = [];            
            $scope.darkMode = true;      
            
            $scope.listaDB =  function(){
                $http.post("../Controller/DAODBList.Class.php?funcao=listaDBController", $scope.db).then(function(response){
                    if(response.data){
                        $scope.tables = response.data.Tables
                        $scope.views = response.data.Views
                        $scope.functions = response.data.Functions
                        $scope.procedures = response.data.Procedures
                    }
                })
            }

            $scope.listaDB();

        });
</script>

</html>