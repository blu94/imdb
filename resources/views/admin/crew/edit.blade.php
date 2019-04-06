@extends("layouts.layout")

@section("contents")
  {!! Form::open(["method" => "PATCH", "action" => ["admin\AdminCrewController@update", $user->id]]) !!}
    <input type="hidden" name="userId" value="{{$user->id}}">
    <div class="row">
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Name
        </label>
        <input type="text" name="name" class="form-control" placeholder="Name" value="{{$user->name}}">
      </div>
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          email
        </label>
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{$user->email}}">
      </div>
    </div>
    <div class="row">
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Gender
        </label>
        {!! Form::select("gender", ["" => "", "F" => "Female", "M" => "Male"], $user->gender, ['class' => 'form-control normalDropdown', 'data-placeholder' => 'Select a Gender']) !!}
      </div>
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Birthday
        </label>
        <div class="input-group date" id="birthday">
          <input type="text" name="birthday" placeholder="Birthday" value="{{$user->birthday}}" class="form-control">
          <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-xs-12">
        <label class="control-label mb-10 text-left">
          Bio
        </label>
        <textarea name="bio" rows="8" cols="80" class="form-control" placeholder="Bio">{{$user->bio}}</textarea>
      </div>
    </div>

    <div class="pull-right">
      <button type="submit" class="btn btn-primary pull-right mb-10" name="operationBtn" value="update">Update</button>
      <a href="{{route("admin.crew.index")}}" class="btn btn-default pull-right mr-10 mb-10">Cancel</a>
    </div>
  {!! Form::close() !!}
@endsection

@section('scripts')
  <script type="text/javascript">
    markSideNav("crew-all");

    $("#birthday").datetimepicker({
      format: "YYYY-MM-DD",
      // minDate: moment()
    });
  </script>
@endsection
