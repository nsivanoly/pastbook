<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid">
    <h1>Hello {{ $user->name }}!</h1>
    @if (count($user->user_images))
    <div class="row">
        @foreach ($user->user_images as $user_image)
        <div class="col-sm-3 m-2 p-2">
            <img src="{{ $user_image->source }}" alt="">
        </div>
        @endforeach
    </div>
    @endif
</div>

</body>
</html>
