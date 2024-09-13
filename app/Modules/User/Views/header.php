<!-- header.php -->
<!DOCTYPE html>
<html lang="pt-BR" ng-app="userApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular-route.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url('assets/modules/users/app.js'); ?>"></script>
    <style>
        body {
            padding-top: 70px;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            height: 100%;
            width: 250px;
            margin-left: -250px;
            background-color: #f8f9fa;
            padding: 20px;
            transition: margin 0.3s;
        }
        .sidebar.fixed {
            margin-left: 0;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar fixed">
        <h2>Menu</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/clients/">Clientes</a>
                <a class="nav-link active" href="/users/">Usuários</a>
            </li>
        </ul>
    </div>
    <div class="main-content">
