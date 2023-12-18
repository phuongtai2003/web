<?php
    use Cloudinary\Cloudinary;
    require 'vendor/autoload.php';

    function upload_file($file){
        $cloudinary = new Cloudinary('cloudinary://357415218746838:faZtm3aJ8BAxoJ-ZG6psQCbqD7E@dhpxifsfm?url[secure]=true');
        $data = $cloudinary->uploadApi()->upload($file);
        return $data['secure_url'];
    }
?>