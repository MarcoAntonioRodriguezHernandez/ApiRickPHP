<?php include 'templates/header.blade.php';

initial(1);
?>
<a href="organized.php">
    <button class="btn btn-warning">Organizar</button>
</a><br>
<a href="locations.php">
    <button class="btn btn-warning">Locaciones</button>
</a><br>
<a href="chapters.php">
    <button class="btn btn-warning">Capitulos</button>
</a><br>
<table class="tableContainer">
    <thead>
    <tr>
        <td>
            <main>
                <?php
                allCharacters(initial(2));
                ?>
            </main>
        </td>
        <td valign="top" align="center">
            <div id="charactersDay">
                <h3 id="pD">Personajes del día</h3>
                <?php
                randomCharacters();
                ?>
            </div>
        </td>
    </tr>
    </thead>
</table><br>

<?php include 'templates/footer.blade.php'; ?>

<?php
function allCharacters($data)
{

    foreach ($data as $character) {
        echo '<article>';
        echo '<div class="card">';
        echo '<img src="' . $character['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $character['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $character['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $character['species'] . '</p>';
        echo '<a href="showMore.php?id='.$character['id'].'" type="button" class="btn btn-primary">Ver más</a>';
        echo '</div>';
        echo '</article>';
        echo "<script>
                    document.getElementById('{$character['id']}').addEventListener('click', function() {
                        window.location.href = `showMore.php?character={$character['id']}`;
                    });
                </script>";
    }
}

function randomCharacters()
{
    for ($j = 0; $j < 5;) {
        $randomCharacter = numberCharacters(1, rand(1, numberCharacters(0, 0)));
        echo '<article>';
        echo '<div class="card">';
        echo '<img src="' . $randomCharacter['image'] . '" alt="Avatar" style="width:100%">';
        echo '<p><b>Nombre: </b>' . $randomCharacter['name'] . '</p>';
        echo '<p><b>Estado: </b>' . $randomCharacter['status'] . '</p>';
        echo '<p><b>Especie: </b>' . $randomCharacter['species'] . '</p>';
        echo '</div>';
        echo '</article>';
        $j++;
    }
}


function initial($mode)
{
    if ($mode === 1) {
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/character";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        if (curl_errno($channel)) {
            $msg = curl_error($channel);
            echo 'Error al conectarse: ' . curl_error($channel);
        } else {
            curl_close($channel);
            $data = json_decode($response, true);
        }
        return $data['info']['pages'];
    } else {
        $j = '';
        for ($i = 1; $i < 827; $i++) {
            $j .= $i . ',';
        }
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/character/$j";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        if (curl_errno($channel)) {
            $msg = curl_error($channel);
            echo 'Error al conectarse: ' . curl_error($channel);
        } else {
            curl_close($channel);
            $data = json_decode($response, true);
        }
        return $data;
    }
}

function numberCharacters($mode, $random)
{
    if ($mode === 0) {
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/character";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        curl_close($channel);
        $data = json_decode($response, true);
        return $data['info']['count'];
    } else {
        $channel = curl_init();
        $url = "https://rickandmortyapi.com/api/character/$random";
        curl_setopt($channel, CURLOPT_URL, $url);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($channel);
        curl_close($channel);
        $data = json_decode($response, true);
        return $data;
    }
}

?>
