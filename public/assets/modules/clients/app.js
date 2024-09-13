var app = angular.module('clientesApp', []);

app.controller('ClientesController', ['$scope', 'ClientesService', function($scope, ClientesService) {
    $scope.clientes = [];
    $scope.newCliente = {};

    $scope.loadClientes = function() {
        ClientesService.getClientes().then(function(response) {
            $scope.clientes = response.data;
        }, function(error) {
            console.error('Error loading clientes:', error);
        });
    };

    $scope.addCliente = function() {
        if ($scope.newCliente.name && $scope.newCliente.cnpj) {
            var formData = new FormData();
            formData.append('name', $scope.newCliente.name);
            formData.append('cnpj', $scope.newCliente.cnpj);
            
            if ($scope.newCliente.logo) {
                formData.append('logo', $scope.newCliente.logo);
            }

            ClientesService.addCliente(formData).then(function(response) {
                console.log( formData )
                $scope.clientes.push(response.data);
            }, function(error) {
                console.error('Error adding cliente:', error);
            });
        }
    };

    // Edit cliente
    $scope.edit = function(cliente) {
        $scope.newCliente = angular.copy(cliente);
    };

    $scope.remove = function(id) {
        ClientesService.removeCliente(id).then(function() {
            $scope.clientes = $scope.clientes.filter(cliente => cliente.id !== id);
        }, function(error) {
            console.error('Error removing cliente:', error);
        });
    };

    $scope.exportToCSV = function() {
        var csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "ID,Nome,CNPJ,Logo\n";
        $scope.clientes.forEach(function(cliente) {
            let logoUrl = window.location.host + "/" + cliente.logo; 
            csvContent += cliente.id + "," + cliente.name + "," + cliente.cnpj + "," + logoUrl + "\n";
        });

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "clientes.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    $scope.printTable = function() {
        var printContents = document.querySelector('table').outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload();
    };
    $scope.loadClientes();
}]);

app.factory('ClientesService', ['$http', function($http) {
    var apiUrl = '/clients';

    return {
        getClientes: function() {
            return $http.get(apiUrl + '/list');
        },
        addCliente: function(formData) {
            return $http.post(apiUrl + '/add', formData, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            });
        },
        removeCliente: function(id) {
            return $http.delete(apiUrl + '/remove/' + id);
        }
    };
}]);
