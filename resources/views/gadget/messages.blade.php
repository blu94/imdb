@if (Session::has("successMessage"))
  <div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>
      SuccesfullyQ
    </strong>
    <br>
    {{ session("successMessage") }}
  </div>
@endif

@if (Session::has("warningMessage"))
  <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>
      Opps
    </strong>
    <br>
    {{ session("warningMessage") }}
  </div>
@endif

@if (count($errors) > 0)
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>
      Opps
    </strong>
    <ul class="messageList">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
