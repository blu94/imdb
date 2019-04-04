<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>
    @yield("pageTitle")
  </title>
	<meta name="description" content="@yield("pageDescription")" />
	<meta name="keywords" content="@yield("pageKeywords")" />
  <meta name="csrf-token" content="{{csrf_token()}}">
  <script>
    window.Laravel = {csrfToken: '{{csrf_token()}}'}
  </script>
  <meta name="userId" content="{{Auth::user()->id}}">
	{{-- <meta name="author" content="hencework"/> --}}

  {{-- Favicon --}}
	{{-- <link rel="shortcut icon" href="favicon.ico"> --}}
	{{-- <link rel="icon" href="favicon.ico" type="image/x-icon"> --}}

  @php
    $cache = str_random(10);
    $loginRole = "admin";
    if (Auth::user()->isAdmin()) {
      $loginRole = "admin";
    }
    elseif (Auth::user()->isUser()) {
      $loginRole = "user";
    }
  @endphp

  {{-- Data table CSS --}}
	{{-- <link href="{{asset("elmer/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/jquery.dataTables.min.css">

	{{-- <link href="{{asset("elmer/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css")}}" rel="stylesheet" type="text/css"> --}}
  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet"> --}}

  {{-- dropzone --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">

  {{-- select2 --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

  {{-- bootstrap select --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">

  <!--alerts CSS -->
  <link href="{{asset("elmer/vendors/bower_components/sweetalert/dist/sweetalert.css")}}" rel="stylesheet" type="text/css">

  {{-- light gallery --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/css/lightgallery.min.css">

  {{-- fontawesome --}}
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  {{-- datetime picker --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
  {{-- Custom CSS --}}
	<link href="{{asset("elmer/dist/css/style.css")}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{asset("css/main.css")}}?v={{$cache}}">
  {{-- custom styles --}}
  @yield("styles")
</head>

<body>
  {{-- Preloader --}}
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
  {{-- Preloader --}}

  <div id="app" class="wrapper theme-1-active pimary-color-blue">
		{{-- Top Menu Items --}}
		@include("gadget.general.header")
		{{-- Top Menu Items --}}

    {{-- Left Sidebar Menu --}}
    @include("gadget.general.leftSidebar")
		{{-- Left Sidebar Menu --}}

    {{-- Right Sidebar Menu --}}
    @include("gadget.general.rightSidebar")
    {{-- Right Sidebar Menu --}}


    {{-- Main Content --}}
		<div class="page-wrapper">
      <div class="container-fluid pt-20">
        @yield("pageHeader")

        @include("gadget.messages")

        @yield("contents")
			</div>

			<!-- Footer -->
			@include("gadget.general.footer")
			<!-- /Footer -->

		</div>
    {{-- Main Content --}}
  </div>

	{{-- JavaScript --}}
  {{-- jQuery --}}
  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
  {{-- <script src="{{asset("elmer/vendors/bower_components/jquery/dist/jquery.min.js")}}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

  {{-- Bootstrap Core JavaScript --}}
  {{-- <script src="{{asset("elmer/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script> --}}
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<!-- Data table JavaScript -->
	{{-- <script src="{{asset("elmer/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js" charset="utf-8"></script>

	<!-- Slimscroll JavaScript -->
	<script src="{{asset("elmer/dist/js/jquery.slimscroll.js")}}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.6/jquery.slimscroll.min.js" charset="utf-8"></script> --}}

	<!-- Progressbar Animation JavaScript -->
	{{-- <script src="{{asset("elmer/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js")}}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js" charset="utf-8"></script>
	{{-- <script src="{{asset("elmer/vendors/bower_components/jquery.counterup/jquery.counterup.min.js")}}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js" charset="utf-8"></script>

	<!-- Fancy Dropdown JS -->
	<script src="{{asset("elmer/dist/js/dropdown-bootstrap-extended.js")}}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dropdown/2.0.3/jquery.dropdown.min.js" charset="utf-8"></script> --}}

	<!-- Sparkline JavaScript -->
	{{-- <script src="{{asset("elmer/vendors/jquery.sparkline/dist/jquery.sparkline.min.js")}}"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js" charset="utf-8"></script> --}}

	<!-- Owl JavaScript -->
	{{-- <script src="{{asset("elmer/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js")}}"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/owl.carousel.min.js" charset="utf-8"></script> --}}

	<!-- Switchery JavaScript -->
	{{-- <script src="{{asset("elmer/vendors/bower_components/switchery/dist/switchery.min.js")}}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js" charset="utf-8"></script>

	{{-- EChartJS JavaScript --}}
	{{-- <script src="{{asset("elmer/vendors/bower_components/echarts/dist/echarts-en.min.js")}}"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.1.0.rc2/echarts-en.min.js"></script> --}}
	{{-- <script src="{{asset("elmer/vendors/echarts-liquidfill.min.js")}}"></script> --}}

	{{-- Toast JavaScript --}}
	{{-- <script src="{{asset("elmer/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js")}}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

  {{-- rsvp.js --}}
  {{-- <script src="{{asset("js/rsvp.js")}}" charset="utf-8"></script> --}}

  {{-- frame-grab.js --}}
  {{-- <script src="{{asset("js/frame-grab.js")}}" charset="utf-8"></script> --}}

  {{-- dropzone --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js" charset="utf-8"></script>

  {{-- Init JavaScript --}}
	<script src="{{asset("elmer/dist/js/init.js")}}"></script>
	{{-- <script src="{{asset("elmer/dist/js/dashboard-data.js")}}"></script> --}}

  {{-- Sweet-Alert --}}
  <script src="{{asset("elmer/vendors/bower_components/sweetalert/dist/sweetalert.min.js")}}"></script>

  {{-- sortable --}}
  <script src="{{asset("js/jquery-ui-sortable.min.js")}}" charset="utf-8"></script>

  {{-- select2 --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js" charset="utf-8"></script>

  {{-- bootstrap select --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js" charset="utf-8"></script>

  {{-- vEllipsis --}}
  {{-- <script src="{{asset("js/jquery.vEllipsis.js")}}" charset="utf-8"></script> --}}

  {{-- light gallery --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/js/lightgallery-all.min.js" charset="utf-8"></script>

  <script src="{{asset("elmer/dist/js/dropdown-bootstrap-extended.js")}}"></script>

  {{-- list.js --}}
  <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

  {{-- lozad --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/lozad@1.9.0/dist/lozad.min.js" integrity="sha256-50cmb3K6Zka/WMfXLFzqyo5+P+ue2JdsyEmSEsU58s4=" crossorigin="anonymous"></script> --}}

  {{-- piio --}}
  <script type="application/javascript">
    var piioData = {
      appKey: 'utrkzr',
      domain: 'https://meridinmelaka.com'
    }
  </script>
  <script src="//js.piio.co/utrkzr/piio.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

  <script src="{{asset("js/main.js")}}?v={{$cache}}" charset="utf-8"></script>

  {{-- custom scripts --}}
  <script type="text/javascript">
    var markNotificationAsReadUrl = "{{url("markNotificationAsRead")}}";
    var storeAssetUrl = "{{route($loginRole.".asset.store")}}";
    var deleteAssetUrl = "{{route($loginRole.".asset.destroy", "%deletefileid%")}}";
    var areYouSureTranslation = "{{trans("text.textAreYouSure")}}";
    var confirmTranslation = "{{trans("text.textConfirm")}}";
    var cancelTranslation = "{{trans("text.textCancel")}}";
  </script>
  @yield("scripts")
</body>
</html>
