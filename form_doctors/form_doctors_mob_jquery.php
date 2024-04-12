
function scJQGeneralAdd() {
  scLoadScInput('input:text.sc-js-input');
  scLoadScInput('input:password.sc-js-input');
  scLoadScInput('input:checkbox.sc-js-input');
  scLoadScInput('input:radio.sc-js-input');
  scLoadScInput('select.sc-js-input');
  scLoadScInput('textarea.sc-js-input');

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
  scEventControl_data["iddoctor" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["namedoctor" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["speciality_idspeciality" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["treatments_idtreatments" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["node_order" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["day1" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["day2" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["day3" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["day4" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["day5" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["login" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["hmon" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["htue" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["hwed" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["hthu" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["hfri" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["iddoctor" + iSeqRow] && scEventControl_data["iddoctor" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["iddoctor" + iSeqRow] && scEventControl_data["iddoctor" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["namedoctor" + iSeqRow] && scEventControl_data["namedoctor" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["namedoctor" + iSeqRow] && scEventControl_data["namedoctor" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["speciality_idspeciality" + iSeqRow] && scEventControl_data["speciality_idspeciality" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["speciality_idspeciality" + iSeqRow] && scEventControl_data["speciality_idspeciality" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["treatments_idtreatments" + iSeqRow] && scEventControl_data["treatments_idtreatments" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["treatments_idtreatments" + iSeqRow] && scEventControl_data["treatments_idtreatments" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["node_order" + iSeqRow] && scEventControl_data["node_order" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["node_order" + iSeqRow] && scEventControl_data["node_order" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["day1" + iSeqRow] && scEventControl_data["day1" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["day1" + iSeqRow] && scEventControl_data["day1" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["day2" + iSeqRow] && scEventControl_data["day2" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["day2" + iSeqRow] && scEventControl_data["day2" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["day3" + iSeqRow] && scEventControl_data["day3" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["day3" + iSeqRow] && scEventControl_data["day3" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["day4" + iSeqRow] && scEventControl_data["day4" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["day4" + iSeqRow] && scEventControl_data["day4" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["day5" + iSeqRow] && scEventControl_data["day5" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["day5" + iSeqRow] && scEventControl_data["day5" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["login" + iSeqRow] && scEventControl_data["login" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["login" + iSeqRow] && scEventControl_data["login" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["hmon" + iSeqRow] && scEventControl_data["hmon" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["hmon" + iSeqRow] && scEventControl_data["hmon" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["htue" + iSeqRow] && scEventControl_data["htue" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["htue" + iSeqRow] && scEventControl_data["htue" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["hwed" + iSeqRow] && scEventControl_data["hwed" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["hwed" + iSeqRow] && scEventControl_data["hwed" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["hthu" + iSeqRow] && scEventControl_data["hthu" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["hthu" + iSeqRow] && scEventControl_data["hthu" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["hfri" + iSeqRow] && scEventControl_data["hfri" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["hfri" + iSeqRow] && scEventControl_data["hfri" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  if ("speciality_idspeciality" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
  if ("treatments_idtreatments" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
  if ("login" + iSeq == fieldName) {
    scEventControl_data[fieldName]["blur"] = false;
  }
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
  $('#id_sc_field_iddoctor' + iSeqRow).bind('blur', function() { sc_form_doctors_iddoctor_onblur('#id_sc_field_iddoctor' + iSeqRow, iSeqRow) })
                                      .bind('focus', function() { sc_form_doctors_iddoctor_onfocus(this, iSeqRow) });
  $('#id_sc_field_namedoctor' + iSeqRow).bind('blur', function() { setTimeout(function() {sc_form_doctors_namedoctor_onblur('#id_sc_field_namedoctor' + iSeqRow, iSeqRow);}, 300) })
                                        .bind('focus', function() { sc_form_doctors_namedoctor_onfocus(this, iSeqRow) });
  $('#id_sc_field_day1' + iSeqRow).bind('blur', function() { sc_form_doctors_day1_onblur('#id_sc_field_day1' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_day1_onfocus(this, iSeqRow) });
  $('#id_sc_field_day2' + iSeqRow).bind('blur', function() { sc_form_doctors_day2_onblur('#id_sc_field_day2' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_day2_onfocus(this, iSeqRow) });
  $('#id_sc_field_day3' + iSeqRow).bind('blur', function() { sc_form_doctors_day3_onblur('#id_sc_field_day3' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_day3_onfocus(this, iSeqRow) });
  $('#id_sc_field_day4' + iSeqRow).bind('blur', function() { sc_form_doctors_day4_onblur('#id_sc_field_day4' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_day4_onfocus(this, iSeqRow) });
  $('#id_sc_field_day5' + iSeqRow).bind('blur', function() { sc_form_doctors_day5_onblur('#id_sc_field_day5' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_day5_onfocus(this, iSeqRow) });
  $('#id_sc_field_speciality_idspeciality' + iSeqRow).bind('blur', function() { sc_form_doctors_speciality_idspeciality_onblur('#id_sc_field_speciality_idspeciality' + iSeqRow, iSeqRow) })
                                                     .bind('focus', function() { sc_form_doctors_speciality_idspeciality_onfocus(this, iSeqRow) });
  $('#id_sc_field_node_order' + iSeqRow).bind('blur', function() { sc_form_doctors_node_order_onblur('#id_sc_field_node_order' + iSeqRow, iSeqRow) })
                                        .bind('focus', function() { sc_form_doctors_node_order_onfocus(this, iSeqRow) });
  $('#id_sc_field_treatments_idtreatments' + iSeqRow).bind('blur', function() { sc_form_doctors_treatments_idtreatments_onblur('#id_sc_field_treatments_idtreatments' + iSeqRow, iSeqRow) })
                                                     .bind('focus', function() { sc_form_doctors_treatments_idtreatments_onfocus(this, iSeqRow) });
  $('#id_sc_field_login' + iSeqRow).bind('blur', function() { sc_form_doctors_login_onblur('#id_sc_field_login' + iSeqRow, iSeqRow) })
                                   .bind('focus', function() { sc_form_doctors_login_onfocus(this, iSeqRow) });
  $('#id_sc_field_hfri' + iSeqRow).bind('blur', function() { sc_form_doctors_hfri_onblur('#id_sc_field_hfri' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_hfri_onfocus(this, iSeqRow) });
  $('#id_sc_field_hmon' + iSeqRow).bind('blur', function() { sc_form_doctors_hmon_onblur('#id_sc_field_hmon' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_hmon_onfocus(this, iSeqRow) });
  $('#id_sc_field_hthu' + iSeqRow).bind('blur', function() { sc_form_doctors_hthu_onblur('#id_sc_field_hthu' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_hthu_onfocus(this, iSeqRow) });
  $('#id_sc_field_htue' + iSeqRow).bind('blur', function() { sc_form_doctors_htue_onblur('#id_sc_field_htue' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_htue_onfocus(this, iSeqRow) });
  $('#id_sc_field_hwed' + iSeqRow).bind('blur', function() { sc_form_doctors_hwed_onblur('#id_sc_field_hwed' + iSeqRow, iSeqRow) })
                                  .bind('focus', function() { sc_form_doctors_hwed_onfocus(this, iSeqRow) });
} // scJQEventsAdd

function sc_form_doctors_iddoctor_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_iddoctor();
  scCssBlur(oThis);
}

function sc_form_doctors_iddoctor_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_namedoctor_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_namedoctor();
  scCssBlur(oThis);
}

function sc_form_doctors_namedoctor_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_day1_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_day1();
  scCssBlur(oThis);
}

function sc_form_doctors_day1_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_day2_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_day2();
  scCssBlur(oThis);
}

function sc_form_doctors_day2_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_day3_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_day3();
  scCssBlur(oThis);
}

function sc_form_doctors_day3_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_day4_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_day4();
  scCssBlur(oThis);
}

function sc_form_doctors_day4_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_day5_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_day5();
  scCssBlur(oThis);
}

function sc_form_doctors_day5_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_speciality_idspeciality_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_speciality_idspeciality();
  scCssBlur(oThis);
}

function sc_form_doctors_speciality_idspeciality_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_node_order_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_node_order();
  scCssBlur(oThis);
}

function sc_form_doctors_node_order_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_treatments_idtreatments_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_treatments_idtreatments();
  scCssBlur(oThis);
}

function sc_form_doctors_treatments_idtreatments_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_login_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_login();
  scCssBlur(oThis);
}

function sc_form_doctors_login_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_hfri_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_hfri();
  scCssBlur(oThis);
}

function sc_form_doctors_hfri_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_hmon_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_hmon();
  scCssBlur(oThis);
}

function sc_form_doctors_hmon_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_hthu_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_hthu();
  scCssBlur(oThis);
}

function sc_form_doctors_hthu_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_htue_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_htue();
  scCssBlur(oThis);
}

function sc_form_doctors_htue_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function sc_form_doctors_hwed_onblur(oThis, iSeqRow) {
  do_ajax_form_doctors_mob_validate_hwed();
  scCssBlur(oThis);
}

function sc_form_doctors_hwed_onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis);
}

function displayChange_block(block, status) {
        if ("0" == block) {
                displayChange_block_0(status);
        }
        if ("1" == block) {
                displayChange_block_1(status);
        }
        if ("2" == block) {
                displayChange_block_2(status);
        }
        if ("3" == block) {
                displayChange_block_3(status);
        }
        if ("4" == block) {
                displayChange_block_4(status);
        }
        if ("5" == block) {
                displayChange_block_5(status);
        }
}

function displayChange_block_0(status) {
        displayChange_field("iddoctor", "", status);
        displayChange_field("namedoctor", "", status);
        displayChange_field("speciality_idspeciality", "", status);
        displayChange_field("treatments_idtreatments", "", status);
        displayChange_field("node_order", "", status);
        displayChange_field("day1", "", status);
        displayChange_field("day2", "", status);
        displayChange_field("day3", "", status);
        displayChange_field("day4", "", status);
        displayChange_field("day5", "", status);
        displayChange_field("login", "", status);
}

function displayChange_block_1(status) {
        displayChange_field("hmon", "", status);
}

function displayChange_block_2(status) {
        displayChange_field("htue", "", status);
}

function displayChange_block_3(status) {
        displayChange_field("hwed", "", status);
}

function displayChange_block_4(status) {
        displayChange_field("hthu", "", status);
}

function displayChange_block_5(status) {
        displayChange_field("hfri", "", status);
}

function displayChange_row(row, status) {
        displayChange_field_iddoctor(row, status);
        displayChange_field_namedoctor(row, status);
        displayChange_field_speciality_idspeciality(row, status);
        displayChange_field_treatments_idtreatments(row, status);
        displayChange_field_node_order(row, status);
        displayChange_field_day1(row, status);
        displayChange_field_day2(row, status);
        displayChange_field_day3(row, status);
        displayChange_field_day4(row, status);
        displayChange_field_day5(row, status);
        displayChange_field_login(row, status);
        displayChange_field_hmon(row, status);
        displayChange_field_htue(row, status);
        displayChange_field_hwed(row, status);
        displayChange_field_hthu(row, status);
        displayChange_field_hfri(row, status);
}

function displayChange_field(field, row, status) {
        if ("iddoctor" == field) {
                displayChange_field_iddoctor(row, status);
        }
        if ("namedoctor" == field) {
                displayChange_field_namedoctor(row, status);
        }
        if ("speciality_idspeciality" == field) {
                displayChange_field_speciality_idspeciality(row, status);
        }
        if ("treatments_idtreatments" == field) {
                displayChange_field_treatments_idtreatments(row, status);
        }
        if ("node_order" == field) {
                displayChange_field_node_order(row, status);
        }
        if ("day1" == field) {
                displayChange_field_day1(row, status);
        }
        if ("day2" == field) {
                displayChange_field_day2(row, status);
        }
        if ("day3" == field) {
                displayChange_field_day3(row, status);
        }
        if ("day4" == field) {
                displayChange_field_day4(row, status);
        }
        if ("day5" == field) {
                displayChange_field_day5(row, status);
        }
        if ("login" == field) {
                displayChange_field_login(row, status);
        }
        if ("hmon" == field) {
                displayChange_field_hmon(row, status);
        }
        if ("htue" == field) {
                displayChange_field_htue(row, status);
        }
        if ("hwed" == field) {
                displayChange_field_hwed(row, status);
        }
        if ("hthu" == field) {
                displayChange_field_hthu(row, status);
        }
        if ("hfri" == field) {
                displayChange_field_hfri(row, status);
        }
}

function displayChange_field_iddoctor(row, status) {
    var fieldId;
}

function displayChange_field_namedoctor(row, status) {
    var fieldId;
}

function displayChange_field_speciality_idspeciality(row, status) {
    var fieldId;
        if ("on" == status) {
                if ("all" == row) {
                        var fieldList = $(".css_speciality_idspeciality__obj");
                        for (var i = 0; i < fieldList.length; i++) {
                                $($(fieldList[i]).attr("id")).select2("destroy");
                        }
                }
                else {
                        $("#id_sc_field_speciality_idspeciality" + row).select2("destroy");
                }
                scJQSelect2Add(row, "speciality_idspeciality");
        }
}

function displayChange_field_treatments_idtreatments(row, status) {
    var fieldId;
        if ("on" == status) {
                if ("all" == row) {
                        var fieldList = $(".css_treatments_idtreatments__obj");
                        for (var i = 0; i < fieldList.length; i++) {
                                $($(fieldList[i]).attr("id")).select2("destroy");
                        }
                }
                else {
                        $("#id_sc_field_treatments_idtreatments" + row).select2("destroy");
                }
                scJQSelect2Add(row, "treatments_idtreatments");
        }
}

function displayChange_field_node_order(row, status) {
    var fieldId;
}

function displayChange_field_day1(row, status) {
    var fieldId;
}

function displayChange_field_day2(row, status) {
    var fieldId;
}

function displayChange_field_day3(row, status) {
    var fieldId;
}

function displayChange_field_day4(row, status) {
    var fieldId;
}

function displayChange_field_day5(row, status) {
    var fieldId;
}

function displayChange_field_login(row, status) {
    var fieldId;
        if ("on" == status) {
                if ("all" == row) {
                        var fieldList = $(".css_login__obj");
                        for (var i = 0; i < fieldList.length; i++) {
                                $($(fieldList[i]).attr("id")).select2("destroy");
                        }
                }
                else {
                        $("#id_sc_field_login" + row).select2("destroy");
                }
                scJQSelect2Add(row, "login");
        }
}

function displayChange_field_hmon(row, status) {
    var fieldId;
}

function displayChange_field_htue(row, status) {
    var fieldId;
}

function displayChange_field_hwed(row, status) {
    var fieldId;
}

function displayChange_field_hthu(row, status) {
    var fieldId;
}

function displayChange_field_hfri(row, status) {
    var fieldId;
}

function scRecreateSelect2() {
        displayChange_field_speciality_idspeciality("all", "on");
        displayChange_field_treatments_idtreatments("all", "on");
        displayChange_field_login("all", "on");
}
function scResetPagesDisplay() {
        $(".sc-form-page").show();
}

function scHidePage(pageNo) {
        $("#id_form_doctors_mob_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
        if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
                var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
                if (inactiveTabs.length) {
                        var tabNo = $(inactiveTabs[0]).attr("id").substr(24);
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
                         $(t).html("<a href=\"javascript:nm_mostra_doc('0', '"+rs2+"', 'form_doctors_mob')\">"+$('#id_read_on_'+field+iSeqRow).text()+"</a>");
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
  if (null == specificField || "speciality_idspeciality" == specificField) {
    scJQSelect2Add_speciality_idspeciality(seqRow);
  }
  if (null == specificField || "treatments_idtreatments" == specificField) {
    scJQSelect2Add_treatments_idtreatments(seqRow);
  }
  if (null == specificField || "login" == specificField) {
    scJQSelect2Add_login(seqRow);
  }
} // scJQSelect2Add

function scJQSelect2Add_speciality_idspeciality(seqRow) {
  var elemSelector = "all" == seqRow ? ".css_speciality_idspeciality_obj" : "#id_sc_field_speciality_idspeciality" + seqRow;
  $(elemSelector).select2(
    {
      containerCssClass: 'css_speciality_idspeciality_obj',
      dropdownCssClass: 'css_speciality_idspeciality_obj',
      language: {
        noResults: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_notfound'] ?>";
        },
        searching: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_searching'] ?>";
        }
      }
    }
  );
} // scJQSelect2Add

function scJQSelect2Add_treatments_idtreatments(seqRow) {
  var elemSelector = "all" == seqRow ? ".css_treatments_idtreatments_obj" : "#id_sc_field_treatments_idtreatments" + seqRow;
  $(elemSelector).select2(
    {
      containerCssClass: 'css_treatments_idtreatments_obj',
      dropdownCssClass: 'css_treatments_idtreatments_obj',
      language: {
        noResults: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_notfound'] ?>";
        },
        searching: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_searching'] ?>";
        }
      }
    }
  );
} // scJQSelect2Add

function scJQSelect2Add_login(seqRow) {
  var elemSelector = "all" == seqRow ? ".css_login_obj" : "#id_sc_field_login" + seqRow;
  $(elemSelector).select2(
    {
      containerCssClass: 'css_login_obj',
      dropdownCssClass: 'css_login_obj',
      language: {
        noResults: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_notfound'] ?>";
        },
        searching: function() {
          return "<?php echo $this->Ini->Nm_lang['lang_autocomp_searching'] ?>";
        }
      }
    }
  );
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQUploadAdd(iLine);
  scJQSelect2Add(iLine);
  setTimeout(function () { if ('function' == typeof displayChange_field_speciality_idspeciality) { displayChange_field_speciality_idspeciality(iLine, "on"); } }, 150);
  setTimeout(function () { if ('function' == typeof displayChange_field_treatments_idtreatments) { displayChange_field_treatments_idtreatments(iLine, "on"); } }, 150);
  setTimeout(function () { if ('function' == typeof displayChange_field_login) { displayChange_field_login(iLine, "on"); } }, 150);
} // scJQElementsAdd

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

