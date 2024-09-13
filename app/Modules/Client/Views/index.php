<!-- content.html -->
<div class="container" ng-controller="ClientesController">
            <header class="mb-4">
                <h1>Clientes</h1>
            </header>

            <!-- Formulário de Busca -->
            <form class="d-flex mb-4">
                <input class="form-control me-2" type="search" ng-model="searchTerm" placeholder="Buscar Cliente">
                <button class="btn btn-primary" type="button">Buscar</button>
            </form>

            <!-- Formulário de Cadastro -->
            <form class="mb-4" action="/clients/add" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Cadastro de Cliente</legend>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" name="name" type="text" placeholder="Nome" class="form-control" ng-model="newCliente.name" required>
                    </div>

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input id="cnpj" name="cnpj" type="text" placeholder="CNPJ" class="form-control" ng-model="newCliente.cnpj" required>
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input id="logo" name="logo" type="file" class="form-control" ng-model="newCliente.logo">
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                </fieldset>
            </form>

            <!-- Tabela de Clientes -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Logo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="cliente in clientes | filter:searchTerm">
                        <td>{{ cliente.id }}</td>
                        <td>{{ cliente.name }}</td>
                        <td>{{ cliente.cnpj }}</td>
                        <td><img ng-src="/{{ cliente.logo }}" alt="Logo" width="50"></td>
                        <td>
                            <button class="btn btn-warning btn-sm" ng-click="edit(cliente)">Editar</button>
                            <button class="btn btn-danger btn-sm" ng-click="remove(cliente.id)">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <button class="btn btn-success me-2" ng-click="exportToCSV()">Exportar para Excel</button>
                <button class="btn btn-info" ng-click="printTable()">Imprimir Tabela</button>
            </div>
        </div>
    </div>
</body>
</html>
