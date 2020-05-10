<?php

if(isset($_POST['submit'])){
    if (count($_FILES['movies']['name']) > 0) {
        for ($i = 0; $i < count($_FILES['movies']['name']); $i++) {
            $tmpFilePath = $_FILES['movies']['tmp_name'][$i];
            if (($_FILES['movies']['size'][$i]) > 1000000) {
                $sizeErr = "Fichier trop lourd";
            }
            if ($_FILES['movies']['type'][$i] !== 'image/jpeg'
                AND $_FILES['movies']['type'][$i] !== 'image/png'
                AND $_FILES['movies']['type'][$i] !== 'image/gif') {
              $extErr = "Extension non autorisée";
            }
            elseif ($tmpFilePath != "") {
                            $uploadDir = 'uploads/';
                            $extension = pathinfo($_FILES['movies']['name'][$i], PATHINFO_EXTENSION);
                            $filename = uniqid() . '.' . $extension;
                            $uploadFile = $uploadDir . $filename;
                            move_uploaded_file($tmpFilePath, $uploadFile);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Cookie Factory</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/styles.css"/>
    </head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="imageUpload">Upload an profile image</label>
            <div><?php if (isset($sizeErr)) { echo $sizeErr;} ?></div>
            <span><?php if (isset($extErr)) { echo $extErr;} ?></span>
            <input type="file" name="movies[]" multiple="multiple" />
            <p><input type="submit" name="submit" value="Submit"></p>
        </form>
        <?php
        $it = new FilesystemIterator(__DIR__.'/uploads');
        foreach ($it as $fileinfo) {
            echo "<figure>";
            echo "<img src=\"" . '/uploads/' . $fileinfo->getFilename() . "\">";
            echo "<figcaption>" . $fileinfo->getFilename() . "</figcaption>";
            echo "</figure><br>";
        }
        ?>
    </body>
</html>
