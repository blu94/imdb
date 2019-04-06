@extends("layouts.layout")

@section("contents")
  {!! Form::open(["method" => "POST", "action" => "admin\AdminCrewController@store", "class" => ""]) !!}
    <div class="row">
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          Name
        </label>
        {!! Form::text("name", null, ["class" => "form-control", "required" => "required", "placeholder" => "Name"]) !!}
      </div>
      <div class="form-group col-xs-12 col-sm-6">
        <label class="control-label mb-10 text-left">
          email
        </label>
        {!! Form::email("email", null, ["class" => "form-control", "required" => "required", "placeholder" => "Email"]) !!}
      </div>
    </div>
    <div class="row">
      <div class="form-group col-xs-12 col-sm-4">
        <label class="control-label mb-10 text-left">
          Role
        </label>
        {!! Form::select("role", ["" => "", "2" => "Producer", "3" => "Actor"], null, ["class" => "form-control normalDropdown", "data-placeholder" => "Select a Role"]) !!}
      </div>
      <div class="form-group col-xs-12 col-sm-4">
        <label class="control-label mb-10 text-left">
          Gender
        </label>
        {!! Form::select("gender", ["" => "", "F" => "Female", "M" => "Male"], null, ["class" => "form-control normalDropdown", "data-placeholder" => "Select a Gender"]) !!}
      </div>
      <div class="form-group col-xs-12 col-sm-4">
        <label class="control-label mb-10 text-left">
          Birthday
        </label>
        <div class="input-group date" id="birthday">
          {!! Form::text("birthday", null, ["class" => "form-control", "placeholder" => "Year of release"]) !!}
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

        {!! Form::textarea("bio", null, ["class" => "form-control", "rows" => "8", "cols" => "80", "placeholder" => "Bio"]) !!}
      </div>
    </div>

    <div class="pull-right">
    <button type="submit" class="btn btn-primary pull-right mb-10" name="operationBtn" value="create">Create</button>
    <a href="{{route("admin.crew.index")}}" class="btn btn-default pull-right mr-10 mb-10">Cancel</a>
  </div>
  {!! Form::close() !!}
@endsection

@section('scripts')
  <script type="text/javascript">
    markSideNav("crew-create");

    $("#birthday").datetimepicker({
      format: "YYYY-MM-DD",
      // minDate: moment()
    });
  </script>
@endsection
