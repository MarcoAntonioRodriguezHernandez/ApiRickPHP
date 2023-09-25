<?php include 'templates/header.blade.php'; ?>
<a href="index.php">
    <button class="btn btn-warning">Regresar</button>
</a><br>
<table class="tableContainer">
    <thead>
    <tr>
        <td>
            <main>
                <?php
                $char = printCharacters(organize(initial2(2), 'species'));
                ?>>
            </main>
        </td>
    </tr>
    </thead>
</table><br>
<?php include 'templates/footer.blade.php';

function initial2($mode)
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
            $j .= $i.',';
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

function printCharacters($data)
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

function organize($characters, $species)
{
    $temp = [];
    foreach ($characters as $key => $value)
        $temp[$value[$species] . "oldkey" . $key] = $value;
    ksort($temp);
    $array = array_values($temp);
    unset($temp);
    return $array;
}

?>

