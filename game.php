<?php
session_start();

// Preberemo vrednosti iz obrazca (če obstajajo)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['ime1'] = !empty($_POST['ime1']) ? $_POST['ime1'] : 'Igralec 1';
    $_SESSION['ime2'] = !empty($_POST['ime2']) ? $_POST['ime2'] : 'Igralec 2';
    $_SESSION['ime3'] = !empty($_POST['ime3']) ? $_POST['ime3'] : 'Igralec 3';
    
    $_SESSION['kocke'] = isset($_POST['kocke']) ? (int)$_POST['kocke'] : 1;
    $_SESSION['igre'] = isset($_POST['igre']) ? (int)$_POST['igre'] : 1;
}

$stevilo_kock = $_SESSION['kocke'];
$stevilo_igre = $_SESSION['igre']; 
$igralci = [$_SESSION['ime1'], $_SESSION['ime2'], $_SESSION['ime3']];

$vsi_meti = []; 
$vsi_meti_plosko = [];

foreach ($igralci as $index => $igralec) {
    $vsi_meti[$index] = [];
    $vsi_meti_plosko[$index] = [];
    
    for ($igra = 0; $igra < $stevilo_igre; $igra++) {
        $meti_igre = [];
        for ($k = 0; $k < $stevilo_kock; $k++) {
            $met = rand(1, 6);
            $meti_igre[] = $met;
            $vsi_meti_plosko[$index][] = $met; 
        }
        $vsi_meti[$index][] = $meti_igre;
    }
}

$_SESSION['zadnji_rezultati'] = $vsi_meti_plosko;
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kocke - Metanje</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gameCSS.css">
</head>
<body>

    <h1 class="main-title" id="status-title" style="text-align: center;">PRIPRAVA...</h1>

    <div class="game-container">
        <div class="users-row">
            <?php foreach ($igralci as $index => $igralec): ?>
                <div class="user-box">
                    <h2><?php echo htmlspecialchars($igralec); ?></h2>
                    <div class="dice-container">
                        <?php for ($i = 0; $i < $stevilo_kock; $i++): ?>
                            <div class="die" data-player="<?php echo $index; ?>" data-dice-index="<?php echo $i; ?>">?</div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Uporabljamo klasične definicije funkcij (function name() { ... })
        // Namesto => puščic uporabljamo klasično 'function' besedo

        var numGames = <?php echo $stevilo_igre; ?>;
        var gameData = <?php echo json_encode($vsi_meti); ?>;
        var currentGame = 0;

        var allDice = document.querySelectorAll('.die');
        var statusTitle = document.getElementById('status-title');

        function zazeniIgro() {
            // Preverimo, če smo čez vse runde
            if (currentGame < numGames) {
                
                // 1. Nastavimo naslov
                if (numGames > 1) {
                    statusTitle.textContent = "IGRA " + (currentGame + 1) + "/" + numGames + " - MEŠANJE...";
                } else {
                    statusTitle.textContent = "Kocke se kotalijo...";
                }

                // 2. Sprožimo animacijo (razred rolling)
                for (var i = 0; i < allDice.length; i++) {
                    allDice[i].classList.add('rolling');
                    allDice[i].style.color = "#4a148c";
                }

                // 3. Hitro menjanje številk (vizualni efekt)
                var rollInterval = setInterval(function() {
                    for (var j = 0; j < allDice.length; j++) {
                        allDice[j].textContent = Math.floor(Math.random() * 6) + 1;
                    }
                }, 80);

                // 4. Po 2.5 sekundah ustavimo rundo
                setTimeout(function() {
                    clearInterval(rollInterval);

                    for (var k = 0; k < allDice.length; k++) {
                        allDice[k].classList.remove('rolling');
                        
                        var pIndex = allDice[k].getAttribute('data-player');
                        var dIndex = allDice[k].getAttribute('data-dice-index');
                        
                        // Izpišemo pravi rezultat iz PHP matrike
                        allDice[k].textContent = gameData[pIndex][currentGame][dIndex];
                        allDice[k].style.color = "black";
                    }

                    currentGame++; // Gremo na naslednjo rundo

                    // 5. Če so še runde, počakamo pol sekunde (500ms) in pokličemo isto funkcijo še enkrat
                    if (currentGame < numGames) {
                        setTimeout(zazeniIgro, 500);
                    } else {
                        // Vse je končano
                        zakljuciVse();
                    }

                }, 2500);

            }
        }

        function zakljuciVse() {
            statusTitle.innerHTML = "VSI METI KONČANI!<br><span style='font-size: 1.5rem; letter-spacing: 2px;'>Preusmeritev na rezultate...</span>";
            
            // Po 10 sekundah preusmerimo
            setTimeout(function() {
                window.location.href = 'results.php';
            }, 10000);
        }

        // Ko se stran naloži, zaženemo prvo rundo
        window.onload = function() {
            zazeniIgro();
        };
    </script>

</body>
</html>