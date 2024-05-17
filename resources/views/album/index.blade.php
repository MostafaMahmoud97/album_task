@extends('layouts.master')
@section('css')
    <!---Internal Owl Carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Albums</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ List All Albums</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if(request()->has("success"))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{__("product.Done !")}}</strong> {{request()->input('success')}}
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('success'))
        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Done !</strong> {{\Illuminate\Support\Facades\Session::get('success')}}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert alert-danger" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Error !</strong> {{\Illuminate\Support\Facades\Session::get('error')}}
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-6 col-md-3">
                        <a href="{{route("album.create")}}" class="btn btn-primary btn-block" style="color: whitesmoke">Add
                            new album</a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Albums as $album)

                                <tr>
                                    <th scope="row">
                                        <img alt="Responsive image" class="img-thumbnail wd-80p wd-sm-80"
                                             src="{{$album->SinglePicture != null ? $album->SinglePicture->media->file_path : 'http://localhost:8000/assets/img/photos/1.jpg'}}">
                                    </th>
                                    <td>{{$album->name}}</td>
                                    <td>{{$album->created_at}}</td>
                                    <td>
                                        <div class="btn-icon-list">
                                            <a href="{{route("album.show",$album->id)}}" class="btn btn-primary btn-icon"><i class="typcn typcn-eye"></i></a>
                                            <a href="{{route("album.edit",$album->id)}}" class="btn btn-info btn-icon" style="color: white"><i class="typcn typcn-edit"></i></a>
                                            @if($album->pictures_count > 0)
                                                <a class="btn btn-danger btn-icon" data-target="#modaldemo2"
                                                   data-toggle="modal" data-id="{{$album->id}}"><i class="typcn typcn-trash"></i></a>
                                            @else
                                                <a class="btn btn-danger btn-icon" data-target="#modaldemo1"
                                                   data-toggle="modal" data-id="{{$album->id}}"><i class="typcn typcn-trash"></i></a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <!-- Basic modal -->
    <div class="modal" id="modaldemo1">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>Are you want delete this album ?</h6>
                </div>
                <div class="modal-footer">
                    <form id="form-delete" action="" method="GET">
                        <button class="btn ripple btn-danger" type="submit">Delete Album</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->

    <!-- Basic modal -->
    <div class="modal" id="modaldemo2">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Or Move</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>Are you want delete album or move pictures to another album ?</h6>
                    <form id="form-move" action="" method="POST" hidden>
                        @csrf
                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-6">
                                <p class="mg-b-10">Please select any album</p><select class="form-control select2-no-search" name="new_album_id">
                                    @foreach($Albums as $album)
                                        <option value="{{$album->id}}">
                                            {{$album->name}}
                                        </option>
                                    @endforeach

                                </select>
                            </div><!-- col-4 -->

                        </div>
                        <br>
                        <button class="btn ripple btn-primary" type="submit">Submit Move</button>

                    </form>
                </div>
                <div class="modal-footer">
                    <form id="form-delete2" action="" method="GET">
                        <button class="btn ripple btn-danger" type="submit">Delete Album</button>
                        <button id="MovePicturesBtn" class="btn ripple btn-warning" type="button" onclick="ShowMoveForm()">Move Pictures</button>
                    </form>



                </div>
            </div>
        </div>
    </div>
    <!-- End Basic modal -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Modal js-->
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
        $('#modaldemo1').on('show.bs.modal',function (event){
            var btn = $(event.relatedTarget);
            var id = btn.data('id');
            var form = document.getElementById("form-delete");
            const url = `{{ route('album.delete', ':id') }}`.replace(':id', id);
            form.setAttribute("action",url);
        });
    </script>

    <script>
        function ShowMoveForm(){
            var form = document.getElementById("form-move");
            if(form.hasAttribute("hidden")){
                form.removeAttribute("hidden");
            }else{
                form.setAttribute("hidden","");
            }
        }
    </script>

    <script>
        $('#modaldemo2').on('show.bs.modal',function (event){
            var btn = $(event.relatedTarget);
            var id = btn.data('id');
            var MoveForm = document.getElementById("form-move");
            var DeleteForm = document.getElementById("form-delete2");
            const url_delete = `{{ route('album.delete', ':id') }}`.replace(':id', id);
            DeleteForm.setAttribute("action",url_delete);
            const url_move = `{{ route('album.move', ':id') }}`.replace(':id', id);
            MoveForm.setAttribute("action",url_move);
        });
    </script>
@endsection
