@extends("layouts.layout")

@section("contents")
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="panel panel-default card-view panel-refresh">
        <div class="refresh-container">
          <div class="la-anim-1"></div>
        </div>
        <div class="panel-heading">
          <div class="pull-left">
            <h6 class="panel-title txt-dark">Movie</h6>
          </div>
          <div class="pull-right">

            <a href="{{route("admin.movie.create")}}" class="inline-block" title="add listing">
              <i class="icon-plus text-primary"></i>
            </a>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="panel-wrapper collapse in">
          <div class="panel-body">
            <div class="tab-content">
              <div class="table-wrap">
                <div class="table-responsive">
                  <table class="paginateTable table table-hover display pb-30" data-page-length="25">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Year of release</th>
                        <th>Producer</th>
                        <th>Actors</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Name</th>
                        <th>Year of release</th>
                        <th>Producer</th>
                        <th>Actors</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($movies as $movie)
                        <tr>
                          <td>
                            <a href="{{route("admin.movie.show", $movie->id)}}">{{$movie->name}}</a>
                          </td>
                          <td>
                            {{date("Y", strtotime($movie->releseDate))}}
                          </td>
                          <td>
                            {{$movie->producer->name}}
                          </td>
                          <td>
                            @foreach ($movie->meta as $actor)
                              @if ($actor->type == "ACTOR_IN_MOVIE")
                                {{$actor->user->name}}
                                @if (!$loop->last)
                                  ,
                                @endif
                              @endif
                            @endforeach
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
