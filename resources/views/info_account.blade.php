<div id="info">
        @php
            echo "<h2>Info Account " . Auth::user()->nome . " " . Auth::user()->cognnome . "</h2>";
        @endphp
    <table>
        <tr>
            <th style="text-align: left;">ID number</th>
            <th style="text-align: left;">Email</th>
            <th style="text-align: left;">Nationality</th>
        </tr>
        <tr>
            @php
                echo "<td>" . Auth::user()->matricola . "</td>" . 
                        "<td>" . Auth::user()->email . "</td>" . 
                        "<td>" . Auth::user()->nazionalita . "</td>";   
            @endphp
        </tr>
    </table>
</div>