<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Subscription!</title>
</head>

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Arial', sans-serif;
        overflow: hidden;
    }
    .thank-you-container {
        background-color: #f4f4f9;
        color: #333;
        text-align: center;
        padding: 20px;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
    }
    h1 {
        color: #5d5c61;
    }
    p {
        color: #404040;
        margin: 10px auto;
        max-width: 400px;
    }
    .home-button {
        padding: 10px 20px;
        background-color: #C610F5FF;
        color: white;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 16px;
        margin-top: 10px;
    }
    .logo {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
    }
</style>

<body>
<div class="thank-you-container">
    <img src="{{ url('storage/2024-06-02%2018.26.07.jpg') }}" alt="Logo" class="logo">

    <h1>Welcome to the Club!</h1>
    <p>Your subscription spices up our kitchen and helps us bring more delicious recipes to your table.</p>
    <a href="#" class="home-button">You can close this page!</a>
</div>
</body>
</html>
