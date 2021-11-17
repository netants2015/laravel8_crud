<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 CRUD Application - 无涯教程</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Laravel 8 Pagination Example - 无涯教程</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th width="300px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data) && $data->count())
                @foreach($data as $key => $value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td>
                            <a href="{{ route('user.create') }}" class="btn btn-success">Add</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $data->links() !!}
</div>
</body>
</html>
