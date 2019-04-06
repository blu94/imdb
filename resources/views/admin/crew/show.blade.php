@extends("layouts.layout")

@section("contents")
  <div class="row">
    <div class="form-group col-xs-12 col-sm-6">
      <label class="control-label mb-10 text-left">
        Name
      </label>
      <input type="text" name="name" class="form-control" placeholder="Name" readonly value="{{$user->name}}">
    </div>
    <div class="form-group col-xs-12 col-sm-6">
      <label class="control-label mb-10 text-left">
        email
      </label>
      <input type="email" name="email" class="form-control" placeholder="Email" readonly value="{{$user->email}}">
    </div>
  </div>
  <div class="row">
    <div class="form-group col-xs-12 col-sm-4">
      <label class="control-label mb-10 text-left">
        Role
      </label>
      <input type="text" name="role" placeholder="Role" class="form-control" readonly value="{{$user->role->title}}">
    </div>
    <div class="form-group col-xs-12 col-sm-4">
      <label class="control-label mb-10 text-left">
        Gender
      </label>
      <input type="text" name="gender" placeholder="Gender" class="form-control" readonly value="{{($user->gender == "F" ? "Female" : "Male")}}">
    </div>
    <div class="form-group col-xs-12 col-sm-4">
      <label class="control-label mb-10 text-left">
        Birthday
      </label>
      <div class="input-group date" id="birthday">
        <input type="text" name="birthday" placeholder="Year of release" class="form-control" readonly value="{{$user->birthday}}">
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
      <textarea name="bio" rows="8" cols="80" class="form-control" placeholder="Bio" readonly>{{$user->bio}}</textarea>
    </div>
  </div>

  <div class="pull-right">
    <a href="{{route("admin.crew.edit", $user->id)}}" class="btn btn-primary pull-right mr-10 mb-10">Edit</a>
  </div>
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
