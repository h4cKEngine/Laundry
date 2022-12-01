<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include("head")
    <head>
        <title>Laundry</title>
    </head>

    <body class="antialiased">
        @include("navbar")
    
        <h1><b>Guest</b></h1>
        @for ($i=0; $i<29; $i++)
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum architecto aspernatur consequatur animi nobis ad blanditiis explicabo ipsum ipsa atque optio, obcaecati sit. Beatae a repellat itaque magnam nostrum. Magni.</p>
        @endfor
    </body>
</html>
