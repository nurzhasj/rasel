<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Services - Order</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col text-right">
            <form action="{{ route('logout') }}" method="POST" class="d-inline-block mt-3 mr-3">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>

    <div class="container py-4">
        @if(auth()->user()->id == 1)
            <h1 class="mb-4">Дэшборд</h1>
        @else
            <h1 class="mb-4">Онлайн услуги</h1>
        @endif
        <p>Здесь вы можете заказать документы онлайн.</p>

        <!-- Navigation -->
        <nav class="nav nav-pills mb-3">
            <a class="nav-item nav-link {{ request()->is('send-order') ? 'active' : '' }}" href="{{ url('/send-order') }}">Заказать</a>
            <a class="nav-item nav-link {{ request()->is('orders') ? 'active' : '' }}" href="{{ url('/orders') }}">Мои Заказы</a>
        </nav>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Order Form -->
        <form action="{{ route('orders') }}" method="post" class="mb-3">
            @csrf
            <div class="form-group">
                <label for="order-type">Тип заказа</label>
                <select id="order-type" name="order_type" class="form-control">
                    <option value="транскрипт">Транскрипт</option>
                    <option value="справка о месте учебы">Справка о месте учебы</option>
                    <option value="справка военкомату">Справка военкомату</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Описание документа</label>
                <input type="text" id="description" name="description" class="form-control">
            </div>
            <div class="form-group">
                <label for="language">Язык</label>
                <select id="language" name="language" class="form-control">
                    <option value="Қазақша">Қазақша</option>
                    <option value="English">English</option>
                    <option value="Русский">Русский</option>
                </select>
            </div>
            <div class="form-group">
                <label for="delivery-method">Метод получения</label>
                <select id="delivery-method" name="delivery_method" class="form-control">
                    <option value="Онлайн">Онлайн</option>
                    <option value="Оффлайн">Оффлайн (Студ Центр)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Отправить</button>
        </form>

        <!-- Rules -->
        <div class="rules">
            <p>Дорогие студенты пожалуйста прочтите правила получение документов онлайн</p>
        </div>
    </div>
</div>


<!-- Bootstrap JS and its dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
