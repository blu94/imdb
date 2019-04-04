// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function() {
  $(this).on('submit',function(e){
    var $form = $(this);

    if ($form.data('submitted') === true) {
      // Previously submitted - don't submit again
      e.preventDefault();
    } else {
      // Mark it so that the next submit can be ignored
      $form.data('submitted', true);
    }
  });

  // Keep chainability
  return this;
};

// prevent double submit
$("form").preventDoubleSubmission();

jQuery.fn.putCursorAtEnd = function() {

  return this.each(function() {

    // Cache references
    var $el = $(this),
        el = this;

    // Only focus if input isn't already
    if (!$el.is(":focus")) {
     $el.focus();
    }

    // If this function exists... (IE 9+)
    if (el.setSelectionRange) {

      // Double the length because Opera is inconsistent about whether a carriage return is one character or two.
      var len = $el.val().length * 2;

      // Timeout seems to be required for Blink
      setTimeout(function() {
        el.setSelectionRange(len, len);
      }, 1);

    } else {

      // As a fallback, replace the contents with itself
      // Doesn't work in Chrome, but Chrome supports setSelectionRange
      $el.val($el.val());

    }

    // Scroll to the bottom, in case we're in a tall textarea
    // (Necessary for Firefox and Chrome)
    this.scrollTop = 999999;

  });

};

// strip html tag from text
function stripHtml(html)
{
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
   // return html.replace(/(<([^>]+)>)/ig,"");
}
// return video thumbnail
// function frameGrabForVideo (file)
// {
//   // check file extension, see:
//   // http://stackoverflow.com/questions/190852/how-can-i-get-file-extensions-with-javascript
//   var comps = file.name.split(".");
//   if (comps.length === 1 || (comps[0] === "" && comps.length === 2)) {
//     return;
//   }
//   var ext = comps.pop().toLowerCase();
//   if (ext == "mov" || ext == "mpeg" || ext == "mp4" || ext == "wmv") {
//     // create a hidden <video> element with video file.
//     FrameGrab.blob_to_video(file).then(
//       function videoRendered(videoEl) {
//         // extract video frame at 1 sec into a 160px image and
//         // set to the <img> element.
//         var frameGrab = new FrameGrab({video: videoEl});
//         frameGrab.grab('img', 1, 160).then(
//           function frameGrabbed(itemEntry) {
//             self.emit('thumbnail', file, itemEntry.container.src);
//           },
//           function frameFailedToGrab(reason) {
//             console.log("Can't grab the video frame from file: " + file.name + ". Reason: " + reason);
//           }
//         );
//       },
//       function videoFailedToRender(reason) {
//         console.log("Can't convert the file to a video element: " + file.name + ". Reason: " + reason);
//       }
//     );
//   }
// }

// return thumbnail
function assetThumbnail (format, url, id)
{
  var thumbnailUrl = url;
  if (format == "mp4") {
    // add video
    var video = document.createElement("video");
    if (video.canPlayType("video/mp4")) {
      video.setAttribute("src", url);
    } else {
      video.setAttribute("src", url);
    }
    video.autoplay = false;

    $(".dz-preview[id='"+id+"']").find(".dz-image").html(video).append("<i class='fa fa-play-circle-o videoIcon'></i>");
  }
}

// mark sidebar navigation
function markSideNav (footPrint)
{
  var sideNavArr = footPrint.split('-');
  if (sideNavArr.length == 1) {
    $(".markSideBar[data-nav-lvl='"+footPrint+"']").addClass("active");
  }
  else if (sideNavArr.length > 1) {
    $(".markSideBar[data-nav-lvl='"+footPrint+"']").addClass("active-page");

    var footPrint = num = "";
    for (var i = 0; i < (sideNavArr.length - 1); i++) {
      for (var g = 0; g < (i + 1); g++) {
        footPrint += sideNavArr[g]+"-";
      }

      footPrint = footPrint.slice("-", -1);

      if (g == 0) {
        $(".markSideBar[data-nav-lvl='"+footPrint+"']").addClass("active");
      }
      else if (g > 0) {
        // $(".markSideBar[data-nav-lvl='"+footPrint+"']").addClass("active-page");
      }
      footPrint = "";
    }

    if(sideNavArr.length == 2) {
      $(".markSideBar[data-nav-lvl='"+sideNavArr[0]+"']").addClass("active");
    }
    else if(sideNavArr.length == 3) {
      $(".markSideBar[data-nav-lvl='"+sideNavArr[0]+"']").addClass("active");
      $(".markSideBar[data-nav-lvl='"+sideNavArr[0]+"-"+sideNavArr[1]+"']").addClass("active-page");
    }
  }
}

