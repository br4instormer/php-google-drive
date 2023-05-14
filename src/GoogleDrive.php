<?php

declare(strict_types=1);

namespace GoogleDrive;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\FileList;

/**
 * The function creates a Google API client with specified scopes.
 * 
 * @param array scopes Array of scopes to be used
 * 
 * @return Client A `Client` object is being returned.
 */
function createClient(array $scopes): Client
{
    $client = new Client();
    $client->useApplicationDefaultCredentials();

    foreach ($scopes as $scope) {
        $client->addScope($scope);
    }

    return $client;
}

/**
 * This function returns a list of files with a specific name and parent directory ID from a Google
 * Drive.
 * 
 * @param Drive drive The Drive object that represents the Google Drive API service. It is used to make
 * requests to the API.
 * @param string filename The name of the file that you want to check for existence in a specific
 * directory.
 * @param string parentDirId The parentDirId parameter is a string that represents the ID of the parent
 * directory in which the function will search for the file with the given filename.
 * 
 * @return FileList a list of files that exist in a specific Google Drive directory with a given
 * filename. The returned list includes the ID and name of each file.
 */
function getExistedFiles(Drive $drive, string $filename, string $parentDirId): FileList
{
    return $drive->files->listFiles([
        "fields" => "files(id,name)",
        "spaces" => "drive",
        "q" => sprintf("name = '%s' and parents in '%s'", $filename, $parentDirId),
    ]);
}

/**
 * The function uploads a file to Google Drive and replaces any existing file with the same name in the
 * specified parent directory.
 * 
 * @param string filepath The file path of the file that needs to be uploaded to Google Drive.
 * @param string parentDirId The ID of the parent directory in Google Drive where the file will be
 * uploaded to.
 */
function uploadToDrive(string $filepath, string $parentDirId): void
{
    $scopes = [
        Drive::DRIVE
    ];
    $drive = new Drive(createClient($scopes));
    $filename = basename($filepath);

    $existed = getExistedFiles($drive, $filename, $parentDirId);

    foreach ($existed as $existedFile) {
        $drive->files->delete(($existedFile->id));
    }

    $file = new DriveFile([
        'name' => $filename,
        'parents' => [$parentDirId],
    ]);

    $drive->files->create(
        $file,
        [
            'data' => file_get_contents($filepath),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart',
        ]
    );
}
