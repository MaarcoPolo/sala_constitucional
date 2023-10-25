<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Usuario Nuevo</title>
</head>
<body>

    <div class="card-container">
        <div class="container-text"> 
            <p>Este es tu usuario y contraseña para acceder al sistema de Sala consitucional del Poder Judicial del Estado de Puebla</p>
            <p><strong>Usuario:</strong> {{$user}}</p>
            <p><strong>Contraseña:</strong> {{$pass}}</p> 
            <p>Recuerda que el usuario y contraseña es solo para el titular de la cuenta y su buen uso es responsabilidad del mismo.</p>
            <p>Recibiste este mensaje porque te registraron en uno de los sistemas de uso interno del Poder Judicial del Estado de Puebla.<br>
            Este correo electrónico solo se utiliza para enviar información, por lo que agradeceremos que no se conteste este mensaje.</p>
        </div>  
    </div>    
</body>
</html>