function defaultCountrySetting ()
{
  $(".defaultCountryDrp").select2({
    placeholder: function(){
      return $(this).data("placeholder");
    },
    allowClear: true
  });

  // set default select
  $(".defaultCountryDrp").each(function() {
    defaultCountryProcess ($(this));
  });

  // on select
  $(".defaultCountryDrp").on("change", function() {
    defaultCountryProcess ($(this));
  });
}

function defaultCountryProcess (targetSelector)
{
  var target = targetSelector.data("target-id");

  // initialize parameters
  var stateWrapper = $(".defaultStateWrapper[data-target-id='"+target+"']");
  var postalWrapper = $(".defaultPostalWrapper[data-target-id='"+target+"']");
  if (typeof target === "undefined") {
    stateWrapper = $(".defaultStateWrapper");
    postalWrapper = $(".defaultPostalWrapper");
  }

  // state settings
  stateWrapper.hide();
  var stateOptionData = targetSelector.find("option:selected").data("state-options");
  if (typeof stateOptionData !== "undefined") {
    var stateOptionArr = stateOptionData.split(",");
    var stateOption = "";
    $.each(stateOptionArr, function(index, value) {
      stateOption += "<option value='"+value+"'>"+value+"</option>";
    });

    stateWrapper.find(".defaultStateDrp").html(stateOption);
    selectStateFn (stateWrapper.find(".defaultStateDrp"));

    // show or hide state
    stateOptionArr = stateOptionArr.filter(v=>v!='');
    if (stateOptionArr.length > 0) {
      stateWrapper.show();
    }
  }



  // get use postal option
  var usePostal = targetSelector.find("option:selected").data("use-postal");
  // show or hide postal
  if (usePostal == 1) {
    postalWrapper.show();
  }
  else {
    postalWrapper.hide();
    postalWrapper.find(".defaultPostalInput").val("");
  }
}

function selectStateFn (target)
{
  var selectedState = target.data("selected-value");
  target.find("option[value='"+selectedState+"']").attr("selected", true);
}

