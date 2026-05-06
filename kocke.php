<!DOCTYPE html>
<html lang="sl">
	<head>
		<title>Kocke</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div id="glavni">
			<div id="imena">
				<form action="kocke.php" method="post">
					Prvi igralec: <input type="text" name="name1">
					Drugi igralec: <input type="text" name="name2">
					Tretji igralec: <input type="text" name="name3">
				</form>
			</div>
			<div id="nastavitve">
				<label for="stMetov">Stevilo metov</label>
					<select name="stMetov" id="stMetov">
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					</select>
				<label for="stKock">Stevilo kock</label>
					<select name="stKock" id="stKock">
					  <option value="1">1</option>
					  <option value="2">2</option>
					  <option value="3">3</option>
					</select>
				<input type="submit">
			</div>
			
		</div>	
	</body>
</html>