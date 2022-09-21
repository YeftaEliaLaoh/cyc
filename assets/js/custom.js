var DatePicker = 'DatePicker';
var Camera = 'Camera';
var CheckBox = 'CheckBox';
var Custom = 'Custom';
var Custom_KodePos = 'Custom.KodePos';
var EditText = 'EditText';
var LatLong = 'LatLong';
var RadioButton = 'RadioButton';
var Section = 'Section';
var Spinner = 'Spinner';
var SpinnerChild = 'SpinnerChild';
var Time = 'Time';
var AutoGenerate = 'AutoGenerate';


var tracking_refresh = 0;
var tracking_mytime;
var dz_tracking_mytime;

jQuery(document).ready(function($) {
  initMenu();
  loadRefreshContent();
});

$(window).on('hashchange', function($) {
  var hash = location.hash;
  loadRefreshContent();
});
function initMenu() {
  DZ.ajax({
    url:'menu/getMenu',
    success: function(data) {
      $('.dataMenu').remove();
      $('.dataAnakMenu').remove();
      for (var i = 0; i < data.length; i++) {
        var ul = $('#ul');
        var li_head_menu = $('#li_head_menu');
        var e = li_head_menu.clone();
        e.find('.menu-icon').addClass(data[i].icon);
        if(data[i].url != null) {
          e.find('.arrow').remove();
          e.removeClass('droplink');
          $('#ul_anak', e).remove();
          if (data[i].url.indexOf("/") >= 0) {
            $('#link_menu_head', e).attr('href', data[i].full_url);
          } else {
            $('#link_menu_head', e).attr('href','#'+data[i].url);
          }
          // $('#link_menu_head', e).attr('href', data[i].url);
        }
        e.removeClass('li_head_menu').removeAttr('id').addClass('dataMenu').show();
        $('#nama_head_menu', e).text(data[i].menu_name);
        ul.append(e);
        for (var a = 0; a < data[i].detail.length; a++) {
          var ul_anak = $('#ul_anak', e);
          var li_anak_menu = $('#li_anak_menu', e);
          var ee = li_anak_menu.clone();
          ee.removeAttr('id').addClass('dataAnakMenu').show();
          $('#nama_anak_menu', ee).text(data[i].detail[a].menu_name);
          $('#nama_anak_menu', ee).attr('data-name', data[i].menu_name);
          $('#nama_anak_menu', ee).attr('data-load', data[i].detail[a].url);
          ee.attr('data-name', data[i].detail[a].menu_name);
          ee.addClass("nav_"+data[i].detail[a].url);

          if(data[i].detail[a].url != null) {
            $('#nama_anak_menu', ee).attr('href','#'+data[i].detail[a].url);
          }
          ul_anak.append(ee);
        }
      }
      $('.dataAnakMenu').click(function(e){
        $('.dataAnakMenu').removeClass("active");
        $(this).addClass('active');
        // $('#viewTitle').html(' > '+$(this).find('a').attr('data-name'));
      });
    }
  }).done(function(){
    $.getScript("assets/js/modern.min.js");
  });
}

function loadHtmlContent(url){
  $.ajax({
    mimeType: 'text/html; charset=utf-8',
    dataType: "html",
    url: url,
    type: 'GET',
    beforeSend : function() {
      if($('#loading-main').html() == "") {
        $('#loading-main').html('<div class="modal-loading" style="display: block; padding-left: 0px;"><div id="preloader"></div></div>');
      }
      $(".se-pre-con").show();$(".se-pre-con").fadeOut("slow");
      $('#load_view_content').html('<div class="loading_content">LOADING</div>');
    },
    success: function(data) {

      $('#load_view_content').html(data);

  $('[data-toggle="tooltip"]').tooltip();
    // $('[data-toggle="tooltip"]').tooltip("hide");
     //  $("<link/>", {
     //   rel: "stylesheet",
     //   type: "text/css",
     //   href: "assets/plugins/bootstrap/css/bootstrap.min.css"
     // }).appendTo("#load_view_content");

    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('#load_view_content').html("PAGE NOT FOUND");
      if($('#loading-main').html() != "") {
        $('#loading-main').html();
      }
      $('.loading_content').remove();
    },
    complete : function (){
      if($('#loading-main').html() != "") {
        $('#loading-main').html("");
      }
      $('.loading_content').remove();
    // $('#viewTitle').html(' > '+$(".nav_"+url).parent().parent().attr('data-name'));
    // $('#title_page').html(DZ.get.webName+' | '+$(".nav_"+url).parent().parent().attr('data-name'));
  },
});
}

