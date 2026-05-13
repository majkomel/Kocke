<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gambling Igra</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1 class="main-title">KOCKE</h1>

    <form class="game-container" action="game.php" method="POST">
        
        <div class="users-row">
            <div class="user-box">
                <h2>IGRALEC 1</h2>
                <div class="input-group">
                    <label for="ime1">Ime:</label>
                    <input type="text" id="ime1" name="ime1">
                </div>
            </div>
            
            <div class="user-box">
                <h2>IGRALEC 2</h2>
                <div class="input-group">
                    <label for="ime2">Ime:</label>
                    <input type="text" id="ime2" name="ime2">
                </div>
            </div>

            <div class="user-box">
                <h2>IGRALEC 3</h2>
                <div class="input-group">
                    <label for="ime3">Ime:</label>
                    <input type="text" id="ime3" name="ime3">
                </div>
            </div>
        </div>

        <div class="settings-box">
            <div class="dropdowns-row">
                <div class="select-group">
                    <label for="kocke">Število kock:</label>
                    <select id="kocke" name="kocke">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>

                <div class="select-group">
                    <label for="igre">Število iger:</label>
                    <select id="igre" name="igre">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="play-button">Igraj</button>
        </div>
        
    </form> </body>
</html>