<div id="info">
    <h2>
        <?php
            echo "Info Account " . $info_utente["nome"] . " " . $info_utente["cognome"];
        ?>
    </h2>
    <table>
        <tr>
            <th style="text-align: left;">ID number</th>
            <th style="text-align: left;">Email</th>
            <th style="text-align: left;">Nationality</th>
        </tr>
        <tr>
            <?php
                echo "<td>" . $info_utente['ID_utente'] . "</td>" . 
                        "<td>" . $info_utente['email'] . "</td>" . 
                        "<td>" . $info_utente['nazionalita'] . "</td>";
            ?>
        </tr>
    </table>
</div>