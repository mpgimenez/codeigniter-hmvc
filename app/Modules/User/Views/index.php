<!-- index.php -->
<div class="container" ng-controller="UserController">
    <header class="mb-4">
        <h1>Gerenciamento de Usuários</h1>
    </header>

    <!-- Formulário de Busca -->
    <form class="d-flex mb-4">
        <input class="form-control me-2" type="search" ng-model="searchTerm" placeholder="Buscar Usuário">
        <button class="btn btn-primary" type="button" ng-click="search()">Buscar</button>
    </form>

    <!-- Formulário de Cadastro -->
    <form class="mb-4" ng-submit="saveUser()">
        <fieldset>
            <legend>Cadastro de Usuário</legend>

            <div class="mb-3">
                <label for="username" class="form-label">Nome de Usuário</label>
                <input id="username" name="username" type="text" placeholder="Nome de Usuário" class="form-control"
                    ng-model="newUser.username" required>
                <div class="text-danger" ng-if="errors.username">{{ errors.username[0] }}</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" placeholder="Email" class="form-control"
                    ng-model="newUser.email" required>
                <div class="text-danger" ng-if="errors.email">{{ errors.email[0] }}</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input id="password" name="password" type="password" placeholder="Senha" class="form-control"
                    ng-model="newUser.password">
                <div class="text-danger" ng-if="errors.password">{{ errors.password[0] }}</div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </fieldset>
    </form>

    <!-- Tabela de Usuários -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome de Usuário</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="user in users | filter:searchTerm">
                <td>{{ user.id }}</td>
                <td>{{ user.username }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" ng-click="edit(user)">Editar</button>
                    <button class="btn btn-danger btn-sm" ng-click="remove(user.id)">Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>