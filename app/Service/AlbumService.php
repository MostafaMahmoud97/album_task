<?php


namespace App\Service;


use App\Models\Album;
use App\Models\Media;
use App\Models\Picture;
use App\Service\InterfaceRepository\AlbumInterface;
use App\Traits\GeneralFileService;
use App\Traits\GeneralResponse;

class AlbumService implements AlbumInterface
{
    use GeneralFileService, GeneralResponse;

    public function getAlbums()
    {
        $Albums = Album::with(["SinglePicture" => function ($q) {
            $q->with("media");
        }])->withCount("Pictures")->get();

        return $this->successResponse($Albums, "albums have been fetched success");
    }


    public function storeAlbum($request)
    {
        $Album = Album::create($request->all());

        if ($request->pictures && count($request->pictures) > 0) {
            $path = "Pictures/";
            foreach ($request->pictures as $picture) {
                $Picture = Picture::create([
                    "album_id" => $Album->id,
                    "name" => $picture["name"]
                ]);

                $file_name = $this->SaveFile($picture["media"], $path);
                $type = $this->getFileType($picture["media"]);

                Media::create([
                    'mediable_type' => $Picture->getMorphClass(),
                    'mediable_id' => $Picture->id,
                    'title' => "Picture",
                    'type' => $type,
                    'directory' => $path,
                    'filename' => $file_name
                ]);

            }
        }

        return $this->successResponse($Album, "album has been created success");

    }

    public function showAlbum($id)
    {
        $Album = Album::with(["Pictures" => function ($q) {
            $q->with("media");
        }])->find($id);

        if (!$Album) {
            return $this->errorResponse("not found album");
        }

        return $this->successResponse($Album,"album has been fetched success");
    }

    public function editAlbum($id)
    {
        $Album = Album::with(["Pictures" => function ($q) {
            $q->with("media");
        }])->find($id);

        if (!$Album) {
            return $this->errorResponse("not found album");
        }

        return $this->successResponse($Album, "album has been fetched success");

    }

    public function updateAlbum($id, $request)
    {
        $Album = Album::find($id);

        if (!$Album) {
            return $this->errorResponse("not found album");
        }

        $Album->update([
            "name" => $request->name
        ]);


        if ($request->pictures && count($request->pictures) > 0) {
            foreach ($request->pictures as $item) {
                $Picture = Picture::where("album_id", $id)->find($item["id"]);
                if (!$Picture) {
                    return $this->errorResponse("not found picture by this id : " . $item["id"]);
                }

                $Picture->update([
                    "name" => $item["name"]
                ]);

                if (array_key_exists("media",$item) && $item["media"] != null) {

                    $Media = $Picture->media;
                    if ($Media) {
                        $this->removeFile($Media->file_path);
                        $Media->delete();
                    }

                    $path = "Pictures/";
                    $file_name = $this->SaveFile($item["media"], $path);
                    $type = $this->getFileType($item["media"]);

                    Media::create([
                        'mediable_type' => $Picture->getMorphClass(),
                        'mediable_id' => $Picture->id,
                        'title' => "Picture",
                        'type' => $type,
                        'directory' => $path,
                        'filename' => $file_name
                    ]);

                }
            }
        }

        return $this->successResponse([], "album has been updated success");
    }

    public function deleteAlbum($id)
    {
        $Album = Album::find($id);

        if (!$Album) {
            return $this->errorResponse("not found album");
        }

        $Pictures = $Album->Pictures;

        foreach ($Pictures as $picture) {
            $media = $picture->media;
            if ($media) {
                $this->removeFile($media->file_path);
                $media->delete();
            }

            $picture->delete();
        }

        $Album->delete();

        return $this->successResponse([], "album has been deleted success");
    }

    public function getAnotherAlbums($id)
    {
        $Albums = Album::where("id", "!=", $id)->get();
        return $this->successResponse($Albums, "albums has been fetched success");
    }

    public function movePictures($id, $request)
    {
        $Album = Album::find($id);

        if (!$Album) {
            return $this->errorResponse("not found album");
        }

        $Pictures = $Album->Pictures;
        foreach ($Pictures as $picture){
            $picture->update([
                "album_id" => $request->new_album_id
            ]);
        }

        $Album->delete();

        return $this->successResponse([],"pictures have been moved success");
    }
}