function loadRefreshContent(){
  if(window.location.hash.substr(1) != "") {
      clearTimeout(tracking_mytime);
      tracking_mytime = null;

    $(".dataAnakMenu").removeClass("active");
    $(".nav_"+window.location.hash.substr(1)).addClass("active");
    $(".nav_"+window.location.hash.substr(1)).parent().parent().addClass("open");
    loadHtmlContent(window.location.hash.substr(1));
  } else {
  }
}

function generateForm()
{
  DZ.ajax({
    url: controllerName+'/generateListForm',
    contentType : 'application/json',
    success: function(data) {
      var temp_fld_user = $('#temp_fld_user', actionForm);
      for (var i = 0; i < data.payload.detail.length; i++) {
        var html = '';
        var type = '';
        var mData = data.payload.detail[i];
        var mDataC = mData.component;
        html += '<div class="form-group">';
        if (mData.dz_acty_fld_component == EditText) {
          html += ediTextForm(html, mData, mDataC);
        }else if (mData.dz_acty_fld_component == DatePicker) {
          html += textDatepicker(html, mData, mDataC);
        }else if(mData.dz_acty_fld_component == Camera){
          html +=cameraForm(html, mData, mDataC);
        }else if (mData.dz_acty_fld_component == Spinner || mData.dz_acty_fld_component == RadioButton || mData.dz_acty_fld_component == 'CheckBox') {
          html += spinerRadioForm(html, mData, mDataC);
        }else if(mData.dz_acty_fld_component == Time){
          html += timeForm(html, mData, mDataC);
        }else if(mData.dz_acty_fld_component == AutoGenerate){
          html += autoGenerateForm(html, mData, mDataC);
        }
        html += '</div>';
        temp_fld_user.append(html);
      }
    }
  }).done(function(data){
    generateSelect(data);
  })
}


