@extends("layouts.layout")

@section('styles')
  <link href="{{asset("elmer/vendors/bower_components/owl.carousel/dist/assets/owl.carousel.min.css")}}" rel="stylesheet" type="text/css">
  <link href="{{asset("elmer/vendors/bower_components/owl.carousel/dist/assets/owl.theme.default.min.css")}}" rel="stylesheet" type="text/css">
@endsection

@section("contents")
    <div class="row">
      <div id="owl_demo_2" class="owl-carousel owl-theme ownCarousel">
        @foreach ($movie->assets as $image)
          <div class="item"><img src="{{asset($image->path)}}" alt="Owl Image"></div>
        @endforeach
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12">
        <label class="control-label mb-10 text-left">
          Name
        </label>
        <input type="text" name="name" class="form-control" placeholder="Name" value="{{$movie->name}}" readonly>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Producer
        </label>
        <input type="text" name="" class="form-control" value="{{$movie->producer->name}}" readonly>
      </div>
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Actor
        </label>
        <input type="text" name="" class="form-control" value="@foreach ($movie->meta as $selectedUser)
          @if ($selectedUser->type == "ACTOR_IN_MOVIE")
            {{$selectedUser->user->name}}
            @if (!$loop->last)
              ,
            @endif
          @endif
        @endforeach" readonly>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12">
        <label class="control-label mb-10 text-left">
          Year of release
        </label>
        <div class="input-group date" id="yearOfRelease">
          <input type="text" name="yearOfRelease" readonly placeholder="Year of release" class="form-control" value="{{$movie->releseDate}}">
          <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12">
        <label class="control-label mb-10 text-left">
          Plot
        </label>
        <textarea name="plot" rows="8" cols="80" class="form-control" readonly>{{$movie->plot}}</textarea>
      </div>
    </div>

    <div class="pull-right">
      <a href="{{route("admin.movie.edit", $movie->id)}}" class="btn btn-primary">Edit</a>
    </div>
@endsection

@section('scripts')
  <script src="{{asset("elmer/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js")}}"></script>
<script type="text/javascript">
    markSideNav("movie-create");

    $("#yearOfRelease").datetimepicker({
      format: "YYYY",
      // minDate: moment()
    });

    jQuery(document).ready(function($) {
    	"use strict";

    	/*owl carousel*/
      $(".ownCarousel").owlCarousel({
    		margin:20,
    		nav:true,
    		// autoplay:true,
        // center:true,
    		responsive:{
    			0:{
    				items:1
    			},
    			480:{
    				items:2
    			},
    			1024:{
    				items:5
    			},
    			1280:{
    				items:6
    			},

    		}
    	});
    });
  </script>
@endsection
