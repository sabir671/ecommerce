<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>
    <form method="POST" action="{{ route('roles.update', ['role' => $role->id]) }}">
    @csrf
    @method('put');
   <input type="text" name="name" placeholder="enter Your name" value='{{$role->name}}'><br/>
    <input type="text" name="title" placeholder="enter your title" value='{{$role->title}}'><br/>
    <input type="text" name="guard_name" placeholder="enter your guard_name" value='{{$role->guard_name}}'><br/>
    <!-- Add more input fields for other fields -->
    <button type="submit" class='btn btn-info'>Edit</button>
    </form>

        <script src="" async defer></script>
    </body>
</html>
