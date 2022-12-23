<div id="info_account">
        @php
            echo "<h2>Info Account</h2>" . "<a>" . Auth::user()->nome . " " . Auth::user()->cognome . "</a>" ;
        @endphp
    <table>
        <tr>
            <th style="text-align: left;">Id</th>
            <th style="text-align: left;">ID number</th>
            <th style="text-align: left;">Email</th>
            <th style="text-align: left;">Nationality</th>
        </tr>
        <tr>
            @php
                echo "<td id='user_id'>" . Auth::user()->id . "</td>" .
                        "<td id='matricola'>" . Auth::user()->matricola . "</td>" . 
                        "<td id='user_email'>" . Auth::user()->email . "</td>" . 
                        "<td id='user_nationalita'>" . Auth::user()->nazionalita . "</td>";
            @endphp
        </tr>
    </table>
</div>