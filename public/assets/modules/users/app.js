var app = angular.module('userApp', []);

app.controller('UserController', ['$scope', 'UserService', function($scope, UserService) {
    $scope.users = [];
    $scope.newUser = {};
    $scope.errors = {};

    $scope.loadUsers = function() {
        UserService.getUsers().then(function(response) {
            $scope.users = response.data;
        }, function(error) {
            console.error('Error loading users:', error);
        });
    };

    $scope.saveUser = function() {
        UserService.saveUser($scope.newUser).then(function() {
            $scope.loadUsers();
            $scope.newUser = {};
            $scope.errors = {};
        }, function(error) {
            if (error.status === 400) {
                $scope.errors = error.data.errors || {};
            } else {
                console.error('Error saving user:', error);
            }
        });
    };

    // Editar usuário
    $scope.edit = function(user) {
        $scope.newUser = {
            id: user.id,
            username: user.username,
            email: user.email,
            password: ''
        };
        $scope.errors = {}; // Limpar erros
        $scope.errors = {};
    };

    // Remover usuário
    $scope.remove = function(id) {
        UserService.deleteUser(id).then(function() {
            $scope.loadUsers();
        }, function(error) {
            console.error('Error removing user:', error);
        });
    };

    // Inicializar
    $scope.loadUsers();
}]);

app.factory('UserService', ['$http', function($http) {
    return {
        getUsers: function() {
            return $http.get('/users/list');
        },
        saveUser: function(user) {
            return $http.post('/users/addOrEdit/', user);
        },
        deleteUser: function(id) {
            return $http.delete('/users/delete/' + id);
        }
    };
}]);
