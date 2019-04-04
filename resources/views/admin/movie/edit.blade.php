@extends("layouts.layout")

@section("contents")
  <form class="" action="{{action("admin\AdminMovieController@update", $movie->id)}}" method="post">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <div class="row">
      <div class="col-xs-12">
        <div class="dropzone dropzoneSetting uploadImage">
          <div class="dropzonePlaceholder dz-message" data-dz-message>
            <i class="pe-7s-cloud-upload icon"></i>
            <span class="text">
              Upload Image
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12">
        <label class="control-label mb-10 text-left">
          Name
        </label>
        <input type="text" name="name" class="form-control" placeholder="Name" value="{{$movie->name}}">
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Producer
        </label>
        <select class="form-control tagsDropdown" name="producer" data-placeholder="Select a Producer">
          <option value=""></option>
          @foreach ($producers as $producer)

            <option value="{{$producer->name}}" @if ($movie->producer_id == $producer->id)
              selected
            @endif>{{$producer->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Actor
        </label>
        <select class="form-control tagsDropdown" name="actor[]" data-placeholder="Select a Actor" multiple>
          <option value=""></option>
          @foreach ($actors as $actor)
            @php
              $selected = "";
            @endphp
            @foreach ($movie->meta as $selectedUser)
              @if ($selectedUser->type == "ACTOR_IN_MOVIE")
                @if ($selectedUser->user_id == $actor->id)
                  @php
                    $selected = "selected";
                  @endphp
                @endif
              @endif
            @endforeach
            <option value="{{$actor->name}}" {{$selected}}>{{$actor->name}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12">
        <label class="control-label mb-10 text-left">
          Year of release
        </label>
        <div class="input-group date" id="yearOfRelease">
          <input type="text" name="yearOfRelease" placeholder="Year of release" class="form-control" value="{{$movie->releseDate}}">
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
        <textarea name="plot" rows="8" cols="80" class="form-control">{{$movie->plot}}</textarea>
      </div>
    </div>

    <div class="pull-right">
      <button type="submit" class="btn btn-primary pull-right mb-10" name="operationBtn" value="update">Update</button>
      <button type="submit" class="btn btn-danger pull-right mb-10 dangerAction" data-action-message="Are you sure delete this movie?" name="operationBtn" value="delete">Delete</button>
      <a href="{{route("admin.movie.index")}}" class="btn btn-default pull-right mr-10 mb-10">Cancel</a>
    </div>
  </form>
@endsection

@section('scripts')
  @php
    $imageElementName = "movieImages";
  @endphp
<script type="text/javascript">
    markSideNav("movie-create");

    $("#yearOfRelease").datetimepicker({
      format: "YYYY",
      // minDate: moment()
    });

    Dropzone.autoDiscover = false;
    $(".uploadImage").dropzone({
      url: storeAssetUrl,
      acceptedFiles: ".png,.jpg,.jpeg,.gif,.PNG,.JPG,.JPEG,.GIF",
      maxFiles: 100,
      addRemoveLinks: true,
      dictDefaultMessage: "",
      sending: function(file, xhr, formData) {
        formData.append("_token", "{{csrf_token()}}");
        formData.append("usage", "MOVIE_ASSET");
        formData.append("returnType", "ID");
      },
      init: function(){
        this.on("success", function(file, response) {
          file.previewElement.id = response;
          $(".dz-preview[id='"+response+"']").append("<input type='hidden' name='{{$imageElementName}}[]' class='{{$imageElementName}}' value='"+response+"'/>");
        });

        this.on("removedfile",function(file){
          var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });

        self = this;
        // for video files, use frame-grab to generate a preview.
        this.on("addedfile", function(file) {
          // frameGrabForVideo (file);
        });

        @foreach ($movie->assets as $image)
          // mockFile = {name: val, uploaded_name: val, accepted: true};
          var mockFile = { name: "{{$image->title}}", type: "{{$image->type}}", size: "{{$image->size}}" , accepted: true};

          // Call the default addedfile course handler
          this.emit("addedfile", mockFile);

          this.emit("thumbnail", mockFile, "{{asset($image->path)}}");

          // And optionally show the thumbnail of the file:
          $(mockFile.previewElement).prop("id", "{{$image->id}}");

          // make mock file no progress bar
          this.emit("complete", mockFile);

          this.files.push(mockFile);

          // append input to image tag
          $(".dz-preview[id='{{$image->id}}']").append("<input type='hidden' name='{{$imageElementName}}[]' class='{{$imageElementName}}' value='{{$image->id}}'/>");

          // video thumbnail
          {{-- assetThumbnail ("{{$image->format}}", "{{asset(getCompressedPath($image->path))}}", {{$image->id}}); --}}
        @endforeach
      },
      removedfile: function(file) {
        var id = file.previewElement.id;

        deleteProductImageUrl = deleteAssetUrl.replace("%deletefileid%", id);

        $.ajax({
          type: "GET",
          url: deleteProductImageUrl,
          success: function(response){
            $(".{{$imageElementName}}").each(function(){
              if($(this).val() == id){
                $(this).remove();
              }
            });
          }
        });
      }
    });
  </script>
@endsection
