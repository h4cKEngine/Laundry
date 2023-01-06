<div id="info_account">
    <table style="margin: 0 auto;">
        <caption>Info Account</caption>
        <tr>
            <th style="text-align: left;">Id</th>
            <th style="text-align: left;">ID number</th>
            <th style="text-align: left;">Role</th>
            <th style="text-align: left;">Name</th>
            <th style="text-align: left;">Surname</th>
            <th style="text-align: left;">Email</th>
            <th style="text-align: left;">Nationality</th>
        </tr>
        <tr>
            @php
                echo "<td id='user_id'>" . Auth::user()->id . "</td>" .
                        "<td id='user_matricola'>" . Auth::user()->matricola . "</td>" .
                        "<td id='user_ruolo'>" . Auth::user()->ruolo . "</td>" . 
                        "<td id='user_nome'>" . Auth::user()->nome . "</td>" . 
                        "<td id='user_cognome'>" . Auth::user()->cognome . "</td>" . 
                        "<td id='user_email'>" . Auth::user()->email . "</td>" . 
                        "<td id='user_nationalita'>" . Auth::user()->nazionalita . "</td>";
            @endphp
        </tr>
    </table>
</div>