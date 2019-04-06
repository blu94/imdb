@extends("layouts.layout")

@section("contents")
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default panel-tabs card-view">
        <div class="panel-heading">
          <div class="pull-left">
            <div  class="tab-struct custom-tab-1">
              <ul role="tablist" class="nav nav-tabs" id="myTabs_9">
                <li class="active" role="presentation">
                  <a aria-expanded="true"  data-toggle="tab" role="tab" id="home_tab_9" href="#home_9">
                    Producer
                  </a>
                </li>
                <li role="presentation" class="">
                  <a  data-toggle="tab" id="profile_tab_9" role="tab" href="#profile_9" aria-expanded="false">
                    Actor
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="pull-right">
            <a href="{{route("admin.crew.create")}}" class="inline-block" title="add actor">
              <i class="icon-plus text-primary"></i>
            </a>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="panel-wrapper collapse in">
          <div class="panel-body">
            <div class="tab-content" id="myTabContent_9">
              <div  id="home_9" class="tab-pane fade active in" role="tabpanel">
                @include("admin.crew.gadget.userTable", [
                  "users" => $producers
                ])
              </div>
              <div id="profile_9" class="tab-pane fade" role="tabpanel">
                @include("admin.crew.gadget.userTable", [
                  "users" => $actors
                ])
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
