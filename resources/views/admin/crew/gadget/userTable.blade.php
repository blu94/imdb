<div class="table-responsive">
  <table class="paginateTable table table-hover display pb-30" data-page-length="25">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Birthday</th>
        <th>Gender</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Birthday</th>
        <th>Gender</th>
      </tr>
    </tfoot>
    <tbody>
      @foreach ($users as $user)
        <tr>
          <td><a href="{{route("admin.crew.show", $user->id)}}">{{$user->name}}</a></td>
          <td>{{($user->email == null ? "-" : $user->email)}}</td>
          <td>{{date("Y-m-d", strtotime($user->birthday))}}</td>
          <td>{{($user->gender == "F" ? "Female" : "Male")}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
