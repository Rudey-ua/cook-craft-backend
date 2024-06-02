<!DOCTYPE html>
<html>
<head>
    <title>Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
        }

        .info, .reminders {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 0;
        }

        .info h3 {
            margin-top: 0;
        }

        .reminder-item img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        .reminder-item span {
            display: inline-block;
            vertical-align: middle;
        }
        .social-link img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<div class="container">

    <div style="margin-bottom: 20px" class="info">
        <h1>{{ $recipe->title }}</h1>
        <p><strong>Description: </strong> {{ $recipe->description }}</p>
        <p><strong>Cooking Time: </strong> {{ $recipe->cooking_time }} minutes</p>
        <p><strong>Difficult: </strong> {{ $recipe->difficulty_level }}</p>
        <p><strong>Portions: </strong> {{ $recipe->portions }}</p>
    </div>
</div>
</body>
</html>
