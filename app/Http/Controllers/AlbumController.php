<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Service\AlbumService;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $service;

    public function __construct(AlbumService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->service->getAlbums();
        return view("album.index")->with("Albums",$response["data"]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("album.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlbumRequest $request)
    {
        $response = $this->service->storeAlbum($request);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->service->showAlbum($id);

        if ($response["status"]){
            return view("album.show")->with("Album",$response["data"]);
        }else{
            return redirect()->back()->with("error" , $response["error_message"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = $this->service->editAlbum($id);

        if ($response["status"]){
            return view("album.edit")->with("Album",$response["data"]);
        }else{
            return redirect()->back()->with("error",$response["error_message"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlbumRequest $request, $id)
    {

        $response = $this->service->updateAlbum($id,$request);

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->service->deleteAlbum($id);

        if ($response["status"]){
            return redirect()->back()->with("success",$response["message"]);
        }else{
            return redirect()->back()->with("error",$response["error_message"]);
        }
    }

    public function movePictures($id,Request $request){
        $response = $this->service->movePictures($id,$request);

        if ($response["status"]){
            return redirect()->back()->with("success",$response["message"]);
        }else{
            return redirect()->back()->with("error",$response["error_message"]);
        }
    }
}
