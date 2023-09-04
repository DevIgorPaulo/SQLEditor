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
        <div class="card-header bg-dark">
            <button class="btn btn-lg btn-warning" title="Executar Query" ng-click="executaQuery()"><i class="fa fa-bolt" aria-hidden="true"></i></button>
            <button class="btn btn-lg btn-dark" title="Modo Escuro" ng-click="!darkMode"><i class="fa fa-moon-o" aria-hidden="true"></i></button>
        </div>
        <div ng-class="{ 'card-body bg-secondary': darkMode, 'card-body bg-light': !darkMode }">
            <div class="row">
                <form name="formSql">
                    <textarea name="sql" id="sql" cols="30" ng-attr-rows="{{linhasTextarea}}" ng-class="{ 'form-control bg-dark text-white': darkMode, 'form-control bg-light text-dark': !darkMode }" ng-model="sql"></textarea>
                </form>
            </div>
            <div class="row" style="margin-top: 1%" ng-show="resultados">
                <div class="col-lg-12">
                    <table ng-table="tableParams" name="dados" class="table table-bordered table-striped">
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
                    <table ng-table="tableParams" name="erro" style="color: red" class="table table-bordered table-striped">
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
            $scope.sql = '';
            $scope.resultados = [];
            $scope.erro = '';
            $scope.linhasTextarea = 21;
            $scope.darkMode = true; 

            $scope.executaQuery = function() {
                if ($scope.sql != '') {
                    $scope.resultados = [];
                    $scope.erro = '';
                    $http.post("../Controller/DAOEditorSQL.Class.php?funcao=executaQueryController", $scope.sql).then(function(response) {
                        if (response.data.sucesso == true) {
                            $scope.resultados = response.data.dados;
                        } else if (response.data.sucesso == false) {
                            $scope.erro = response.data.dados;
                        }

                        $scope.linhasTextarea = 17;
                    })

                }
            }

            document.addEventListener("keydown", function(event) {

                if ((event.ctrlKey || event.metaKey) && event.keyCode === 13) {

                    $scope.executaQuery();

                    event.preventDefault();
                }
            });

            document.addEventListener("keydown", function(event) {
                // Verifica se a tecla Ctrl (ou Command em Mac) está pressionada e se a tecla B (código 66) também foi pressionada
                if ((event.ctrlKey || event.metaKey) && event.keyCode === 66) {
                    // Insira uma quebra de linha no textarea
                    var textarea = document.getElementById('sql');

                    var text = textarea.value;



                    var keywords = [
                        "SELECT",
                        "FROM",
                        "INNER JOIN",
                        "LEFT JOIN",
                        "RIGHT JOIN",
                        "WHERE",
                        "AND",
                        "OR"
                    ];

                    // Iterar pelas palavras-chave
                    for (var i = 0; i < keywords.length; i++) {
                        var keyword = keywords[i];
                        var regex = new RegExp(keyword, "gi");

                        // Substituir a palavra-chave por quebra de linha + palavra-chave + quebra de linha
                        text = text.replace(regex, "\n" + keyword + "\n");
                    }

                    textarea.value = text;

                    event.preventDefault();
                }
            });

        });
</script>

</html>