function generateSelect(data)
{
  for (var i = 0; i < data.payload.detail.length; i++) {
    var mData = data.payload.detail[i];
    var mDataC = mData.component;

    if (mData.dz_acty_fld_component == EditText) {
      if (mData.component.max_length == 0) {
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).removeAttr('maxlength');
      }
      if (mData.component.min_length == 0) {
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).removeAttr('minlength');
      }
      if (mData.component.num_max_digit == 0) {
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).removeAttr('max');
      }else{
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).attr('max', mData.component.num_max_digit);
      }
      if (mData.component.num_min_digit == 0) {
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).removeAttr('min');
      }else{
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).attr('min', mData.component.num_min_digit);
      }
      if (mDataC.num_is_format != 0 && mDataC.num_decimal_place != 0) {

        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).number(true, mData.component.num_decimal_place);
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).keyup(function(){
          var valueReal = $(this).val().replace(/,/g, '');
          $(this).parent().find('i').remove();
          if ($(this).attr('max') != 'undefined') {
            if (parseInt(valueReal) > $(this).attr('max')) {
              var e = '<i style="color:red;">Nilai tidak boleh melebihi dari '+$(this).attr('max')+'</i>';
              $(this).parent().append(e);
            }else if (parseInt(valueReal) < $(this).attr('min')) {
              var e = '<i style="color:red;">Nilai tidak boleh kurang dari '+$(this).attr('min')+'</i>';
              $(this).parent().append(e);
            }
          }
        });
        var numDecimalPlace =  mDataC.num_decimal_place;

        if (numDecimalPlace != null) {
          var generatenol = new Array(parseInt(numDecimalPlace - 1)).fill(0);
          var getNol = generatenol.join('');
          var gabVal = parseFloat(1+getNol);
          if (mDataC.num_rounding_option == 3) {
            $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).change(function(){
              var valueReal = $(this).val().replace(/,/g, '');
              var decimalFloat = parseFloat(parseInt(valueReal));
              roundUp = parseFloat(Math.ceil( valueReal * gabVal ) / gabVal).toFixed(parseInt(numDecimalPlace));
              $(this).val(roundUp);
            })
          }else if (mDataC.num_rounding_option == 2) {
            $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).change(function(){
              var valueReal = $(this).val().replace(/,/g, '');
              var decimalFloat = parseFloat(parseInt(valueReal));
              roundDown = parseFloat(Math.floor( valueReal * gabVal ) / gabVal).toFixed(parseInt(numDecimalPlace));
              $(this).val(roundDown);
            })
          }else if (mDataC.num_rounding_option == 1){
            $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).change(function(){
              var valueReal = $(this).val().replace(/,/g, '');
              var decimalFloat = parseFloat(valueReal);
              $(this).val(decimalFloat.toFixed(parseInt(numDecimalPlace) - 1));
            })
          }
        }
      }else if(mData.component.num_decimal_place != 0){
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).number(true, mData.component.num_decimal_place, '.','');
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).keyup(function(){
          var valueReal = $(this).val().replace(/,/g, '');
          $(this).parent().find('i').remove();
          if ($(this).attr('max') != 'undefined') {
            if (parseInt(valueReal) > $(this).attr('max')) {
              var e = '<i style="color:red;">Nilai tidak boleh melebihi dari '+$(this).attr('max')+'</i>';
              $(this).parent().append(e);
            }else if (parseInt(valueReal) < $(this).attr('min')) {
              var e = '<i style="color:red;">Nilai tidak boleh kurang dari '+$(this).attr('min')+'</i>';
              $(this).parent().append(e);
            }
          }
        });

        var numDecimalPlace =  mDataC.num_decimal_place;
        var generatenol = new Array(parseInt(mDataC.num_rounding_option)).fill(0);
        var getNol = generatenol.join('');
        var gabVal = parseFloat(1+getNol);
        if (mDataC.num_rounding_option == 3) {
          $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).change(function(){
            var valueReal = $(this).val().replace(/,/g, '');
            var decimalFloat = parseFloat(parseInt(valueReal));
            roundUp = parseFloat(Math.ceil( valueReal * gabVal ) / gabVal).toFixed(parseInt(numDecimalPlace));
            $(this).val(roundUp);
          })
        }else if (mDataC.num_rounding_option == 2) {
          $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).change(function(){
            var valueReal = $(this).val().replace(/,/g, '');
            var decimalFloat = parseFloat(parseInt(valueReal));
            roundDown = parseFloat(Math.floor( valueReal * gabVal ) / gabVal).toFixed(parseInt(numDecimalPlace));
            $(this).val(roundDown);
          })
        }else if (mDataC.num_rounding_option == 1){
          $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).change(function(){
            var valueReal = $(this).val().replace(/,/g, '');
            var decimalFloat = parseFloat(valueReal);
            $(this).val(decimalFloat.toFixed(parseInt(numDecimalPlace) - 1));
          })
        }

      }
      if (mData.component.input_type == 1) {
        if (mData.is_primary == 1) {
          $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).keydown(function(e){
            if (e.keyCode == 32) return false;
          })
        }
      }else if (mData.component.input_type == 2 || mData.component.input_type == 3) {
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        $('[name="'+mData.dz_acty_fld_coloum+'"]', formId).on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
      }
    }else if (mData.dz_acty_fld_component == Spinner) {
      $('select[name="'+mData.dz_acty_fld_coloum+'"]').empty();
      $('select[name="'+mData.dz_acty_fld_coloum+'"]').append("<option value=''>Please Select</option>");
      for (var aa = 0; aa < mData.querySpiner.length; aa++) {
        var mDataQuerySpiner = mData.querySpiner[aa];
        $('select[name="'+mData.dz_acty_fld_coloum+'"]').append($("<option></option>").attr("value", mDataQuerySpiner.id).text(mDataQuerySpiner.name));
      };
    }else if (mData.dz_acty_fld_component == RadioButton) {
      for (var aa = 0; aa < mData.querySpiner.length; aa++) {
        var mDataQuerySpiner = mData.querySpiner[aa];
        $('#temp_radio').append('<input type="radio" name="'+mData.dz_acty_fld_coloum+'" data-id="'+mDataQuerySpiner.id+'" style="margin-left:20px;"><span style="margin-left:20px;">'+mDataQuerySpiner.name+'</span>');
      };
      $('input[type=radio]').change(function(){
        var id = $(this).attr('data-id');
        if($(this).is(':checked')) {
          $(this).val(id);
        }else {
          $(this).val('');
        }
      })
    }else if (mData.dz_acty_fld_component == 'CheckBox') {
      for (var aa = 0; aa < mData.querySpiner.length; aa++) {
        var mDataQuerySpiner = mData.querySpiner[aa];
        $('#temp_checkbox').append('<input type="checkbox" name="'+mData.dz_acty_fld_coloum+'[]" value="'+mDataQuerySpiner.id+'" data-id="'+mDataQuerySpiner.id+'" style="margin-left:20px;"><span style="margin-left:20px;">'+mDataQuerySpiner.name+'</span>');
      };
      $('input[type=checkbox]').change(function(){
        var id = $(this).attr('data-id');
        if($(this).is(':checked')) {
          $(this).val(id);
        }else {
          $(this).val('');
        }
      })
    }else if (mData.dz_acty_fld_component == DatePicker) {
      $('[name="'+mData.dz_acty_fld_coloum+'"]').datepicker();
    }else if (mData.dz_acty_fld_component == Time) {
      if (mData.component.format_time == '1') {
        $('[name="'+mData.dz_acty_fld_coloum+'"]').datetimepicker({
          format:'HH:mm'
        });
      }else if(mData.component.format_time == '2'){
        $('[name="'+mData.dz_acty_fld_coloum+'"]').datetimepicker({
          format:'LT'
        });
      }

    }

    $('select[name="'+mData.dz_acty_fld_coloum+'"]').css('width', '100%');
    $('select[name="'+mData.dz_acty_fld_coloum+'"]').select2();
  }
}


