<!DOCTYPE html>
<html>
    <body>

    <!--<form action="upload.php" method="post" enctype="multipart/form-data">-->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="files[]" id="fileToUpload" multiple="multiple">
        <input type="submit" value="Upload Image" name="fileUpload">
    </form>

    </body>
</html>