$(document).ready(function() {

  setTimeout(function() {
      $(".preloader-it").fadeOut("fast");
  }, 2000);

  // lozad
  // const observer = lozad('.lozad', {
  //   load: function(el) {
  //       el.src = el.dataset.src;
  //       el.onload = function() {
  //           el.classList.add('lazyLoadFade')
  //       }
  //   }
  // }).observe();


  $(function(){
    $(".dropzone").sortable({
      items: ".dz-preview",
      cursor: "move",
      opacity: 0.5,
      containment: ".dropzone",
      distance: 20,
      tolerance: "pointer"
    });
  });

  // data table
  var table = $(".paginateTable").DataTable({
    order: [],
    columnDefs: [{
      targets: "noSort",
      orderable: false
    }],
  });

  var table = $(".announcementPaginateTable").DataTable({
    order: [[ 1, "DESC" ]],
    columnDefs: [{
      targets: "noSort",
      orderable: false
    }],
  });

  var header = $(".heading-bg");
  if (header.length > 0) {
    $(".container-fluid").removeClass("pt-20");
  }

  // prompt user to confirm when remove or danger action
  $(".dangerAction").click(function(e, params) {
    var actionMessage = $(this).data("action-message");

    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }

    swal({
      title: areYouSureTranslation,
      text: actionMessage,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#f8b32d",
      confirmButtonText: confirmTranslation,
      cancelButtonText: cancelTranslation,
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) {
        // swal({
        //   title: "Deleted!",
        //   // text: "Object deleted.",
        //   type: "success",
        //   timer: 2000,
        //   showConfirmButton: false
        // });
        //
        // setTimeout(function()
        // {
        //   if (isConfirm) {
        //     $(e.currentTarget).trigger(e.type, {'send': true});
        //   }
        // }, 1000);

        if (isConfirm) {
          $(e.currentTarget).trigger(e.type, {'send': true});
        }
      }
      else {
        e.preventDefault();
      }
    });

  });

  // country dropdown
  defaultCountrySetting ();

  // elipsis text
  // $().vEllipsis({
  //   "element": ".ellipsisSentence",
  //   "expandLink": true,
  //   "collapseLink": true,
  //   "animationTime": "2000",
  //   "additionalEnding": true
  // });

  // select2 dropdown
  $(".tagsDropdown").select2({
    "tags": true,
    allowClear: true,
    placeholder: function(){
      return $(this).data("placeholder");
    }
  });

  $(".normalDropdown").select2({
    allowClear: true,
    placeholder: function(){
      return $(this).data("placeholder");
    }
  });




  // paginate with list.js
  $(".paginateCard").each(function() {
    var valueArrays = [
      "listsTitle",
      "listsName",
      "listsUsername",
      "listsDate",
      "listsMonth",
      "listsPrice",
      "listsSize",
      "listsAddress",
      "listsPropertyType",
      "listsListingType",
      "listsPostcode",
      "listsCity",
      "listsState",
      "listsStatus"
    ];

    var pageNumber = 24;
    if ($(this).data("page-number")) {
      pageNumber = $(this).data("page-number");
    }
    var options = {
      // valueNames: [ { data: ['timestamp'] }, { data: ['status'] }, 'jSortNumber', 'jSortName', 'jSortTotal' ],
      valueNames: valueArrays,
      page: pageNumber,
      pagination: {
        innerWindow: 1,
        left: 1,
        right: 1,
        paginationClass: "paginationTarget",
      }
    };

    var id = $(this).attr("id");
    var hackerList = new List(id, options);

    $(this).find(".next").on('click', function(){
  	    var list = $(this).siblings(".paginationTarget").find("li");
  	    $.each(list, function(position, element){
  	        if($(element).is('.active')){
  	            $(list[position+1]).trigger('click');
  	        }
  	    })
  	});


  	$(this).find(".back").on('click', function(){
  	    var list = $(this).siblings(".paginationTarget").find("li");
  	    $.each(list, function(position, element){
  	        if($(element).is('.active')){
  	            $(list[position-1]).trigger('click');
  	        }
  	    })
  	});

    var targetValueArray = [];
    $(this).find(".listingFilterChk").click(function() {
      var targetChk = $(this).find(".target");
      var check = targetChk.prop('checked');
      var targetValue = targetChk.val().toString().trim().toLowerCase();
      var targetKey = targetChk.val().toString().trim().toLowerCase();

      if (check == true) {
        targetChk.prop("checked", false)
        if (targetValueArray.indexOf(targetValue) > -1) { targetValueArray.splice(targetValueArray.indexOf(targetValue), 1); }
      }
      else {
        targetChk.prop("checked", true)
        targetValueArray.push(targetValue);
      }

      hackerList.filter(function (item) {
        var listsTitleValue = item.values().listsTitle.toString().trim().toLowerCase();
        var listsTitleChk = getCheckedCheckboxValue("listsTitle");

        var listsDateValue = item.values().listsDate.toString().trim().toLowerCase();
        var listsDateChk = getCheckedCheckboxValue("listsDate");

        var listsMonthValue = item.values().listsMonth.toString().trim().toLowerCase();
        var listsMonthChk = getCheckedCheckboxValue("listsMonth");

        var listsUsernameValue = item.values().listsUsername.toString().trim().toLowerCase();
        var listsUsernameChk = getCheckedCheckboxValue("listsUsername");

        var listsDateValue = item.values().listsDate.toString().trim().toLowerCase();
        var listsDateChk = getCheckedCheckboxValue("listsDate");

        var listsPriceValue = item.values().listsPrice.toString().trim().toLowerCase();
        var listsPriceChk = getCheckedCheckboxValue("listsPrice");

        var listsSizeValue = item.values().listsSize.toString().trim().toLowerCase();
        var listsSizeChk = getCheckedCheckboxValue("listsSize");
        var listsSizeResult = false;
        for (var i = 0; i < listsSizeChk.length; i++) {
          if (listsSizeValue.indexOf(listsSizeChk[i]) > -1) {
            listsSizeResult = true;
          }
        }

        var listsAddressValue = item.values().listsAddress.toString().trim().toLowerCase();
        var listsAddressChk = getCheckedCheckboxValue("listsAddress");

        var listsPropertyTypeValue = item.values().listsPropertyType.toString().trim().toLowerCase();
        var listsPropertyTypeChk = getCheckedCheckboxValue("listsPropertyType");

        var listsListingTypeValue = stripHtml(item.values().listsListingType.toString().trim()).toLowerCase();
        var listsListingTypeChk = getCheckedCheckboxValue("listsListingType");
        var listsListingTypeResult = false;
        for (var i = 0; i < listsListingTypeChk.length; i++) {
          if (listsListingTypeValue.indexOf(listsListingTypeChk[i]) > -1) {
            listsListingTypeResult = true;
          }
        }
        console.log(listsListingTypeResult);

        var listsPostcodeValue = item.values().listsPostcode.toString().trim().toLowerCase();
        var listsPostcodeChk = getCheckedCheckboxValue("listsPostcode");

        var listsCityValue = item.values().listsCity.toString().trim().toLowerCase();
        var listsCityChk = getCheckedCheckboxValue("listsCity");

        var listsStateValue = item.values().listsState.toString().trim().toLowerCase();
        var listsStateChk = getCheckedCheckboxValue("listsState");

        var listsStatusValue = item.values().listsStatus.toString().trim().toLowerCase();
        var listsStatusChk = getCheckedCheckboxValue("listsStatus");

        if (targetValueArray.length > 0) {
          var typeTest = (listsTitleChk.length > 0 ? ($.inArray(listsTitleValue, listsTitleChk) > -1 || !listsTitleChk) : 1)
          && (listsDateChk.length > 0 ? ($.inArray(listsDateValue, listsDateChk) > -1 || !listsDateChk) : 1)
          && (listsPriceChk.length > 0 ? ($.inArray(listsPriceValue, listsPriceChk) > -1 || !listsPriceChk) : 1)
          && (listsSizeChk.length > 0 ? listsSizeResult : 1)
          && (listsPropertyTypeChk.length > 0 ? ($.inArray(listsPropertyTypeValue, listsPropertyTypeChk) > -1 || !listsPropertyTypeChk) : 1)
          && (listsListingTypeChk.length > 0 ? listsListingTypeResult : 1)
          && (listsPostcodeChk.length > 0 ? ($.inArray(listsPostcodeValue, listsPostcodeChk) > -1 || !listsPostcodeChk) : 1)
          && (listsCityChk.length > 0 ? ($.inArray(listsCityValue, listsCityChk) > -1 || !listsCityChk) : 1)
          && (listsStateChk.length > 0 ? ($.inArray(listsStateValue, listsStateChk) > -1 || !listsStateChk) : 1)
          && (listsUsernameChk.length > 0 ? ($.inArray(listsUsernameValue, listsUsernameChk) > -1 || !listsUsernameChk) : 1)
          && (listsMonthChk.length > 0 ? ($.inArray(listsMonthValue, listsMonthChk) > -1 || !listsMonthChk) : 1)
          && (listsStatusChk.length > 0 ? ($.inArray(listsStatusValue, listsStatusChk) > -1 || !listsStatusChk) : 1);

          return typeTest;
        }
        else {
          return true;
        }
    	});
    	// hackerList.update();

      return false;
    });
  });

  function getCheckedCheckboxValue (name) {
    var checkedArr = [];
    $(".listingFilterChk .target").each(function() {
      if ($(this).attr("name") == name && $(this).prop('checked')) {
        checkedArr.push($(this).val().trim().toLowerCase());
      }
    });

    return checkedArr;
  }

  // dropdown setting
  $(".dropdown.open > .dropdown-toggle").dropdown("toggle");


  // category
  $(".nestable2").find(".openEditCategoryModal").on("mousedown touchstart", function(e){
    var id = $(this).data("category-id");
    var title = $(this).data("title");
    var description = $(this).data("description");
    var url = $("#editCategoryModal").find("form").data("url");
    var readByUser = $(this).data("readbyuser");
    url = url.replace("%categoryId%", id);
    // console.log(url);
    $("#editCategoryModal").find("form").attr("action", url);

    $("#editCategoryModal").find(".modal-title").text(title);
    $("#editCategoryModal").find(".titleInput").val(title);
    $("#editCategoryModal").find(".descriptionInput").val(description);
    $("#editCategoryModal").find("#readByUser").prop("checked", readByUser);

    $("#editCategoryModal").modal("show");
  });

  $(".nestable2").find(".deleteCategory").on("mousedown touchstart", function(e){
    var id = $(this).data("category-id");
    var url = deleteCategoryRoute.replace("%categoryId%", id);
    swal({
      title: "Are You Sure?",
      text: "Confirm delete category?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#f8b32d",
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
          }
        });

        $.ajax({
          type: "DELETE",
          url: url,
          beforeSend: function(){
          },
          success: function(response){
            swal.close();
            console.log(response);
            if (response == "success") {
              location.reload();
            }
          }
        });
      }
      else {
        // e.preventDefault();
      }
    });
  });

  $(".updateOrderBtn").click(function() {
    var order = $(this).siblings(".nestable2").nestable("serialize");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
      }
    });

    var panelToRefresh = $(this).closest('.panel').find('.refresh-container');
    var dataToRefresh = $(this).closest('.panel').find('.panel-wrapper');
    var loadingAnim = panelToRefresh.find('.la-anim-1');
    panelToRefresh.show();

    $.ajax({
      type: "POST",
      data: {
        "order": order
      },
      url: updateCategoryRoute,
      beforeSend: function(){
        setTimeout(function(){
          loadingAnim.addClass('la-animate');
        },100);
      },
      success: function(response){
        console.log(response);

        function completed(){} //function after timeout
        panelToRefresh.fadeOut(800);
        setTimeout(function(){
          loadingAnim.removeClass('la-animate');
        },800);
      }
    });
  });

  // select2 init function
  function initTagsDropdown ($elem) {
    $elem.select2({
      "tags": true
    });
  }

  function initDatetimePicker ($elem) {
    $elem.datetimepicker({
      format: "YYYY-MM-DD",
      // minDate: moment()
    });
  }

  function initSelectPicker ($elem) {
    $elem.selectpicker();
  }

  function initCheckbox($elem, number, name = "chk") {
    $elem.find(".checkbox").attr("id", name+number);
    $elem.find(".checkboxLabel").attr("for", name+number);

    // complete step check
    $(".chkTarget").on("change", function() {
      if ($(this).is(":checked")) {
        $(this).siblings(".chkVaue").val(1);
      }
      else {
        $(this).siblings(".chkVaue").val(0);
      }
    });
  }

  deleteItem();
  function deleteItem ()
  {
    $(".deleteItem").click(function () {
      $(this).closest(".itemWrapper").fadeOut(function() {
        $(this).remove();
      });
    });
  }

  $(".addTemplateBtn").click(function(e) {
    var targetWrapper = $(this).data("target");
    var targetItem = $(this).data("item");

    var item = $(".itemTemplateWrapper").find("."+targetItem).clone();
    $("."+targetWrapper).append(item);

    initTagsDropdown(item.find(".itemTagsDropdown"));
    initDatetimePicker(item.find(".datetimePicker"));
    initSelectPicker(item.find(".stepDropdown"));
    initCheckbox(item.find(".checkboxWrapper"), $(".checkboxWrapper").length);

    deleteItem();
  });

  $(".priceItemTarget .propertyPriceItem, .sizeItemTarget .propertySizeItem, .extraInfoTarget .extraInfoItem, .followUpStepTarget .followUpStepItem").each(function() {
    initTagsDropdown($(this).find(".itemTagsDropdown"));
  });

  $(".followUpStepTarget .followUpStepItem").each(function(i) {
    initCheckbox($(this).find(".checkboxWrapper"), i, "defaultChk");
  });

  // light gallery
  $(".galleryLightbox").lightGallery({
    thumbnail:true,
    animateThumb: false,
    showThumbByDefault: false
  });

  // summary setting
  $(".summaryDetailsBtn").click(function() {
    var $txt = $("#summaryTxtarea");
    var caretPos = $txt[0].selectionStart;
    var textAreaTxt = $txt.val();
    var txtToAdd = $(this).data("value");
    $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
    $txt.putCursorAtEnd() // should be chainable
    .on("focus", function() { // could be on any event
      $txt.putCursorAtEnd()
    });
  });

  $(".clearSummaryBtn").click(function() {
    $("#summaryTxtarea").val("");
  });

  // category switch type
  $(".categoryTab").click(function() {
    var value = $(this).data("value");
    selectCategory (value);
  });

  var categoryVal = $(".categoryTab.active").data("value");
  selectCategory (categoryVal);
  function selectCategory (value) {
    $(".categoryType").find("option").each(function() {
      if ($(this).val() == value) {
        $(this).attr("selected", true);
      }
      else {
        $(this).attr("selected", false);
      }
    });
  }

  // mark notification as read
  $(".markNotificationAsRead").click(function (e) {
    e.stopPropagation();

    $.ajaxSetup({
      headers:
      { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
    });

    $.ajax({
      type: "GET",
      url: markNotificationAsReadUrl,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        if (data == "readed") {
          $(".dropdownNotificationItem").removeClass("unreadNotificationDropdown");
          $(".notificationBadgeAmount").hide();
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
});
