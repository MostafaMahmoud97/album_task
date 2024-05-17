@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Albums</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Show Pictures</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card" id="contentthumb">
                            <div class="card-body ht-100p">
                                <div>
                                    <h6 class="card-title mb-1">Album Name : {{$Album->name}}</h6>
                                </div>
                                <br>
                                <div class="text-wrap">
                                    <div class="example">
                                        <div class="row">
                                            @foreach($Album->Pictures as $picture)
                                                <div class="col-xl-4 col-lg-4">
                                                    <div class="img-thumbnail mb-3">
                                                        <a>
                                                            <img src="{{$picture->media->file_path}}" alt="thumb1" class="thumbimg wd-100p" style="height: 280px">
                                                        </a>
                                                        <div class="caption">
                                                            <h5>{{$picture->name}}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach



                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

@endsection
