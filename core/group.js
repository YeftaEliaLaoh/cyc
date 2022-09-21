function map_activity_v3(controllerName){
    $.getScript( "assets/plugins/nestable/jquery.nestable.js" ).done(function(){
        first_time = false;
        first_time_field = false;
        first_time2 = false;
        first_time_field2 = false;
        updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
            output = list.data('output');
            if (first_time == true) {
                if (window.JSON) {
                    if (window.JSON.stringify(list.nestable('serialize')) == lastData) {
                        return;
                    } else {
                        lastData = window.JSON.stringify(list.nestable('serialize'));
                        DZ.ajax({
                            url: controllerName+'/updatePiorityArea',
                            data: list.nestable('serialize'),
                            success:  function(data){
                                if (data.status === 'error') {
                                    DZ.showModalAlertWarning(data.txt);
                                } else {
                                    DZ.showAlertSuccess(data.txt);
                                }
                            }
                        })
                        output.val(window.JSON.stringify(list.nestable('serialize')));
                    }
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            }else{
                lastData = window.JSON.stringify(list.nestable('serialize'));
                first_time = true;
            }

        };
        updateOutput2 = function(e)
        {
            var list   = e.length ? e : $(e.target),
            output = list.data('output');
            if (first_time2 == true) {
                if (window.JSON) {
                    if (window.JSON.stringify(list.nestable('serialize')) == lastData) {
                        return;
                    }else{
                        lastData = window.JSON.stringify(list.nestable('serialize'));
                        DZ.ajax({
                            url: controllerName+'/updatePiorityArea2',
                            data: list.nestable('serialize'),
                            success:  function(data){
                                if (data.status === 'error') {
                                    DZ.showModalAlertWarning(data.txt);
                                } else {
                                    DZ.showAlertSuccess(data.txt);
                                }
                            }
                        })
                        output.val(window.JSON.stringify(list.nestable('serialize')));
                    }
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            }else{
                lastData = window.JSON.stringify(list.nestable('serialize'));
                first_time2 = true;
            }

        };
        $('#nestable2').nestable().on('change', updateOutput2);
        updateOutput2($('#nestable2').data('output', $('#nestable-output')));
        $('#nestable').nestable().on('change', updateOutput);
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    })
}

function getDataMapActivity(controllerName){
    DZ.ajax({
        url: controllerName+'/getActivity/',
        success: function(data)
        {
            for (var i = 0; i < data.length; i++) {
                var mData = data[i];
                keluar += genereteListNestAble(0 ,mData.children, mData.id, mData.text, mData.type, mData.is_deleted);
            }
            $('.dd-list#awal').html(keluar);
        }
    }).done(function(){
        getDataDetail();
    })
}


function getDataDetailMapActivity(controllerName){
    $('.dd3-content a span').click(function(){
        var id = $(this).attr('id');
        var nameList = "Activity "+$(this).parent().parent().parent().parent().parent().parent().find(".name").text()
        $('#textList').text(nameList);
        tampungId = id;

        DZ.ajax({
            url: controllerName+'/getActivity2',
            data: {id:id},
            success: function(data)
            {
                $('.nav-pills a[href="#tab2"]').tab('show');
                var keluar2 = '';
                for (var i = 0; i < data.length; i++) {
                    var mData = data[i];
                    keluar2 += genereteListNestAble2(0 ,mData.children, mData.id, mData.text, mData.type, null, mData.is_deleted);
                }
                $('.dd-list#kedua').html(keluar2);
            }
        }).done(function(){
        })
    })
}


function genereteListNestAble2(flag, have_child, id, name, type, status, is_deleted){
  var html = '';
  if (flag  == 0) {
    html += "<li class='dd-item  dd3-item' data-id='" + id + "' data-type='" + type + "' id='kedua'>";
} else {
    html += "<ol class='dd-list'><li class='dd-item' data-id='" + id + "'>";
}
html += '<div class="dd-handle dd3-handle"></div>';
html += '<div class="dd3-content row">';

if (type != 'Section') {
    html += "<span class='name' id="+id+">"+ name + "</span>";
}else{
    html += "<span class='name' id="+id+">" + name + "</span>";
}

if (is_deleted == "1") {
    html += '<span class="btn-group" style="float:right;">';
    html += '<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span></button>';
    html += '<ul class="dropdown-menu" role="menu">';
    if (type === 'Section') {
        html += '<li><a onclick=addChild2(\''+id+'\')>Add Child</a></li>';
    }

    html += '<li><a onclick=editData2(\''+id+'\')>Edit</a></li>';
    html += '<li><a onclick=removeData2(\''+id+'\')>Remove</a></li>';


    html += '</ul>';
    html += '</span>';
    html += '</div>';
}


if (have_child) {
    html += "<ol class='dd-list' id='awal'>";
    $.each(have_child, function (index, sub) {
        html += genereteListNestAble2(1 ,sub.children, sub.id, sub.text, sub.type, null, sub.is_deleted);
    });
    html += "</ol>";
}

if (flag == 0) {
    html += '</li>';
} else {
    html += "</ol>";
}
return html;
}


function generateAddNesable2(id_act, id_fld, data, name, parent_id, type, status, is_deleted, dd, awal, olddlist, ddawal, olddlist2){
    if (status == 'I') {
        var id = id_act;
        var getHtml = genereteListNestAble2(0 ,null ,id, name, parent_id, type, is_deleted);
        if (parent_id == 0) {
            $(dd).find(awal).append(getHtml);
        }else{
            $(olddlist).find('[data-id='+parent_id+']').append(getHtml);
        }
    }else{
        var id = id_fld;
        console.log(id);
        if (parent_id == 0) {
            $(ddawal).find('.name#'+id).text(name+' ('+type+')');
        }else{
            console.log($(olddlist2).find('.name#'+id).attr('css'));
            $(olddlist2).find('.name#'+id).text(name+' ('+type+')');
        }
    }
}



function genereteListNestAble(flag ,have_child ,id, name, type, is_deleted){
  var html = '';
  if (flag  == 0) {
    html += "<li class='dd-item  dd3-item' data-id='" + id + "' data-type='" + type + "' id='awal'>";
} else {
    html += "<ol class='dd-list'><li class='dd-item' data-id='" + id + "'>";
}
html += '<div class="dd-handle dd3-handle"></div>';
html += '<div class="dd3-content row">';
html += "<span class='name'>" + name +"</span>";

html += '<span class="btn-group" style="float:right;">';
html += '<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span></button>';
html += '<ul class="dropdown-menu" role="menu">';
html += '<li><a ><span id='+id+' data-title='+name+'>Form Activity</span></a></li>';
if (type === 'nav') {
    html += '<li><a onclick=addChild(\''+id+'\')>Add Child</a></li>';
} else if (type == 'basic_list_form' || type == 'sales_form') {
    html += '<li><a onclick=addListView(\''+id+'\')>Add List View</a></li>';
}
if (is_deleted == "1") {
    html += '<li><a onclick=editData(\''+id+'\')>Edit</a></li>';
    html += '<li><a onclick=removeData(\''+id+'\')>Remove</a></li>';
}

html += '</ul>';
html += '</span>';
html += '</div>';

if (have_child) {
    html += "<ol class='dd-list' id='awal'>";
    $.each(have_child, function (index, sub) {
        html += genereteListNestAble(1 ,sub.children, sub.id, sub.text, sub.type, sub.is_deleted);
    });
    html += "</ol>";
}

if (flag == 0) {
    html += '</li>';
} else {
    html += "</ol>";
}
return html;
}

function generateAddNesable(id_act, id_fld, data, name, parent_id, type, status, is_deleted, dd, awal, olddlist, ddawal, olddlist2){
    if (status == 'I') {
        var id = id_act;
        var getHtml = genereteListNestAble(0 ,null ,id, name, parent_id, type, is_deleted);
        if (parent_id == 'trans') {
            $(dd).find(awal).append(getHtml);
        }else{
            $(olddlist).find('[data-id='+parent_id+']').append(getHtml);
        }
    }else{
        var id = id_fld;
        console.log(id);
        if (parent_id == 'trans') {
            $(".dd [data-id='"+id+"']").find('.name').text(name+' ('+type+')');
            // $(ddawal).find('.name#'+id).text(name+' ('+type+')');
        }else{
            console.log($(olddlist2).find('.name#'+id).attr('css'));
            $(olddlist2).find('.name#'+id).text(name+' ('+type+')');
        }
    }
}

function removeCharacter()
{
    $('[name=dz_acty_id]',formId).keyup(function(){
        var symbol = (/['\"\;]/g)
        var str = $(this).val();
        var replaceStr = str.replace(symbol,"");
        $(this).val(replaceStr);
    })
}


function changeActionField(){
    $('select[name=dz_acty_fld_component]', formId2).change(function(e) {
        var clone = "";
        $('#detail_field').empty();
        $('#ll_is_primary').hide();
        $('#ll_dz_acty_fld_value').hide();
        $('#ll_dz_acty_fld_coloum').hide();
        $('#ll_is_visible').hide();

        $('#ll_dz_acty_fld_name').show();
        $('#ll_dz_acty_fld_enabled').show();
        $('#ll_dz_acty_fld_required').show();

        if($(this).val() == 'EditText') {
            DZ.getDefaultOptionPureClass("general_option/getOptionCompField", '[name=input_type]', 1, "Please Select", {id: $(this).val()}).done(function(){
                $('[name=input_type]', $('#temp_edittext')).change(function(){
                    if ($(this).val() == '2' || $(this).val() == '3') {
                        $('#maxCurency', $('#temp_edittext')).show();
                        $('#maxLength', $('#temp_edittext')).hide();
                    }else{
                        $('#maxCurency', $('#temp_edittext')).hide();
                        $('#maxLength', $('#temp_edittext')).show();
                    }
                    if ($(this).val() == '3') {
                        $('#roundOption', $('#temp_edittext')).show();
                    }else{
                        $('#roundOption', $('#temp_edittext')).hide();
                    }
                })

            });
            clone = $('#temp_edittext').clone();
            $('#detail_field').append(clone);
        } else if($(this).val() == 'Spinner') {
            clone = $('#temp_spinner').clone();
            $('#detail_field').empty();
            $('#detail_field').append(clone);
            DZ.getDefaultOptionPureClass("general_option/getOptionCompField", '[name=action]', 1, "Please Select", {id: $(this).val()}).done(function(){

            });

        } else if($(this).val() == 'Camera') {
             // childSelect('[name=camera_type]');
             clone = $('#temp_camera').clone();
             $('#detail_field').empty();
             $('#detail_field').append(clone);
             DZ.getDefaultOptionPureClass("general_option/getOptionCompField", '[name=camera_type]', 1, "Please Select", {id: $(this).val()}).done(function(){

                // clone = $('#temp_camera').clone();
                // $('#detail_field').append(clone);
            });
         } else if($(this).val() == 'Signature') {
             clone = $('#temp_signature').clone();
             $('#detail_field').empty();
             $('#detail_field').append(clone);
         } else if($(this).val() == 'CheckBox') {
            clone = $('#temp_checkbox').clone();
            $('#detail_field').empty();
            $('#detail_field').append(clone);
            DZ.getDefaultOptionPureClass("general_option/getOptionCompField", '[name=action]', 1, "Please Select", {id: $(this).val()}).done(function(){
                // clone = $('#temp_checkbox').clone();
                // $('#detail_field').append(clone);
            });
        } else if($(this).val() == 'RadioButton') {
            DZ.getDefaultOptionPureClass("general_option/getOptionCompField", '[name=action]', 1, "Please Select", {id: $(this).val()})
            clone = $('#temp_radiobutton').clone();
            $('#detail_field').append(clone);
        } else if($(this).val() == 'LatLong') {
            clone = $('#temp_latlong').clone();
            $('#detail_field').append(clone);
        } else if($(this).val() == 'DatePicker') {
            clone = $('#temp_textview_datepicker').clone();
            $('#detail_field').append(clone);
        }else if($(this).val() == 'Time') {
            DZ.getDefaultOptionPureClass("general_option/getOptionCompField", '[name=format_time]', 1, "Please Select", {id: $(this).val()});
            clone = $('#temp_textview_time').clone();
            $('#detail_field').append(clone);
        }else if($(this).val() == 'AutoGenerate') {
            clone = $('#temp_textview_auto_generate').clone();
            $('#detail_field').append(clone);
        }else if($(this).val() == 'Section') {
            $('#ll_dz_acty_fld_enabled').hide();
            $('#ll_is_primary').hide();
            $('#ll_dz_acty_fld_required').hide();
            $('#ll_dz_acty_fld_value').hide();
            $('#ll_dz_acty_fld_coloum').hide();
            $('#ll_is_visible').hide();

        } else {
            $('#detail_field').empty();
        }

        selectData();
    });
}


function childSelect(type){
    $(type).change(function(){
        $('#etc_camera', '#temp_camera').remove();
        DZ.ajax({
            url: 'general_option/getOptionCompField',
            data: {id:$(this).val()},
            success: function(data){
                console.log(data)
                if (data.length > 0) {
                    var html = '';
                    html += '<div class="form-group" id="etc_camera">'
                    html += '<label for="etc_camera" class="control-label col-md-2"></label>'
                    html += '<div class="col-md-10">';
                    html += '<select name="etc_camera" class="form-control">';
                    html += '<option value="">Please Select</option>';
                    for (var i = 0 ; i < data.length ; i++) {
                        html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                    $('#temp_camera #selectCamera').after(html);
                }else{
                    return;
                }

            }
        })

})
}

function getDataComponent(){
    var getComponent;
    if (component === 'EditText') {
        getComponent = 'getDataEditExt';
    }else if (component === 'Spinner') {
        getComponent = 'getDataSpinner';
    }else if (component === 'Camera') {
        getComponent = 'getDataCamera';
    }else if (component === 'Signature') {
        getComponent = 'getDataSignature';
    }else if (component === 'SpinnerChild') {
        getComponent = 'getDataSpinnerChild';
    }else if (component === 'LatLong') {
        getComponent = 'getDataLatLong';
    }else if (component === 'RadioButton') {
        getComponent = 'getDataRadioButton';
    }else if (component === 'CheckBox') {
        getComponent = 'getDataCheckBox';
    }else if (component === 'Custom.KodePos') {
        getComponent = 'getDataCustom.KodePos';
    }else if (component === 'DatePicker') {
        getComponent = 'getDataDatePicker';
    }else if (component === 'Time') {
        getComponent = 'getDataTime';
    }else if (component === 'AutoGenerate') {
        getComponent = 'getDataAutoGenerate';
    }else{
        return;
    }

    DZ.ajax({
        url: controllerName+'/'+getComponent,
        data: {id:componentId},
        contentType : 'application/json',
        success: function(data) {
            if (component === 'EditText') {
                $('[name=dz_acty_fld_edittext_id]', formId2).val(data.payload.dz_acty_fld_edittext_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=input_type]', formId2).val(data.payload.input_type).trigger('change');
                $('[name=hint]', formId2).val(data.payload.hint);
                if (data.payload.single_line == 1) {
                    $('[name=single_line]', formId2).prop('checked', true);
                }else{
                    $('[name=single_line]', formId2).prop('checked', false);
                }

                $('[name=min_length]', formId2).val(data.payload.min_length);
                $('[name=max_length]', formId2).val(data.payload.max_length);
                $('[name=num_min_digit]', formId2).val(data.payload.num_min_digit);
                $('[name=num_max_digit]', formId2).val(data.payload.num_max_digit);
                $('[name=num_rounding_option]', formId2).val(data.payload.num_rounding_option);
                $('[name=num_decimal_place]', formId2).val(data.payload.num_decimal_place);
                if (data.payload.num_is_format == 1) {
                    $('[name=num_is_format]', formId2).prop('checked', true);
                }else{
                    $('[name=num_is_format]', formId2).prop('checked', false);
                }


            }else if (component === 'Spinner') {
                $('[name=dz_acty_fld_spinner_id]', formId2).val(data.payload.dz_acty_fld_spinner_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=hint]', formId2).val(data.payload.hint);
                $('[name=action]', formId2).val(data.payload.action);
                $('[name=category_option]', formId2).val(data.payload.category_option).trigger('change');
            }else if (component === 'Camera') {
                $('[name=dz_acty_fld_camera_id]', formId2).val(data.payload.dz_acty_fld_camera_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=camera_type]', formId2).val(data.payload.camera_type);
                $('[name=path_folder]', formId2).val(data.payload.path_folder);

            }else if (component === 'Signature') {
                $('[name=dz_acty_fld_signature_id]', formId2).val(data.payload.dz_acty_fld_signature_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=path_folder]', formId2).val(data.payload.path_folder);
                $('[name=description]', formId2).val(data.payload.description);
            }else if (component === 'SpinnerChild') {
                $('[name=dz_acty_fld_spinner_child_id]', formId2).val(data.payload.dz_acty_fld_spinner_child_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=hint]', formId2).val(data.payload.hint);
                $('[name=action]', formId2).val(data.payload.action);
                $('[name=category_option]', formId2).val(data.payload.category_option).trigger('change');
                $('[name=parent_category_option]', formId2).val(data.payload.parent_category_option);

            }else if (component === 'LatLong') {
                $('[name=dz_acty_fld_latlong_id]', formId2).val(data.payload.dz_acty_fld_latlong_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=camera_type]', formId2).val(data.payload.camera_type);
                $('[name=hint]', formId2).val(data.payload.hint);

            }else if (component === 'RadioButton') {
                $('[name=dz_acty_fld_radiobutton_id]', formId2).val(data.payload.dz_acty_fld_radiobutton_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=hint]', formId2).val(data.payload.hint);
                $('[name=action]', formId2).val(data.payload.action);
                $('[name=category_option]', formId2).val(data.payload.category_option).trigger('change');

            }else if (component === 'CheckBox') {
                $('[name=dz_acty_fld_checkbox_id]', formId2).val(data.payload.dz_acty_fld_checkbox_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=hint]', formId2).val(data.payload.hint);
                $('[name=action]', formId2).val(data.payload.action);
                $('[name=category_option]', formId2).val(data.payload.category_option).trigger('change');

            }else if (component === 'Custom.KodePos') {
                $('[name=dz_acty_fld_custom_id]', formId2).val(data.payload.dz_acty_fld_custom_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=custom_target_id]', formId2).val(data.payload.custom_target_id);
                $('[name=api_name]', formId2).val(data.payload.api_name);
            }else if (component === 'DatePicker') {
                $('[name=dz_acty_fld_text_datepicker_id]', formId2).val(data.payload.dz_acty_fld_text_datepicker_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=allow_backdate]', formId2).val(data.payload.allow_backdate);
                $('[name=hint]', formId2).val(data.payload.hint);
            }else if (component === 'Time') {
                $('[name=dz_acty_fld_time_id]', formId2).val(data.payload.dz_acty_fld_time_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=format_time]', formId2).val(data.payload.format_time);
                $('[name=hint]', formId2).val(data.payload.hint);
            }else if (component === 'AutoGenerate') {
                $('[name=dz_acty_fld_auto_generate_id]', formId2).val(data.payload.dz_acty_fld_auto_generate_id);
                $('[name=dz_acty_fld_id]', formId2).val(data.payload.dz_acty_fld_id);
                $('[name=start_number]', formId2).val(data.payload.start_number);
                $('[name=max_length_start_number]', formId2).val(data.payload.max_length_start_number);
                $('[name=suflix]', formId2).val(data.payload.suflix);
                $('[name=prefix]', formId2).val(data.payload.prefix);
                if (data.payload.formula !== null) {
                    var formula = JSON.parse(data.payload.formula);
                    $('[name=prefix]', formId2).prop('disabled', true);
                    $('#tempFormula', formId2).css('display', 'block');
                    var tempFormula = $('#tempFormula');
                    var formFormula = $('#formFormula');
                    var e = formFormula.clone();
                    e.addClass('formFormula').removeAttr('id');
                    $('[name=formula]', e).val(formula[0].formula);
                    $('[name=max_length_prefix]', e).val(formula[0].max_length_prefix);
                    $('[name=prefix]', formId2).val(formula[0].formula);

                    tempFormula.append(e);
                    $('[name=prefix]', formId2).prop('disabled', true);
                }
                $('#formula', formId2).unbind('click').bind('click',function(e){
                    e.preventDefault();
                    $('#tempFormula', formId2).toggle(function(){
                        if ($(this).css('display') == 'none') {
                            $('[name=prefix]', formId2).prop('disabled', false);
                            $('[name=prefix]', formId2).val('');
                            $('.formFormula').remove();
                        }else{
                            var tempFormula = $('#tempFormula');
                            var formFormula = $('#formFormula');
                            var e = formFormula.clone();
                            e.addClass('formFormula').removeAttr('id');
                            var formula = JSON.parse(data.payload.formula);
                            console.log(formula);
                            if (formula != null) {
                                $('[name=formula]', e).val(formula[0].formula);
                                $('[name=max_length_prefix]', e).val(formula[0].max_length_prefix);
                                $('[name=prefix]', formId2).val(formula[0].formula);
                            }

                            $('[name=formula]', e).change(function(){
                                $('[name=prefix]', formId2).val($(this).val());
                            })
                            tempFormula.append(e);
                            $('[name=prefix]', formId2).prop('disabled', true);
                        }
                    });
})
}
}
})
}

function selectData(){
    DZ.ajax({
        url: 'general_option/getDzBasicOption',
        success: function(data){
            $('#detail_field select[name=category_option]').empty();
            $('#detail_field select[name=category_option]').append("<option value=''>Please Select</option>");
            for (var i = 0 ; i < data.length ; i++) {
                $('#detail_field select[name=category_option]').append($("<option></option>").attr("value", data[i].id).text(data[i].name));
            }
        }
    }).done(function(){
        if($('[name=status2]', formId2).val() == "U") {
            getDataComponent();
        }
        $('[name=max_length]').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        $('[name=min_length]').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        $('[name=start_number]').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

        $('#formula', formId2).unbind('click').bind('click',function(e){
            e.preventDefault();
            $('#tempFormula', formId2).toggle(function(){
                if ($(this).css('display') == 'none') {
                    $('[name=prefix]', formId2).prop('disabled', false);
                    $('[name=prefix]', formId2).val('');
                    $('.formFormula').remove();
                }else{
                    var tempFormula = $('#tempFormula');
                    var formFormula = $('#formFormula');
                    var ee = formFormula.clone();
                    ee.addClass('formFormula').removeAttr('id');
                    $('[name=formula]', ee).val('');
                    $('[name=max_length_prefix]', ee).val('');
                    tempFormula.append(ee);
                    $('[name=prefix]', formId2).prop('disabled', true);
                }
            });
        })
    })
}

function removeData2(id, type) {
    var getComponent;
    if (type === 'EditText') {
        getComponent = 'deleteEditExt';
    }else if (type === 'Spinner') {
        getComponent = 'deleteSpinner';
    }else if (type === 'Camera') {
        getComponent = 'deleteCamera';
    }else if (type === 'Signature') {
        getComponent = 'deleteSignature';
    }else if (type === 'SpinnerChild') {
        getComponent = 'deleteSpinnerChild';
    }else if (type === 'LatLong') {
        getComponent = 'deleteLatLong';
    }else if (type === 'RadioButton') {
        getComponent = 'deleteRadioButton';
    }else if (type === 'CheckBox') {
        getComponent = 'deleteCheckBox';
    }else if (type === 'Custom.KodePos') {
        getComponent = 'deleteCustom.KodePos';
    }else if (type === 'DatePicker') {
        getComponent = 'deleteDatePicker';
    }else if (type === 'Time') {
        getComponent = 'deleteTime';
    }else if (type === 'AutoGenerate') {
        getComponent = 'deleteAutoGenerate';
    }else{
        getComponent = 'deleteFld'
    }
    var r = confirm("Do you really  want to delete this data?");
    if (r === true) {
        DZ.ajax({
            url: controllerName+'/'+getComponent,
            data: {id:id},
            contentType : 'application/json',
            success: function(data) {
                if (data.error_code == 0 || data.error_code == 2) {
                    DZ.showAlertSuccess(data.message);
                    $('li[data-id='+id+']').remove();
                } else {
                    DZ.showAlertWarning(data.message);
                }
            }
        });
    }
}


function addListView(id)
{
    $('[name=dz_acty_id]', formId3).val(id);
    DZ.ajax({
        url: controllerName+'/getListView',
        data: {id:id},
        contentType : 'application/json',
        success: function(data) {
            if(data.payload.length > 0) {
                $('#myModal3', formId3).modal('show');

                var detail_field_view = $('#detail_field_view', formId3);
                var temp_list_view = $('#temp_list_view');
                $('.temp_list_view', formId3).remove();
                for (var i = 0; i < data.payload.length; i++) {
                    var mData = data.payload[i];
                    var e = temp_list_view.clone();
                    e.addClass('temp_list_view').removeAttr('id');
                    e.attr('value', mData.dz_acty_fld_id);
                    detail_field_view.append(e);
                    $('[name=FieldViewLabel]', e).text(mData.dz_acty_fld_name);
                    $('[name=FieldViewCheck]', e).val(mData.dz_acty_fld_id);
                    if (mData.dz_fld_view_name == null) {
                        $('#FieldViewName', e).attr('disabled', true);
                        $('[name=FieldViewCheck]', e).prop('checked', false)
                    }else{
                        $('#FieldViewName', e).attr('disabled', false);
                        $('[name=FieldViewCheck]', e).prop('checked', true);
                    }
                    if ($('[name=FieldViewCheck]', e).is(':checked')) {
                        $('#FieldViewName', e).attr('name', mData.dz_acty_fld_id);
                        $('#FieldViewName', e).val(mData.dz_fld_view_name);
                    }

                    $('[name=FieldViewCheck]', e).click(function(){
                        var datas = $(this).parent().parent().parent().parent().parent().parent();
                        if ($(this).is(":checked")) {
                            datas.find('#FieldViewName').removeAttr('disabled');
                            datas.find('#FieldViewName').attr('name', $(this).val());
                        }else{
                            datas.find('#FieldViewName').attr('disabled', true);
                            datas.find('#FieldViewName').removeAttr('name');
                        }
                    })
                }
            } else {
                alert("Field Must be required, please add some field for this action");
            }
        }
    }).done(function(){
        dragMenu();
    });
}

function formAction3() {
    $('#saveForm3',formId3).click(function(e){
        e.preventDefault();
        DZ.ajax({
            url: controllerName+'/formAction3',
            data: DZ.serialize(formId3),
            contentType : 'application/json',
            success: function(data) {
                if (data.error_code == 0 || data.error_code == 2) {
                    DZ.showAlertSuccess(data.message);
                } else {
                    DZ.showAlertWarning(data.message);
                }
            }
        });
    });
}

function dragMenu()
{
    $("#detail_field_view").sortable({
        connectWith: "#detail_field_view",
        axis: 'y',
        update: function( event, ui ) {
            var rowvalue = [];
            $(this).find(".temp_list_view").each(function () {
                rowvalue.push($(this).attr('value'));
            });

            $.ajax({
                url:controllerName+'/update_sorting',
                data: {priority: rowvalue},
                method: 'POST',
                success: function(data){
                    if (data.error_code == 0 || data.error_code == 2) {
                        DZ.showModalAlertSuccess(data.message);
                    } else {
                        DZ.showAlertWarning(data.message);
                    }

                }
            });
        }
    }).disableSelection();
}

function validationMaxMin()
{
    var min = '';
    var max = '';

    $('[name=min_length]').keyup(function(){
        min = $('[name=min_length]').val() + 0;
        if ($(this).val() > 254) {
            $(this).val(255);
        }else if($(this).val() < 0){
            $(this).val(0);
        }else if ($(this).val() == '') {
            $(this).val(0);
        }
    });
    $('[name=max_length]').keyup(function(){
        max = $('[name=max_length]').val() + 0;
        if ($(this).val() > 254) {
            $(this).val(255);
        }else if($(this).val() < 0 || $(this).val() == ''){
            $(this).val(0);
        }
    });
}
