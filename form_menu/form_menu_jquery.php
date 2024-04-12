
function scJQGeneralAdd() {
  scLoadScInput('input:text.sc-js-input');
  scLoadScInput('input:password.sc-js-input');
  scLoadScInput('input:checkbox.sc-js-input');
  scLoadScInput('input:radio.sc-js-input');
  scLoadScInput('select.sc-js-input');
  scLoadScInput('textarea.sc-js-input');

  scJQCheckboxControl_general('')
} // scJQGeneralAdd

function scFocusField(sField) {
  var $oField = $('#id_sc_field_' + sField);

  if (0 == $oField.length) {
    $oField = $('input[name=' + sField + ']');
  }

  if (0 == $oField.length && document.F1.elements[sField]) {
    $oField = $(document.F1.elements[sField]);
  }

  if ($("#id_ac_" + sField).length > 0) {
    if ($oField.hasClass("select2-hidden-accessible")) {
      if (false == scSetFocusOnField($oField)) {
        setTimeout(function() { scSetFocusOnField($oField); }, 500);
      }
    }
    else {
      if (false == scSetFocusOnField($oField)) {
        if (false == scSetFocusOnField($("#id_ac_" + sField))) {
          setTimeout(function() { scSetFocusOnField($("#id_ac_" + sField)); }, 500);
        }
      }
      else {
        setTimeout(function() { scSetFocusOnField($oField); }, 500);
      }
    }
  }
  else {
    setTimeout(function() { scSetFocusOnField($oField); }, 500);
  }
} // scFocusField

function scSetFocusOnField($oField) {
  if ($oField.length > 0 && $oField[0].offsetHeight > 0 && $oField[0].offsetWidth > 0 && !$oField[0].disabled) {
    $oField[0].focus();
    return true;
  }
  return false;
} // scSetFocusOnField

