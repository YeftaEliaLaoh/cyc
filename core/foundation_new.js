var DZ = {
  defaultRel: 'content',
  rel: 'content',
  get: {
    'webName': 'Sale$mart',
    'serviceUri': 'index.php/',
    'loginUri': 'index.php/loginbackend'
  },
  blockUI: function (item) {
    $(item).block({
      message: '<img src="assets/images/reload.gif" width="20px" alt="">',
      css: {
        border: 'none',
        padding: '0px',
        width: '20px',
        height: '20px',
        backgroundColor: 'transparent'
      },
      overlayCSS: {
        backgroundColor: '#fff',
        opacity: 0.9,
        cursor: 'wait'
      }
    });
  },
  unblockUI: function (item) {
    $(item).unblock();
  },
  slideToggle: function (item) {
    $(item).slideToggle('fast');
  },
  initDataTable: function (data) {
    var tableId = data.tableId;

    var ret = {};
    ret.url = DZ.get['serviceUri'] + data.url;
    ret.data = data.data || {};
    ret.type = data.type ? 'get' : 'post';
    $(tableId).DataTable().destroy();
    return $(tableId).DataTable( {
      ordering: true,
      processing: true,
      serverSide: true,
      lengthMenu: [[20, 50, -1], [20, 50, "All"]],
      ajax: ret,
      order: [],
      columnDefs: [
      { targets: 'no_sort', orderable: false, "width": "80px" }
      ]
    } );
  },
  initDataTableDash: function (data) {
    var tableId = data.tableId;

    var ret = {};
    ret.url = DZ.get['serviceUri'] + data.url;
    ret.data = data.data || {};
    ret.type = data.type ? 'get' : 'post';
    $(tableId).DataTable().destroy();
    return $(tableId).DataTable( {
      ordering: true,
      processing: true,
      serverSide: true,
      lengthMenu: [[5, 10, -1], ["Top 5", "Top 10", "All"]],
      ajax: ret,
  info: false,
      order: [],
      columnDefs: [
      { targets: 'no_sort', orderable: false, "width": "80px" }
      ]
    } );
  },
  initClearFormInput: function (formId) {
    $(".alert", formId).remove();
    $(':input', formId)
    .not(':button, :submit, :reset, :input[name=status]')
    .val('')
    .removeAttr('checked')
    .removeAttr('selected')
    .removeAttr('readonly');
    $('select', formId).trigger('change');
  },
  ajax: function (data) {
// $( "input:checkbox, input:radio").uniform(); // restore uniform
if($('#loading-main').html() == "") {
  $('#loading-main').html('<div class="modal-loading" style="display: block; padding-left: 0px;"><div id="preloader"></div></div>');
  // $('#loading-main').html('<div class="modal-backdrop fade in loading" style="z-index:99999"><div class="se-pre-con"></div></div>');
}
$(".se-pre-con").show();$(".se-pre-con").fadeOut("slow");
$('button[type="submit"]').prop('disabled', true);
data.url = DZ.get['serviceUri'] + data.url;
data.data = JSON.stringify(data.data) || {};
data.type = data.type ? 'get' : 'post';
data.contentType = 'application/json';
var ret = data;

ret.error = function(jqXHR, textStatus, errorThrown) {
  $('button[type="submit"]').prop('disabled', false);
  $(".se-pre-con").hide();
  if(typeof error == 'function') {
    options.error(jqXHR, textStatus, errorThrown);
    return;
  }

  try {
    var o = $.parseJSON(jqXHR.responseText);
    if(o.status == 'error' && o.errno == '1') {
      location.href=DZ.loginUri;
      return;
    }
  } catch(e) {
    alert('Someting wrong in your connection, please try again');
  // alert('Error occured when parsing JSON. Get response text: ' + jqXHR.responseText);
}
};
ret.complete = function(){
$( "input:checkbox, input:radio").uniform(); // restore uniform

if($('#loading-main').html() != "") {
  $('#loading-main').html("");
}
$('button[type="submit"]').prop('disabled', false);
};

return $.ajax(ret);
},
ajax_silent: function (data) {
// $('button[type="submit"]').prop('disabled', true);
data.url = DZ.get['serviceUri'] + data.url;
data.data = JSON.stringify(data.data) || {};
data.type = data.type ? 'get' : 'post';
data.contentType = 'application/json';
var ret = data;

ret.error = function(jqXHR, textStatus, errorThrown) {
  $('button[type="submit"]').prop('disabled', false);
  $(".se-pre-con").hide();
  if(typeof error == 'function') {
    options.error(jqXHR, textStatus, errorThrown);
    return;
  }

  try {
    var o = $.parseJSON(jqXHR.responseText);
    if(o.status == 'error' && o.errno == '1') {
      location.href=DZ.loginUri;
      return;
    }
  } catch(e) {
    // alert('Someting wrong in your connection, please try again');
  }
};
ret.complete = function(){
// $('button[type="submit"]').prop('disabled', false);
};

return $.ajax(ret);
},
serialize: function (selector, returnStringify) {
  returnStringify = (returnStringify == null) ? false : returnStringify;

  var json = {};
  jQuery.map($(selector).serializeArray(), function (n, i) {
    var cleanName = n.name.replace(/\[\]$/, '');
    if (typeof json[cleanName] == 'undefined') {
      if (/\[\]$/.test(n.name)) {
        json[cleanName] = [n.value];
      } else {
        json[cleanName] = n.value;
      }
    } else {
      if (typeof json[cleanName] == 'object') {
        json[cleanName].push(n.value);
      } else {
        var temp = json[cleanName];
        json[cleanName] = [temp, n.value];
      }
    }
  });

  if (returnStringify) {
    return JSON.stringify(json);
  }

  return json;
},
showAlertSuccess: function (msg){
  $(".alert").remove();
  $('.modal').modal('hide');
  $('.title-content').parent().after('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');

  setTimeout(function(){
    $(".alert").remove();
  },10000);
},
showAlertWarning: function (msg){
  $(".alert").remove();
  $('.modal').modal('hide');
  $('.title-content').parent().after('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');

  setTimeout(function(){
    $(".alert").remove();
  },10000);
},
showModalAlertSuccess: function (msg){
  $(".alert").remove();
  $('.modal-header').after('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');

  setTimeout(function(){
    $(".alert").remove();
  },10000);
},
showModalAlertWarning: function (msg){
  $(".alert").remove();
  $('.modal-header').after('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');

  setTimeout(function(){
    $(".alert").remove();
  },10000);
},
updatedChoosen: function (id, value) {
  $('#'+id).val(value);
  $('#'+id+'_chosen').css('width', '100%');
  $('#'+id).trigger('chosen:updated');
},
checkifNull: function (value, valueIfNull) {
  return (value ?value :valueIfNull)
},
getDefaultOption: function (url_name, view_id, status_default ,default_text, datas) {
  $(view_id).empty();
  $(view_id).select2();
  return DZ.ajax({
    url: url_name,
    data: datas,
    success: function(data){
      if(status_default == 1) {
        if(default_text == "Check All") {
          $(view_id).append("<option value='-1'>"+default_text+"</option>");
        } else {
          $(view_id).append("<option value=''>"+default_text+"</option>");
        }
      }
      for (var i = 0 ; i < data.length ; i++) {
        $(view_id).append($("<option></option>").attr("value", data[i].id).text(data[i].name));
      }
    }
  }).done(function() {
    $(view_id).trigger("change");
    $(".select2").css("width", "100%");
    if(default_text == "Check All") {
      $(view_id).change(function() {
        if($(view_id).val() == "-1") {
          $(view_id).find("option").prop("selected","selected");
          $(view_id).trigger("change");
        }
        $(view_id).find("option:first-child").removeAttr("selected");
      });
    }
  });
},
getDefaultOptionClass: function (url_name, view_id, e, status_default ,default_text, datas) {
  $(view_id, e).empty();
  $(view_id, e).select2();
  return DZ.ajax({
    url: url_name,
    data: datas,
    success: function(data){
      if(status_default == 1) {
        if(default_text == "Check All") {
          $(view_id, e).append("<option value='-1'>"+default_text+"</option>");
        }else if(default_text == "Top" || default_text == "All") {
          $(view_id, e).append("<option value='0'>"+default_text+"</option>");
        } else {
          $(view_id, e).append("<option value=''>"+default_text+"</option>");
        }
      }
      for (var i = 0 ; i < data.length ; i++) {
        $(view_id, e).append($("<option></option>").attr("value", data[i].id).text(data[i].name));
      }
    }
  }).done(function() {
    $(view_id, e).trigger("change");
    $(".select2").css("width", "100%");
    if(default_text == "Check All") {
      $(view_id, e).change(function() {
        if($(view_id, e).val() == "-1") {
          $(view_id+" option", e).prop("selected","selected");
          $(view_id, e).trigger("change");
        }
        $(view_id+" option:first", e).removeAttr("selected");
      });
    }
  });
},


getDefaultOptionPureClass: function (url_name, view_id, status_default ,default_text, datas) {
  $(view_id).empty();
  return DZ.ajax({
    url: url_name,
    data: datas,
    success: function(data){
      $(view_id).append("<option value=''>"+default_text+"</option>");
      for (var i = 0 ; i < data.length ; i++) {
        $(view_id).append($("<option></option>").attr("value", data[i].id).text(data[i].name));
      }
    }
  })
},

getDefaultOptionMultiple: function (url_name, view_id, e, status_default ,default_text = '', datas = null) {

  $(view_id, e).empty();
  $(view_id, e).select2();
  return DZ.ajax({
    url: url_name,
    data: datas,
    success: function(data){
      if(status_default == 1) {
        if(default_text == "Check All") {
          $(view_id, e).append("<option value='-1'>"+default_text+"</option>");
        }else if(default_text == "Top" || default_text == "All") {
          $(view_id, e).append("<option value='0'>"+default_text+"</option>");
        } else {
          $(view_id, e).append("<option value=''>"+default_text+"</option>");
        }
      }
      for (var i = 0 ; i < data.length ; i++) {
        $(view_id, e).append($("<option></option>").attr("value", data[i].id).text(data[i].name));
      }
    }
  }).done(function() {
    $(view_id, e).trigger("change");
    $(".select2").css("width", "100%");
    if(default_text == "Check All") {
      $(view_id, e).change(function() {
        if($(view_id, e).val() == "-1") {
          $(view_id+" option", e).prop("selected","selected");
          $(view_id, e).trigger("change");
        }
        $(view_id+" option:first", e).removeAttr("selected");
      });
    }
  });
},

getDefaultOptionGroupMultiple2: function (url_name, view_id, e, status_default ,default_text = '', datas = null) {
  $(view_id, e).empty();
  $(view_id, e).select2({
    placeholder: default_text,
    allowClear: true
  });

  return DZ.ajax({
    url: url_name,
    data: datas,
    success: function(data){
      var old = "";
      var now = "";
      if(status_default == 1) {
        if(default_text == "Check All") {
          $(view_id, e).append("<option value='-1'>"+default_text+"</option>");
        } else {
          $(view_id, e).append("<option value=''>"+default_text+"</option>");
        }
      }
      var view_group = "";
      for (var i = 0 ; i < data.length ; i++) {
        now = data[i].parent_name;
        if(old != now) {
          if(i != 0) {
            $(view_id, e).append(view_group);
          }
          view_group = ($("<optgroup></optgroup>").attr("label", data[i].parent_name))
        }
        view_group.append($("<option></option>").attr("value", data[i].id).text(data[i].name));

        if(i == (data.length-1)) {
          $(view_id, e).append(view_group);
        }
        old = now;
      }
    }
  }).done(function() {
    $(view_id, e).trigger("change");
    $(".select2").css("width", "100%");
    if(default_text == "Check All") {
      $(view_id, e).change(function() {
        if($(view_id, e).val() == "-1") {
          $(view_id+" option", e).prop("selected","selected");
          $(view_id, e).trigger("change");
        }
        $(view_id+" option:first", e).removeAttr("selected");
      });
    }
  });
},

getDefaultOptionGroup: function (url_name, view_id, e, status_default ,default_text = '', datas = null) {
  $(view_id, e).empty();
  $(view_id, e).select2();
  return DZ.ajax({
    url: url_name,
    data: datas,
    success: function(data){
      var old = "";
      var now = "";
      if(status_default == 1) {
        if(default_text == "Check All") {
          $(view_id, e).append("<option value='-1'>"+default_text+"</option>");
        } else {
          $(view_id, e).append("<option value=''>"+default_text+"</option>");
        }
      }
      var view_group = "";
      for (var i = 0 ; i < data.length ; i++) {
        now = data[i].parent_name;
        if(old != now) {
          if(i != 0) {
            $(view_id, e).append(view_group);
          }
          view_group = ($("<optgroup></optgroup>").attr("label", data[i].parent_name))
        }
        view_group.append($("<option></option>").attr("value", data[i].id).text(data[i].name));

        if(i == (data.length-1)) {
          $(view_id, e).append(view_group);
        }
        old = now;
      }
    }
  }).done(function() {
    $(view_id, e).trigger("change");
    $(".select2").css("width", "100%");
    if(default_text == "Check All") {
      $(view_id, e).change(function() {
        if($(view_id, e).val() == "-1") {
          $(view_id+" option", e).prop("selected","selected");
          $(view_id, e).trigger("change");
        }
        $(view_id+" option:first", e).removeAttr("selected");
      });
    }
  });
},
updatedSelect2: function (view_id, value) {
  if(value != "" && value != null) {
    if (value.indexOf("||") >= 0) {
      var result= value.split('||');
      var value = [];
      for (var i = 0; i < result.length; i++) {
        value.push(result[i]);
      };
    }
  }
  $(view_id).val(DZ.checkifNull(value, ""));
  $(view_id).select2().trigger('change');
  $(".select2").css("width", "100%");
},
updatedSelect2Class: function (view_id, e, value) {
  if(value != "" && value != null) {
    if (value.indexOf("||") >= 0) {
      var result= value.split('||');
      var value = [];
      for (var i = 0; i < result.length; i++) {
        value.push(result[i]);
      };
    }
  }
  $(view_id, e).val(DZ.checkifNull(value, ""));
  $(view_id, e).select2().trigger('change');
  $(".select2").css("width", "100%");

}, addMaxSelectionSelect2: function (view_id, number) {
  $(view_id).select2({
    maximumSelectionLength: number
  }).trigger('change');
  $(".select2").css("width", "100%");
}, clearFormInput: function (view_id) {
  $(':input',view_id).not(':button, :submit, :reset')
  .val('')
  .removeAttr('checked')
  .removeAttr('selected');
  $('.select2-hidden-accessible').select2().trigger('change');
  $(".select2").css("width", "100%");
}, dateNow: function() {
  var d = new Date();
  var month = d.getMonth()+1;
  var day = d.getDate();
  var output = d.getFullYear() + '-' +
  (month<10 ? '0' : '') + month + '-' +
  (day<10 ? '0' : '') + day;
  return output;
}
}

var format = {
  shortDate: function (date) {
    var d = new Date(date);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();

    if (day < 10) {
      day = "0" + day;
    }
    var months = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];

    var selectedMonthName = months[month];
    return day + " " + selectedMonthName + " " + year;
  },
  shortDatePicker: function (date) {
    var d = new Date(date);
    var day = d.getDate();
    var month = d.getMonth()+1;
    var year = d.getFullYear();

    if (month < 10) {
      month = "0" + month;
    }

    if (day < 10) {
      day = "0" + day;
    }

    return day + "-" + month + "-" + year;
  }
}


var curency = function(num){
  var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
  if(str.indexOf(".") > 0) {
    parts = str.split(".");
    str = parts[0];
  }
  str = str.split("").reverse();
  for(var j = 0, len = str.length; j < len; j++) {
    if(str[j] != ",") {
      output.push(str[j]);
      if(i%3 == 0 && j < (len - 1)) {
        output.push(",");
      }
      i++;
    }
  }
  formatted = output.reverse().join("");
  return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
}
