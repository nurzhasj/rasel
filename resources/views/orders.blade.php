<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Services - Order</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add additional custom styles if needed */
        .container {
            margin-top: 20px;
        }
    </style>
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

    <div class="container">
        @if(auth()->user()->id == 1)
            <h1 class="mb-4">Дэшборд</h1>
        @else
            <h1 class="mb-4">Онлайн услуги</h1>
        @endif

        @if(auth()->user()->id == 1)
            <p>Здесь вы можете видеть все заявки на документы.</p>
        @else
            <p>Здесь вы можете видеть все ваши документы.</p>
        @endif


        <nav class="nav nav-pills mb-3">
            @if(auth()->user()->id == 1)
                <a class="nav-item nav-link {{ request()->is('orders') ? 'active' : '' }}" href="{{ url('/orders') }}">Запросы</a>
                <a class="nav-item nav-link {{ request()->is('users') ? 'active' : '' }}" href="{{ url('/users') }}">Студенты</a>
            @else
                <a class="nav-item nav-link {{ request()->is('send-order') ? 'active' : '' }}" href="{{ url('/send-order') }}">Заказать</a>
                <a class="nav-item nav-link {{ request()->is('orders') ? 'active' : '' }}" href="{{ url('/orders') }}">Мои Заказы</a>
            @endif
        </nav>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    @if(auth()->user()->id == 1)
                        <th>Username</th>
                    @endif
                    <th>Заказ</th>
                    <th>Язык</th>
                    <th>Способ получения</th>
                    <th>Дата заказа</th>
                    <th>Статус</th>
                    <th>PDF</th>
                    <th>Подписан</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if(auth()->user()->id == 1)
                            <td>{{ $order->user->username }}</td>
                        @endif
                        <td>{{ $order->order_type }}</td>
                        <td>{{ $order->language }}</td>
                        <td>{{ $order->delivery_method }}</td>
                        <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        <td style="color: {{ $order->status == 'ready' ? 'green' : 'red' }};">
                            {{ ucfirst($order->status) }}
                        </td>
                        <td>
                            @if(auth()->user()->id == 1 && !$order->file)
                                <input type="file" id="pdf_{{ $order->id }}" style="display: none;" onchange="uploadPDF({{ $order->id }})" accept="application/pdf">
                                <button onclick="document.getElementById('pdf_{{ $order->id }}').click()" class="btn btn-primary btn-sm">Загрузить PDF</button>
                            @elseif(auth()->user()->id != 1 && !$order->file)
                                <a href="{{ route('orders.downloadPdf', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <img src='https://img.freepik.com/free-vector/loading-circles-blue-gradient_78370-2646.jpg' alt="" width="20px" height="20px">
                                </a>
                            @else
                                <a href="{{ route('orders.downloadPdf', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <img src='https://cdn-icons-png.freepik.com/256/9034/9034421.png' alt="" width="20px" height="20px">
                                </a>
                            @endif
                        </td>
                        <td>
                            <!-- Logic to display if the order is signed -->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and its dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function uploadPDF(orderId) {
        const formData = new FormData();
        const fileInput = document.getElementById('pdf_' + orderId);
        if(fileInput.files.length === 0){
            alert('Please select a file.');
            return;
        }
        formData.append('pdf', fileInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '/orders/' + orderId + '/upload', // Your route to upload the PDF
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('File uploaded successfully.');
                window.location.reload(); // Refresh the page to update the file link
            },
            error: function (response) {
                // You might want to be more specific with error messages in a production environment
                alert('An error occurred. ' + response.responseText);
            }
        });
    }

</script>
</body>
</html>