function ediTextForm(html, mData, mDataC){
  var type = '';
  html += '<label class="control-label col-md-3">'+mData.dz_acty_fld_name+'</label>';
  html += '<div class="col-md-9">';
  if (mDataC.single_line == 1) {
    if (mDataC.input_type == 1) {
      type = 'text';
    }else if(mDataC.input_type == 2 || mDataC.input_type == 3){
      type = 'text';
    }else if (mDataC.input_type == 224) {
      type = 'password';
    }else if (mDataC.input_type == 48){
      type = 'email';
    }else{
      type = 'text';
    }

    if (mData.is_visible == 0) {
      type = 'hidden';
    }
    if (mData.dz_acty_fld_required == 1) {
      var required = 'required';
    }
    html += '<input type="'+type+'" minlength='+mData.component.min_length+' maxlength='+mData.component.max_length+' name="'+mData.dz_acty_fld_coloum+'" value="'+mData.dz_acty_fld_value+'" class="form-control" '+required+'>';
  }else{
    html += '<textarea type="'+type+'" name="'+mData.dz_acty_fld_coloum+'" value="'+mData.dz_acty_fld_value+'" class="form-control"></textarea>';
  }
  html += '</div>';
  return html;
}

function textDatepicker(html, mData, mDataC)
{
  html += '<label class="control-label col-md-3">'+mData.dz_acty_fld_name+'</label>';
  html += '<div class="col-md-9">';
  html += '<input type="text" name="'+mData.dz_acty_fld_coloum+'" value="'+mData.dz_acty_fld_value+'" class="form-control">';
  html += '</div>';
  return html;
}
function timeForm(html, mData, mDataC)
{
  html += '<label class="control-label col-md-3">'+mData.dz_acty_fld_name+'</label>';
  html += '<div class="col-md-9">';
  html += '<input type="text" name="'+mData.dz_acty_fld_coloum+'" value="'+mData.dz_acty_fld_value+'" class="form-control">';
  html += '</div>';
  return html;
}

function cameraForm(html, mData, mDataC){
  html += '<label class="control-label col-md-3">'+mData.dz_acty_fld_name+'</label>';
  html += '<div class="col-md-9">';
  html += '<input type="file" name="'+mData.dz_acty_fld_coloum+'" id="uploadFile" value="'+mData.dz_acty_fld_value+'" class="form-control">';
  html += '</div>';
  return html;
}

