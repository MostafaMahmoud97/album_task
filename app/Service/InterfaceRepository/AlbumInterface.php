<?php


namespace App\Service\InterfaceRepository;


interface AlbumInterface
{
    public function getAlbums();

    public function storeAlbum($request);

    public function showAlbum($id);

    public function editAlbum($id);

    public function updateAlbum($id,$request);

    public function deleteAlbum($id);

    public function getAnotherAlbums($id);

    public function movePictures($id,$request);

}
