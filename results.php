<?php
session_start();

// Preverimo, če obstajajo rezultati iz game.php, drugače preusmerimo nazaj
if (!isset($_SESSION['zadnji_rezultati'])) {
    header("Location: index.html"); // Popravi, če se tvoja prva stran imenuje index.php
    exit;
}

$igralci = [
    $_SESSION['ime1'] ?? 'Igralec 1',
    $_SESSION['ime2'] ?? 'Igralec 2',
    $_SESSION['ime3'] ?? 'Igralec 3'
];

$rezultati = $_SESSION['zadnji_rezultati'];
$skupne_tocke = [];

// Izračunamo skupne točke za vsakega igralca
foreach ($rezultati as $index => $meti) {
    $skupne_tocke[$index] = array_sum($meti);
}

// Najdemo najvišje število točk
$max_tocke = max($skupne_tocke);
$zmagovalci = [];

// Preverimo, kateri igralci imajo to najvišje število točk (v primeru izenačenja)
foreach ($skupne_tocke as $index => $tocke) {
    if ($tocke == $max_tocke) {
        $zmagovalci[] = $igralci[$index];
    }
}
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
    
</head>
<body>

    <h1 class="main-title">REZULTATI</h1>

    <div class="game-container" style="align-items: center;">
        <div class="results-box">
            
            <h2 class="winner-title" onclick="credits()">
                🏆 Zmagovalec: <?= implode(", ", $zmagovalci) ?> 🏆
            </h2>

            <ul class="score-list">
                <?php foreach ($igralci as $index => $igralec): ?>
                    <?php $is_winner = ($skupne_tocke[$index] == $max_tocke) ? 'winner' : ''; ?>
                    <li class="score-item <?= $is_winner ?>">
                        <span><?= htmlspecialchars($igralec) ?></span>
                        <span class="points"><?= $skupne_tocke[$index] ?> pik</span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Spremeni href v ime tvoje prve strani (npr. index.html ali index.php) -->
            <a href="index.php" class="play-button" style="text-decoration: none; display: inline-block;">Igraj znova</a>
        </div>
    </div>
	<script>
		function credits(){
		Swal.fire({
		  icon: "question",
		  title: "Credits:",
		  text: "Maj Komel, 4.RA",
		  
		  confirmButtonText: "OK",
		  confirmButtonColor: "#4a148c"
		});
	}
	</script>
</body>
</html>