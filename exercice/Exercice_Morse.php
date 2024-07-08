<!DOCTYPE html>
<html lang="fr">

<head>
        <title>Code Morse</title>
</head>
<body>
    <h2>Convertisseur de texte en code Morse</h2>
<form method="post">
      <label for="text">Entrez votre texte :</label><br>
      <input type="text" id="text" name="text" required><br><br>
      <input type="submit" value="Convertir">
</form>
<?php

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = $_POST['text'];
    echo "<h3>Texte original :</h3><p>$inputText</p>";
    echo "<h3>Code Morse :</h3><p>" . stringToMorse($inputText) . "</p>";
 }

 function stringToMorse($string) {

    $morseCode = array(
        'A' => '.-', 'B' => '-...', 'C' => '-.-.', 'D' => '-..', 'E' => '.', 'F' => '..-.', 'G' => '--.', 'H' => '....', 'I' => '..', 'J' => '.---',
        'K' => '-.-', 'L' => '.-..', 'M' => '--', 'N' => '-.', 'O' => '---', 'P' => '.--.', 'Q' => '--.-', 'R' => '.-.', 'S' => '...', 'T' => '-',
        'U' => '..-', 'V' => '...-', 'W' => '.--', 'X' => '-..-', 'Y' => '-.--', 'Z' => '--..',
        '0' => '-----', '1' => '.----', '2' => '..---', '3' => '...--', '4' => '....-', '5' => '.....',
        '6' => '-....', '7' => '--...', '8' => '---..', '9' => '----.',
        ' ' => '/'  
    );
    
    $string = strtoupper($string);
    
    $morseString = ' ';
    
    for ($i = 0; $i < strlen($string); $i++) {
        $char = $string[$i];
        
        if (array_key_exists($char, $morseCode)) {
            
            $morseString .= $morseCode[$char] . ' ';
        }
    }
    
    return rtrim($morseString);
 }

?>
    </body>
</html>