function spinerRadioForm(html, mData, mDataC){
  html += '<label class="control-label col-md-3">'+mData.dz_acty_fld_name+'</label>';
  html += '<div class="col-md-9">';
  if (mData.dz_acty_fld_component == Spinner) {
    html += '<select type="text" name="'+mData.dz_acty_fld_coloum+'"  class="form-control"></select>';
  }else if (mData.dz_acty_fld_component == RadioButton) {
    html += '<div id="temp_radio">';
  }else if (mData.dz_acty_fld_component == 'CheckBox') {
    html += '<div id="temp_checkbox">';
  }
  html += '</div>';
  return html;
}


function autoGenerateForm(html, mData, mDataC)
{
  console.log(mData);
  html += '<label class="control-label col-md-3">'+mData.dz_acty_fld_name+'</label>';
  html += '<div class="col-md-9">';
  html += '<input type="text" minlength ="'+mDataC.max_length_start_number+'" maxlength=="'+mDataC.max_length_start_number+'" name="'+mData.dz_acty_fld_coloum+'" value="'+mData.dz_acty_fld_value+'" class="form-control" placeholder="[Auto Generate]" disabled>';
  html += '</div>';
  return html;
}


function generateEditFrom(data){
  console.log(data);
  for (var i = 0; i < data.payload.length; i++) {
    var mData = data.payload[i];
    if (mData.fld_component == DatePicker) {
      $('[name='+mData.dz_acty_fld_coloum+']', formId).data('datepicker').setDate(moment(mData.fld_value).format("DD-MM-YYYY"));
    }else if (mData.is_primary == '1') {
      $('[name='+mData.dz_acty_fld_coloum+']', formId).val(mData.fld_value).attr('readonly', true);
    }else if (mData.fld_component == Spinner) {
      var mDataSpiner = JSON.parse(mData.fld_value);
      if (mDataSpiner.id != 'undefined') {
        $('[name='+mData.dz_acty_fld_coloum+']', formId).val(mDataSpiner.id).trigger('change');
      }
    }else if (mData.fld_component == Camera) {
      $('[name='+mData.dz_acty_fld_coloum+']', formId).val('');
    }else if (mData.fld_component == 'CheckBox') {
      var mDataCheckBox = JSON.parse(mData.fld_value);
      for (var a = 0; a < mDataCheckBox.length ; a++) {
        var getDataCheckBox = mDataCheckBox[a];
        $('div#temp_checkbox input[data-id="'+getDataCheckBox.id+'"]').prop('checked', true);
        $('div#temp_checkbox input[data-id="'+getDataCheckBox.id+'"]').val(getDataCheckBox.id);
      }
    }else if (mData.fld_component == RadioButton) {
      var mDataRadioButton = JSON.parse(mData.fld_value);
      if (mDataRadioButton.id != null) {
        $('div#temp_radio input[data-id="'+mDataRadioButton.id+'"]').prop('checked', true);
        $('div#temp_radio input[data-id="'+mDataRadioButton.id+'"]').val(mDataRadioButton.id);
      }
    }else if (mData.fld_component == AutoGenerate) {
      $('[name='+mData.dz_acty_fld_coloum+']', formId).val(mData.fld_value);
      $('[name='+mData.dz_acty_fld_coloum+']', formId).prop('disabled', true);
    }else{
      if (mData.dz_acty_fld_coloum == 'password' || mData.dz_acty_fld_coloum == 'confirm_password') {
        $('[name='+mData.dz_acty_fld_coloum+']', formId).val('');
        $('[name='+mData.dz_acty_fld_coloum+']', formId).removeAttr('required');
      }else{
        $('[name='+mData.dz_acty_fld_coloum+']', formId).val(mData.fld_value);
      }
    }
  }
}

function disabledCharacter(formInput){
  $(formInput).on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
}

function disabledSpace(formInput){
  $(formInput).keydown(function(e){
    if (e.keyCode == 32) return false;
  })
}

function readURL(input, image) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $(image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}