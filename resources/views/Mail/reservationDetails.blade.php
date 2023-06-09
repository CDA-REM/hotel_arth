<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Venez séjourner à l'Hôtel Arth. Situé près du lac d'Annecy, notre personnel
        vous accueille pour vos séjour détente ou business. Dans une ambiance douce et reposante, profitez de nuits de
        repos dans nos chambres parfaitement insonorisées. Le Chef vous fera découvrir ses délices. Envie d'une
        expérience inoubliable ? Réservez votre accès à la piscine de l'hôtel, située sur le rooftop.">
        <meta name="keywords" content="hôtel, repos, dépaysement, voyage, séjour, Annecy, lac, lac d'Annecy, dormir,
        famille, déplacement professionnel, où dormir, hôtel-restaurant, suite, réception, piscine, rooftop, toit
        accessible, vue sur les montagnes">
        <title>Hôtel Arth</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/pictures/favicon.png') }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
        <!-- Styles -->
        <style>
        </style>
    </head>
    <body class="antialiased">
        <p>Hey! Thank you for your reservation for the {{$checkin}}.</p>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{$reservation_id}}">
    </body>
</html>