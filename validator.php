<?php
function filterInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function hashPassword($password)
{
    return sha1($password);
}




?>
<?php
function encodeNumber($number)
{
    if (is_numeric($number)) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Alphabets

        $shuffleAlphabet = str_shuffle($alphabet);
        $base = strlen($shuffleAlphabet); // Base of the encoding
        $encoded = '';
        while ($number > 0) {
            $remainder = $number % $base; // Get remainder
            $encoded = $shuffleAlphabet[$remainder] . $encoded; // Append corresponding alphabet to the encoded string
            $number = intval($number / $base); // Update number for next iteration
        }
        return $encoded;
    }
}
function decodeNumber($encoded)
{
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Alphabets
    $base = strlen($alphabet); // Base of the encoding

    $decoded = 0;
    $length = strlen($encoded);
    for ($i = 0; $i < $length; $i++) {
        $char = $encoded[$i];
        $decoded = $decoded * $base + strpos($alphabet, $char); // Multiply decoded value by base and add current alphabet's position
    }
    return $decoded;

}

?>