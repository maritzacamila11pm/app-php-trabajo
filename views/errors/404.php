<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - 404</title>
    <style>
        body {
            background-color: #f0f4f8;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            color: #333;
            text-align: center;
        }

        h1 {
            font-size: 5em;
            color: #ff6347;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 40px;
            max-width: 600px;
        }

        img {
            max-width: 60%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .button {
            padding: 12px 24px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1.1em;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .button:hover {
            background-color: #ff4500;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1>PÁGINA NO ENCONTRADA</h1>
    <p>Lo sentimos, la página que estás buscando no existe. Compruebe la URL o vuelva a la página de inicio.</p>
    <img src="https://test.com.uy/img/404.gif" alt="404 Error Image">
    <a href="http://localhost/app-php-mvc-senati/login" class="button">Volver al inicio</a>
</body>
</html>
