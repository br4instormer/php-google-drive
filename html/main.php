<?php

declare(strict_types=1);

namespace App;

define("BEHIND_PUBLIC", realpath(sprintf("%s/..", $_SERVER['DOCUMENT_ROOT'])));

require_once sprintf("%s/%s", BEHIND_PUBLIC, "/vendor/autoload.php");

use function GoogleDrive\uploadToDrive;

$credentialFile = "credentials.json";
$googleDriveDir = "<GOOGLE-DRIVE-DIRECTORY-ID>";
putenv(sprintf("GOOGLE_APPLICATION_CREDENTIALS=%s/%s", BEHIND_PUBLIC, $credentialFile));

// ...

if(move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadfile)) {
    uploadToDrive($uploadfile, $googleDriveDir);
    echo "$nmf ($size) uploaded";
} else {
    echo "$nmf not uploaded";
}