function scEventControl_init(iSeqRow) {
  scEventControl_data["id_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["parent_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["link_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["link_params_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["description_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["description_pt_br_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["description_es_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["node_order_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["is_active_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["id_" + iSeqRow] && scEventControl_data["id_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["id_" + iSeqRow] && scEventControl_data["id_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["parent_" + iSeqRow] && scEventControl_data["parent_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["parent_" + iSeqRow] && scEventControl_data["parent_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["link_" + iSeqRow] && scEventControl_data["link_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["link_" + iSeqRow] && scEventControl_data["link_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["link_params_" + iSeqRow] && scEventControl_data["link_params_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["link_params_" + iSeqRow] && scEventControl_data["link_params_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["description_" + iSeqRow] && scEventControl_data["description_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["description_" + iSeqRow] && scEventControl_data["description_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["description_pt_br_" + iSeqRow] && scEventControl_data["description_pt_br_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["description_pt_br_" + iSeqRow] && scEventControl_data["description_pt_br_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["description_es_" + iSeqRow] && scEventControl_data["description_es_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["description_es_" + iSeqRow] && scEventControl_data["description_es_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["node_order_" + iSeqRow] && scEventControl_data["node_order_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["node_order_" + iSeqRow] && scEventControl_data["node_order_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["is_active_" + iSeqRow] && scEventControl_data["is_active_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["is_active_" + iSeqRow] && scEventControl_data["is_active_" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_active_all() {
  for (var i = 1; i < iAjaxNewLine; i++) {
    if (scEventControl_active(i)) {
      return true;
    }
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  scEventControl_data[fieldName]["change"] = false;
} // scEventControl_onFocus

function scEventControl_onBlur(sFieldName) {
  scEventControl_data[sFieldName]["blur"] = false;
  if (scEventControl_data[sFieldName]["change"]) {
        if (scEventControl_data[sFieldName]["original"] == $("#id_sc_field_" + sFieldName).val() || scEventControl_data[sFieldName]["calculated"] == $("#id_sc_field_" + sFieldName).val()) {
          scEventControl_data[sFieldName]["change"] = false;
        }
  }
} // scEventControl_onBlur

function scEventControl_onChange(sFieldName) {
  scEventControl_data[sFieldName]["change"] = false;
} // scEventControl_onChange

function scEventControl_onAutocomp(sFieldName) {
  scEventControl_data[sFieldName]["autocomp"] = false;
} // scEventControl_onChange

var scEventControl_data = {};

function scJQEventsAdd(iSeqRow) {
  $('#id_sc_field_id_' + iSeqRow).bind('blur', function() { sc_form_menu_id__onblur('#id_sc_field_id_' + iSeqRow, iSeqRow) })
                                 .bind('change', function() { sc_form_menu_id__onchange(this, iSeqRow) })
                                 .bind('focus', function() { sc_form_menu_id__onfocus(this, iSeqRow) });
  $('#id_sc_field_parent_' + iSeqRow).bind('blur', function() { sc_form_menu_parent__onblur('#id_sc_field_parent_' + iSeqRow, iSeqRow) })
                                     .bind('change', function() { sc_form_menu_parent__onchange(this, iSeqRow) })
                                     .bind('focus', function() { sc_form_menu_parent__onfocus(this, iSeqRow) });
  $('#id_sc_field_description_' + iSeqRow).bind('blur', function() { setTimeout(function() {sc_form_menu_description__onblur('#id_sc_field_description_' + iSeqRow, iSeqRow);}, 300) })
                                          .bind('change', function() { sc_form_menu_description__onchange(this, iSeqRow) })
                                          .bind('focus', function() { sc_form_menu_description__onfocus(this, iSeqRow) });
  $('#id_sc_field_description_pt_br_' + iSeqRow).bind('blur', function() { setTimeout(function() {sc_form_menu_description_pt_br__onblur('#id_sc_field_description_pt_br_' + iSeqRow, iSeqRow);}, 300) })
                                                .bind('change', function() { sc_form_menu_description_pt_br__onchange(this, iSeqRow) })
                                                .bind('focus', function() { sc_form_menu_description_pt_br__onfocus(this, iSeqRow) });
  $('#id_sc_field_description_es_' + iSeqRow).bind('blur', function() { setTimeout(function() {sc_form_menu_description_es__onblur('#id_sc_field_description_es_' + iSeqRow, iSeqRow);}, 300) })
                                             .bind('change', function() { sc_form_menu_description_es__onchange(this, iSeqRow) })
                                             .bind('focus', function() { sc_form_menu_description_es__onfocus(this, iSeqRow) });
  $('#id_sc_field_link_' + iSeqRow).bind('blur', function() { sc_form_menu_link__onblur('#id_sc_field_link_' + iSeqRow, iSeqRow) })
                                   .bind('change', function() { sc_form_menu_link__onchange(this, iSeqRow) })
                                   .bind('focus', function() { sc_form_menu_link__onfocus(this, iSeqRow) });
  $('#id_sc_field_link_params_' + iSeqRow).bind('blur', function() { sc_form_menu_link_params__onblur('#id_sc_field_link_params_' + iSeqRow, iSeqRow) })
                                          .bind('change', function() { sc_form_menu_link_params__onchange(this, iSeqRow) })
                                          .bind('focus', function() { sc_form_menu_link_params__onfocus(this, iSeqRow) });
  $('#id_sc_field_node_order_' + iSeqRow).bind('blur', function() { sc_form_menu_node_order__onblur('#id_sc_field_node_order_' + iSeqRow, iSeqRow) })
                                         .bind('change', function() { sc_form_menu_node_order__onchange(this, iSeqRow) })
                                         .bind('focus', function() { sc_form_menu_node_order__onfocus(this, iSeqRow) });
  $('#id_sc_field_profile_' + iSeqRow).bind('change', function() { sc_form_menu_profile__onchange(this, iSeqRow) });
  $('#id_sc_field_is_active_' + iSeqRow).bind('blur', function() { sc_form_menu_is_active__onblur('#id_sc_field_is_active_' + iSeqRow, iSeqRow) })
                                        .bind('change', function() { sc_form_menu_is_active__onchange(this, iSeqRow) })
                                        .bind('focus', function() { sc_form_menu_is_active__onfocus(this, iSeqRow) });
  $('.sc-ui-checkbox-is_active_' + iSeqRow).on('click', function() { scMarkFormAsChanged(); });
} // scJQEventsAdd

function sc_form_menu_id__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_id_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_id__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_id__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_parent__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_parent_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_parent__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_parent__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_description__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_description_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_description__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_description__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_description_pt_br__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_description_pt_br_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_description_pt_br__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_description_pt_br__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_description_es__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_description_es_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_description_es__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_description_es__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_link__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_link_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_link__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_link__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_link_params__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_link_params_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_link_params__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_link_params__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_node_order__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_node_order_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_node_order__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_node_order__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_menu_profile__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
}

function sc_form_menu_is_active__onblur(oThis, iSeqRow) {
  do_ajax_form_menu_validate_is_active_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_menu_is_active__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_menu_is_active__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function displayChange_block(block, status) {
        if ("0" == block) {
                displayChange_block_0(status);
        }
}

function displayChange_block_0(status) {
        displayChange_field("id_", "", status);
        displayChange_field("parent_", "", status);
        displayChange_field("link_", "", status);
        displayChange_field("link_params_", "", status);
        displayChange_field("description_", "", status);
        displayChange_field("description_pt_br_", "", status);
        displayChange_field("description_es_", "", status);
        displayChange_field("node_order_", "", status);
        displayChange_field("is_active_", "", status);
}

function displayChange_row(row, status) {
        displayChange_field_id_(row, status);
        displayChange_field_parent_(row, status);
        displayChange_field_link_(row, status);
        displayChange_field_link_params_(row, status);
        displayChange_field_description_(row, status);
        displayChange_field_description_pt_br_(row, status);
        displayChange_field_description_es_(row, status);
        displayChange_field_node_order_(row, status);
        displayChange_field_is_active_(row, status);
}

function displayChange_field(field, row, status) {
        if ("id_" == field) {
                displayChange_field_id_(row, status);
        }
        if ("parent_" == field) {
                displayChange_field_parent_(row, status);
        }
        if ("link_" == field) {
                displayChange_field_link_(row, status);
        }
        if ("link_params_" == field) {
                displayChange_field_link_params_(row, status);
        }
        if ("description_" == field) {
                displayChange_field_description_(row, status);
        }
        if ("description_pt_br_" == field) {
                displayChange_field_description_pt_br_(row, status);
        }
        if ("description_es_" == field) {
                displayChange_field_description_es_(row, status);
        }
        if ("node_order_" == field) {
                displayChange_field_node_order_(row, status);
        }
        if ("is_active_" == field) {
                displayChange_field_is_active_(row, status);
        }
}

function displayChange_field_id_(row, status) {
    var fieldId;
}

function displayChange_field_parent_(row, status) {
    var fieldId;
}

function displayChange_field_link_(row, status) {
    var fieldId;
}

function displayChange_field_link_params_(row, status) {
    var fieldId;
}

function displayChange_field_description_(row, status) {
    var fieldId;
}

function displayChange_field_description_pt_br_(row, status) {
    var fieldId;
}

function displayChange_field_description_es_(row, status) {
    var fieldId;
}

function displayChange_field_node_order_(row, status) {
    var fieldId;
}

function displayChange_field_is_active_(row, status) {
    var fieldId;
}

function scRecreateSelect2() {
}
function scResetPagesDisplay() {
        $(".sc-form-page").show();
}

function scHidePage(pageNo) {
        $("#id_form_menu_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
        if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
                var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
                if (inactiveTabs.length) {
                        var tabNo = $(inactiveTabs[0]).attr("id").substr(17);
                }
        }
}
function scJQUploadAdd(iSeqRow) {
} // scJQUploadAdd

var api_cache_requests = [];
function ajax_check_file(img_name, field  ,t, p, p_cache, iSeqRow, hasRun, img_before){
    setTimeout(function(){
        if(img_name == '') return;
        iSeqRow= iSeqRow !== undefined && iSeqRow !== null ? iSeqRow : '';
        var hasVar = p.indexOf('_@NM@_') > -1 || p_cache.indexOf('_@NM@_') > -1 ? true : false;

        p = p.split('_@NM@_');
        $.each(p, function(i,v){
            try{
                p[i] = $('[name='+v+iSeqRow+']').val();
            }
            catch(err){
                p[i] = v;
            }
        });
        p = p.join('');

        p_cache = p_cache.split('_@NM@_');
        $.each(p_cache, function(i,v){
            try{
                p_cache[i] = $('[name='+v+iSeqRow+']').val();
            }
            catch(err){
                p_cache[i] = v;
            }
        });
        p_cache = p_cache.join('');

        img_before = img_before !== undefined ? img_before : $(t).attr('src');
        var str_key_cache = '<?php echo $this->Ini->sc_page; ?>' + img_name+field+p+p_cache;
        if(api_cache_requests[ str_key_cache ] !== undefined && api_cache_requests[ str_key_cache ] !== null){
            if(api_cache_requests[ str_key_cache ] != false){
                do_ajax_check_file(api_cache_requests[ str_key_cache ], field  ,t, iSeqRow);
            }
            return;
        }
        //scAjaxProcOn();
        $(t).attr('src', '<?php echo $this->Ini->path_icones ?>/scriptcase__NM__ajax_load.gif');
        api_cache_requests[ str_key_cache ] = false;
        var rs =$.ajax({
                    type: "POST",
                    url: 'index.php?script_case_init=<?php echo $this->Ini->sc_page; ?>',
                    async: true,
                    data:'nmgp_opcao=ajax_check_file&AjaxCheckImg=' + encodeURI(img_name) +'&rsargs='+ field + '&p=' + p + '&p_cache=' + p_cache,
                    success: function (rs) {
                        if(rs.indexOf('</span>') != -1){
                            rs = rs.substr(rs.indexOf('</span>') + 7);
                        }
                        if(rs.indexOf('/') != -1 && rs.indexOf('/') != 0){
                            rs = rs.substr(rs.indexOf('/'));
                        }
                        rs = sc_trim(rs);

                        // if(rs == 0 && hasVar && hasRun === undefined){
                        //     delete window.api_cache_requests[ str_key_cache ];
                        //     ajax_check_file(img_name, field  ,t, p, p_cache, iSeqRow, 1, img_before);
                        //     return;
                        // }
                        window.api_cache_requests[ str_key_cache ] = rs;
                        do_ajax_check_file(rs, field  ,t, iSeqRow)
                        if(rs == 0){
                            delete window.api_cache_requests[ str_key_cache ];

                           // $(t).attr('src',img_before);
                            do_ajax_check_file(img_before+'_@@NM@@_' + img_before, field  ,t, iSeqRow)

                        }


                    }
        });
    },100);
}

function do_ajax_check_file(rs, field  ,t, iSeqRow){
    if (rs != 0) {
        rs_split = rs.split('_@@NM@@_');
        rs_orig = rs_split[0];
        rs2 = rs_split[1];
        try{
            if(!$(t).is('img')){

                if($('#id_read_on_'+field+iSeqRow).length > 0 ){
                                    var usa_read_only = false;

                switch(field){

                }
                     if(usa_read_only && $('a',$('#id_read_on_'+field+iSeqRow)).length == 0){
                         $(t).html("<a href=\"javascript:nm_mostra_doc('0', '"+rs2+"', 'form_menu')\">"+$('#id_read_on_'+field+iSeqRow).text()+"</a>");
                     }
                }
                if($('#id_ajax_doc_'+field+iSeqRow+' a').length > 0){
                    var target = $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href').split(',');
                    target[1] = "'"+rs2+"'";
                    $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href', target.join(','));
                }else{
                    var target = $(t).attr('href').split(',');
                     target[1] = "'"+rs2+"'";
                     $(t).attr('href', target.join(','));
                }
            }else{
                $(t).attr('src', rs2);
                $(t).css('display', '');
                if($('#id_ajax_doc_'+field+iSeqRow+' a').length > 0){
                    var target = $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href').split(',');
                    target[1] = "'"+rs2+"'";
                    $(t).attr('href', target.join(','));
                }else{
                     var t_link = $(t).parent('a');
                     var target = $(t_link).attr('href').split(',');
                     target[0] = "javascript:nm_mostra_img('"+rs_orig+"'";
                     $(t_link).attr('href', target.join(','));
                }

            }
            eval("window.var_ajax_img_"+field+iSeqRow+" = '"+rs_orig+"';");

        } catch(err){
                        eval("window.var_ajax_img_"+field+iSeqRow+" = '"+rs_orig+"';");

        }
    }
   /* hasFalseCacheRequest = false;
    $.each(api_cache_requests, function(i,v){
        if(v == false){
            hasFalseCacheRequest = true;
        }
    });
    if(hasFalseCacheRequest == false){
        scAjaxProcOff();
    }*/
}

$(document).ready(function(){
});

function scJQSelect2Add(seqRow, specificField) {
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQUploadAdd(iLine);
  scJQSelect2Add(iLine);
} // scJQElementsAdd

function scJQCheckboxControl_general(mainContainer) {
    $(mainContainer + '.sc-ui-checkbox-is_active_-control').click(function() { scJQCheckboxControl('is_active_', '__ALL__', this); });
}

function scJQCheckboxControl_updateShow() {
    $('#sc-id-fixedheaders-placeholder .sc-ui-checkbox-is_active_-control').prop("checked", $('#div_hidden_bloco_0 .sc-ui-checkbox-is_active_-control').prop("checked"));
}

function scJQCheckboxControl_updateHide() {
    $('#div_hidden_bloco_0 .sc-ui-checkbox-is_active_-control').prop("checked", $('#sc-id-fixedheaders-placeholder .sc-ui-checkbox-is_active_-control').prop("checked"));
}

function scJQCheckboxControl(sColumn, sSeqRow, oCheckbox) {
  var iSeqRow = '';

  if ('__ALL__' == sColumn || 'is_active_' == sColumn) {
    iSeqRow = ('__REC__' == sSeqRow) ? $(oCheckbox).attr('alt') : '';
    scJQCheckboxControl_is_active_(iSeqRow, oCheckbox.checked);
    if ('__REC__' == sSeqRow) {
      nm_check_insert(iSeqRow);
    }
    else {
      if ('__ALL__' == sColumn || 'is_active_' == sColumn) {
         for (var i = 1; i <= iAjaxNewLine; i++) {
           nm_check_insert(i);
         }
      }
    }
    if ('__ALL__' == sColumn && '__ALL__' == sSeqRow) {
      var $oCheckbox = $(".sc-ui-checkbox-record-all");
      for (var i = 0; i < $oCheckbox.length; i++) {
        if (oCheckbox.checked != $oCheckbox[i].checked) {
          $oCheckbox[i].checked = oCheckbox.checked;
        }
      }
    }
  }

} // scJQCheckboxControl

function scJQCheckboxControl_is_active_(iSeqRow, bChecked) {
  if ('__ALL__' == iSeqRow) {
    var $oCheckbox = $(".sc-ui-checkbox-is_active_");
  }
  else {
    var $oCheckbox = $(".sc-ui-checkbox-is_active_" + iSeqRow);
  }

  var bChanged = false, lcsObjects;
  for (var i = 0; i < $oCheckbox.length; i++) {
    if (bChecked != $oCheckbox[i].checked && !$oCheckbox[i].disabled) {
      $oCheckbox[i].checked = bChecked;
      nm_check_insert(iSeqRow);
      lcsObjects = $($oCheckbox[i]).parent().find(".lcs_switch");
      if (lcsObjects.length) {
        if (bChecked) {
          lcsObjects.lcs_on();
        }
        else {
          lcsObjects.lcs_off();
        }
      }
      bChanged = true;
    }
  }
} // scJQCheckboxControl_is_active_

function scGetFileExtension(fileName)
{
    fileNameParts = fileName.split(".");

    if (1 === fileNameParts.length || (2 === fileNameParts.length && "" == fileNameParts[0])) {
        return "";
    }

    return fileNameParts.pop().toLowerCase();
}

function scFormatExtensionSizeErrorMsg(errorMsg)
{
    var msgInfo = errorMsg.split("||"), returnMsg = "";

    if ("err_size" == msgInfo[0]) {
        returnMsg = "<?php echo $this->Ini->Nm_lang['lang_errm_file_size'] ?>. <?php echo $this->Ini->Nm_lang['lang_errm_file_size_extension'] ?>".replace("{SC_EXTENSION}", msgInfo[1]).replace("{SC_LIMIT}", msgInfo[2]);
    } else if ("err_extension" == msgInfo[0]) {
        returnMsg = "<?php echo $this->Ini->Nm_lang['lang_errm_file_invl'] ?>";
    }

    return returnMsg;
}

