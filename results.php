<?php
session_start();

// Preverimo, če obstajajo rezultati, drugače nazaj na začetek
if (!isset($_SESSION['zadnji_rezultati'])) {
    header("Location: index.php");
    exit;
}

// Imena igralcev pripravimo v preprosto polje (brez ?? operatorja)
$igralci = array();
if (isset($_SESSION['ime1'])) { $igralci[0] = $_SESSION['ime1']; } else { $igralci[0] = 'Igralec 1'; }
if (isset($_SESSION['ime2'])) { $igralci[1] = $_SESSION['ime2']; } else { $igralci[1] = 'Igralec 2'; }
if (isset($_SESSION['ime3'])) { $igralci[2] = $_SESSION['ime3']; } else { $igralci[2] = 'Igralec 3'; }

$rezultati = $_SESSION['zadnji_rezultati'];
$skupne_tocke = array();

// Izračunamo skupne točke s klasično for zanko
for ($i = 0; $i < count($igralci); $i++) {
    // array_sum je v redu, ker je osnovna funkcija, ki se jo učite
    $skupne_tocke[$i] = array_sum($rezultati[$i]);
}

// Najdemo najvišje število točk
$max_tocke = max($skupne_tocke);
$zmagovalci_imena = array();

// Poiščemo zmagovalce
for ($j = 0; $j < count($skupne_tocke); $j++) {
    if ($skupne_tocke[$j] == $max_tocke) {
        $zmagovalci_imena[] = $igralci[$j];
    }
}

// Združimo zmagovalce v niz za izpis
$izpis_zmagovalcev = implode(", ", $zmagovalci_imena);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kocke - Rezultati</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/resultsCSS.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>
<body>

    <h1 class="main-title">REZULTATI</h1>

    <div class="game-container" style="align-items: center;">
        <div class="results-box">
            
            <h2 class="winner-title" onclick="credits()">
                🏆 Zmagovalec: <?php echo $izpis_zmagovalcev; ?> 🏆
            </h2>

            <ul class="score-list">
                <?php 
                // Klasična for zanka za izpis v HTML
                for ($k = 0; $k < count($igralci); $k++) {
                    $is_winner = "";
                    if ($skupne_tocke[$k] == $max_tocke) {
                        $is_winner = "winner";
                    }
                    ?>
                    <li class="score-item <?php echo $is_winner; ?>">
                        <span><?php echo htmlspecialchars($igralci[$k]); ?></span>
                        <span class="points"><?php echo $skupne_tocke[$k]; ?> pik</span>
                    </li>
                <?php } ?>
            </ul>

            <a href="index.php" class="play-button" style="text-decoration: none; display: inline-block;">Igraj znova</a>
        </div>
    </div>

    <script>
    // 1. Funkcija za izstrelitev konfetov
    function shoot() {
			// Prvi del konfetov (zvezdice)
			confetti({
				spread: 500,
				ticks: 30,
				gravity: 0,
				decay: 0.94,
				startVelocity: 30,
				colors: ["FFE400", "FFBD00", "E89400", "FFCA6C", "FDFFB8"],
				particleCount: 40,
				scalar: 1.2,
				shapes: ["star"]
			});

			// Drugi del konfetov (krogci)
			confetti({
				spread: 500,
				ticks: 30,
				gravity: 0,
				decay: 0.94,
				startVelocity: 30,
				colors: ["FFE400", "FFBD00", "E89400", "FFCA6C", "FDFFB8"],
				particleCount: 10,
				scalar: 0.75,
				shapes: ["circle"]
			});
		}

		// 2. Funkcija za tvoj SweetAlert (Credits)
		function credits() {
			Swal.fire({
				icon: "question",
				title: "Credits:",
				text: "Maj Komel, 4.RA",
				confirmButtonText: "OK",
				confirmButtonColor: "#4a148c"
			});
		}

		// 3. Spodnja koda se zažene takoj, ko se stran naloži
		window.onload = function() {
			// Takojšnja prva eksplozija
			shoot();
			
			// Še dve zaporedni eksploziji z majhnim zamikom za boljši efekt
			setTimeout(shoot, 150);
			setTimeout(shoot, 300);
		};
	</script>
</body>
</html>