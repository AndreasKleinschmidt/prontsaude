<?php

class grid_nursery_events_rtf
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;
   var $Texto_tag;
   var $Arquivo;
   var $Tit_doc;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();

   //---- 
   function __construct()
   {
      $this->nm_data   = new nm_data("en_us");
      $this->Texto_tag = "";
   }


function actionBar_isValidState($buttonName, $buttonState)
{
    switch ($buttonName) {
    }

    return false;
}


function actionBar_displayState($buttonName)
{
    switch ($buttonName) {
    }
}

function actionBar_getStateHint($buttonName)
{
    switch ($buttonName) {
    }
}

function actionBar_getStateConfirm($buttonName)
{
    switch ($buttonName) {
    }
}

function actionBar_getStateDisable($buttonName)
{
    if (isset($this->sc_actionbar_disabled[$buttonName]) && $this->sc_actionbar_disabled[$buttonName]) {
        return ' disabled';
    }

    return '';
}

function actionBar_getStateHide($buttonName)
{
    if (isset($this->sc_actionbar_hidden[$buttonName]) && $this->sc_actionbar_hidden[$buttonName]) {
        return ' sc-actionbar-button-hidden';
    }

    return '';
}

   //---- 
   function monta_rtf()
   {
      $this->inicializa_vars();
      $this->gera_texto_tag();
      $this->grava_arquivo_rtf();
      if ($this->Ini->sc_export_ajax)
      {
          $this->Arr_result['file_export']  = NM_charset_to_utf8($this->Rtf_f);
          $this->Arr_result['title_export'] = NM_charset_to_utf8($this->Tit_doc);
          $Temp = ob_get_clean();
          if ($Temp !== false && trim($Temp) != "")
          {
              $this->Arr_result['htmOutput'] = NM_charset_to_utf8($Temp);
          }
          $oJson = new Services_JSON();
          echo $oJson->encode($this->Arr_result);
          exit;
      }
      else
      {
          $this->progress_bar_end();
      }
   }

   //----- 
   function inicializa_vars()
   {
      global $nm_lang;
      if (isset($GLOBALS['nmgp_parms']) && !empty($GLOBALS['nmgp_parms'])) 
      { 
          $GLOBALS['nmgp_parms'] = str_replace("@aspass@", "'", $GLOBALS['nmgp_parms']);
          $todox = str_replace("?#?@?@?", "?#?@ ?@?", $GLOBALS["nmgp_parms"]);
          $todo  = explode("?@?", $todox);
          foreach ($todo as $param)
          {
               $cadapar = explode("?#?", $param);
               if (1 < sizeof($cadapar))
               {
                   if (substr($cadapar[0], 0, 11) == "SC_glo_par_")
                   {
                       $cadapar[0] = substr($cadapar[0], 11);
                       $cadapar[1] = $_SESSION[$cadapar[1]];
                   }
                   if (isset($GLOBALS['sc_conv_var'][$cadapar[0]]))
                   {
                       $cadapar[0] = $GLOBALS['sc_conv_var'][$cadapar[0]];
                   }
                   elseif (isset($GLOBALS['sc_conv_var'][strtolower($cadapar[0])]))
                   {
                       $cadapar[0] = $GLOBALS['sc_conv_var'][strtolower($cadapar[0])];
                   }
                   nm_limpa_str_grid_nursery_events($cadapar[1]);
                   nm_protect_num_grid_nursery_events($cadapar[0], $cadapar[1]);
                   if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                   $Tmp_par   = $cadapar[0];
                   $$Tmp_par = $cadapar[1];
                   if ($Tmp_par == "nmgp_opcao")
                   {
                       $_SESSION['sc_session'][$script_case_init]['grid_nursery_events']['opcao'] = $cadapar[1];
                   }
               }
          }
      }
      if (isset($usr_group_id)) 
      {
          $_SESSION['usr_group_id'] = $usr_group_id;
          nm_limpa_str_grid_nursery_events($_SESSION["usr_group_id"]);
      }
      if (isset($usr_login) && isset($NM_contr_var_session) && $NM_contr_var_session == "Yes") 
      {
          $_SESSION['usr_login'] = $usr_login;
          nm_limpa_str_grid_nursery_events($_SESSION["usr_login"]);
      }
      if (isset($lang)) 
      {
          $_SESSION['lang'] = $lang;
          nm_limpa_str_grid_nursery_events($_SESSION["lang"]);
      }
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      require_once($this->Ini->path_aplicacao . "grid_nursery_events_total.class.php"); 
      $this->Tot      = new grid_nursery_events_total($this->Ini->sc_page);
      $this->prep_modulos("Tot");
      $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['SC_Ind_Groupby'];
      if (method_exists($this->Tot,$Gb_geral))
      {
          $this->Tot->$Gb_geral();
          $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['tot_geral'][1];
      }
      if (!$this->Ini->sc_export_ajax) {
          require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
          $this->pb = new scProgressBar();
          $this->pb->setRoot($this->Ini->root);
          $this->pb->setDir($_SESSION['scriptcase']['grid_nursery_events']['glo_nm_path_imag_temp'] . "/");
          $this->pb->setProgressbarMd5($_GET['pbmd5']);
          $this->pb->initialize();
          $this->pb->setReturnUrl("./");
          $this->pb->setReturnOption('volta_grid');
          $this->pb->setTotalSteps($this->count_ger);
      }
      $this->Arquivo    = "sc_rtf";
      $this->Arquivo   .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->Arquivo   .= "_grid_nursery_events";
      $this->Arquivo   .= ".rtf";
      $this->Tit_doc    = "grid_nursery_events.rtf";
   }
   //---- 
   function prep_modulos($modulo)
   {
      $this->$modulo->Ini    = $this->Ini;
      $this->$modulo->Db     = $this->Db;
      $this->$modulo->Erro   = $this->Erro;
      $this->$modulo->Lookup = $this->Lookup;
   }


   //----- 
   function gera_texto_tag()
   {
     global $nm_lang;
      global $nm_nada, $nm_lang;

      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      $this->New_label['doctor_iddoctor'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_doctor_iddoctor'] . "";
      $this->New_label['patients_idpatient'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_patients_idpatient'] . "";
      $this->New_label['complaints'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_complaints'] . "";
      $this->New_label['prescription'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_prescription'] . "";
      $this->New_label['nursery_datetime'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_nursery_datetime'] . "";
      $this->New_label['evt_status'] = "" . $this->Ini->Nm_lang['lang_event_fld_idevent_status'] . "";
      $this->New_label['idhistory'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_idhistory'] . "";
      $this->New_label['history_datetime'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_history_datetime'] . "";
      $this->New_label['diagnosis'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_diagnosis'] . "";
      $this->New_label['tonursery'] = "" . $this->Ini->Nm_lang['lang_medical_history_fld_tonursery'] . "";
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_nursery_events']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_nursery_events']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_nursery_events']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->idhistory = (isset($Busca_temp['idhistory'])) ? $Busca_temp['idhistory'] : ""; 
          $tmp_pos = (is_string($this->idhistory)) ? strpos($this->idhistory, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->idhistory))
          {
              $this->idhistory = substr($this->idhistory, 0, $tmp_pos);
          }
          $this->history_datetime = (isset($Busca_temp['history_datetime'])) ? $Busca_temp['history_datetime'] : ""; 
          $tmp_pos = (is_string($this->history_datetime)) ? strpos($this->history_datetime, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->history_datetime))
          {
              $this->history_datetime = substr($this->history_datetime, 0, $tmp_pos);
          }
          $this->history_datetime_2 = (isset($Busca_temp['history_datetime_input_2'])) ? $Busca_temp['history_datetime_input_2'] : ""; 
          $this->patients_idpatient = (isset($Busca_temp['patients_idpatient'])) ? $Busca_temp['patients_idpatient'] : ""; 
          $tmp_pos = (is_string($this->patients_idpatient)) ? strpos($this->patients_idpatient, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->patients_idpatient))
          {
              $this->patients_idpatient = substr($this->patients_idpatient, 0, $tmp_pos);
          }
          $this->doctor_iddoctor = (isset($Busca_temp['doctor_iddoctor'])) ? $Busca_temp['doctor_iddoctor'] : ""; 
          $tmp_pos = (is_string($this->doctor_iddoctor)) ? strpos($this->doctor_iddoctor, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->doctor_iddoctor))
          {
              $this->doctor_iddoctor = substr($this->doctor_iddoctor, 0, $tmp_pos);
          }
      } 
      $this->nm_where_dinamico = "";
      $_SESSION['scriptcase']['grid_nursery_events']['contr_erro'] = 'on';
if (!isset($_SESSION['usr_group_id'])) {$_SESSION['usr_group_id'] = "";}
if (!isset($this->sc_temp_usr_group_id)) {$this->sc_temp_usr_group_id = (isset($_SESSION['usr_group_id'])) ? $_SESSION['usr_group_id'] : "";}
 if(!isset($this->sc_temp_usr_group_id)) {
	$this->sc_temp_usr_group_id = 0;
}

$today = date("Y-m-d"); 
$today_b = $today." 00:00:00";
$today_e = $today." 23:59:59";
$this->nm_where_dinamico = " AND history_datetime BETWEEN ".$this->Ini->sc_Sql_Protect($today_b, 'date')." AND ".$this->Ini->sc_Sql_Protect($today_e, 'date')." ";
if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_dinamico']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_dinamico'] != $this->nm_where_dinamico) {
    $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_dinamico'] = $this->nm_where_dinamico;
    unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['inicio']);
}

if (isset($this->sc_temp_usr_group_id)) {$_SESSION['usr_group_id'] = $this->sc_temp_usr_group_id;}
$_SESSION['scriptcase']['grid_nursery_events']['contr_erro'] = 'off'; 
      if  (!empty($this->nm_where_dinamico)) 
      {   
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_pesq'] .= $this->nm_where_dinamico;
      }   
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_name']))
      {
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_name'], ".");
          if ($Pos === false) {
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_name'] .= ".rtf";
          }
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_name'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_name']);
      }
      $this->arr_export = array('label' => array(), 'lines' => array());
      $this->arr_span   = array();

      $this->Texto_tag .= "<table>\r\n";
      $this->Texto_tag .= "<tr>\r\n";
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['field_order'] as $Cada_col)
      { 
          $SC_Label = (isset($this->New_label['edit_rec'])) ? $this->New_label['edit_rec'] : ""; 
          if ($Cada_col == "edit_rec" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['doctor_iddoctor'])) ? $this->New_label['doctor_iddoctor'] : ""; 
          if ($Cada_col == "doctor_iddoctor" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['patients_idpatient'])) ? $this->New_label['patients_idpatient'] : ""; 
          if ($Cada_col == "patients_idpatient" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['complaints'])) ? $this->New_label['complaints'] : ""; 
          if ($Cada_col == "complaints" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['prescription'])) ? $this->New_label['prescription'] : ""; 
          if ($Cada_col == "prescription" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['nursery_datetime'])) ? $this->New_label['nursery_datetime'] : ""; 
          if ($Cada_col == "nursery_datetime" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['evt_status'])) ? $this->New_label['evt_status'] : ""; 
          if ($Cada_col == "evt_status" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['idhistory'])) ? $this->New_label['idhistory'] : ""; 
          if ($Cada_col == "idhistory" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['history_datetime'])) ? $this->New_label['history_datetime'] : ""; 
          if ($Cada_col == "history_datetime" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['diagnosis'])) ? $this->New_label['diagnosis'] : ""; 
          if ($Cada_col == "diagnosis" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
      } 
      $this->Texto_tag .= "</tr>\r\n";
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $nmgp_select_count = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_sybase))
      { 
          $nmgp_select = "SELECT doctor_iddoctor, patients_idpatient, complaints, prescription, str_replace (convert(char(10),nursery_datetime,102), '.', '-') + ' ' + convert(char(8),nursery_datetime,20), idhistory, str_replace (convert(char(10),history_datetime,102), '.', '-') + ' ' + convert(char(8),history_datetime,20), diagnosis, event_idevent from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT doctor_iddoctor, patients_idpatient, complaints, prescription, nursery_datetime, idhistory, history_datetime, diagnosis, event_idevent from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
       $nmgp_select = "SELECT doctor_iddoctor, patients_idpatient, complaints, prescription, convert(char(23),nursery_datetime,121), idhistory, convert(char(23),history_datetime,121), diagnosis, event_idevent from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT doctor_iddoctor, patients_idpatient, complaints, prescription, nursery_datetime, idhistory, history_datetime, diagnosis, event_idevent from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT doctor_iddoctor, patients_idpatient, complaints, prescription, EXTEND(nursery_datetime, YEAR TO FRACTION), idhistory, EXTEND(history_datetime, YEAR TO FRACTION), diagnosis, event_idevent from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT doctor_iddoctor, patients_idpatient, complaints, prescription, nursery_datetime, idhistory, history_datetime, diagnosis, event_idevent from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_pesq'];
      $nmgp_select_count .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['where_pesq'];
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select_count;
      $rt = $this->Db->Execute($nmgp_select_count);
      if ($rt === false && !$rt->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }
      $this->count_ger = $rt->fields[0];
      $rt->Close();
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }
      $this->SC_seq_register = 0;
      $PB_tot = (isset($this->count_ger) && $this->count_ger > 0) ? "/" . $this->count_ger : "";
      while (!$rs->EOF)
      {
         $this->SC_seq_register++;
         if (!$this->Ini->sc_export_ajax) {
             $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
             $this->pb->setProgressbarMessage($Mens_bar . ": " . $this->SC_seq_register . $PB_tot);
             $this->pb->addSteps(1);
         }
         $this->Texto_tag .= "<tr>\r\n";
         $this->doctor_iddoctor = $rs->fields[0] ;  
         $this->doctor_iddoctor = (string)$this->doctor_iddoctor;
         $this->patients_idpatient = $rs->fields[1] ;  
         $this->patients_idpatient = (string)$this->patients_idpatient;
         $this->complaints = $rs->fields[2] ;  
         $this->prescription = $rs->fields[3] ;  
         $this->nursery_datetime = $rs->fields[4] ;  
         $this->idhistory = $rs->fields[5] ;  
         $this->idhistory = (string)$this->idhistory;
         $this->history_datetime = $rs->fields[6] ;  
         $this->diagnosis = $rs->fields[7] ;  
         $this->event_idevent = $rs->fields[8] ;  
         $this->event_idevent = (string)$this->event_idevent;
         //----- lookup - doctor_iddoctor
         $this->look_doctor_iddoctor = $this->doctor_iddoctor; 
         $this->Lookup->lookup_doctor_iddoctor($this->look_doctor_iddoctor, $this->doctor_iddoctor) ; 
         $this->look_doctor_iddoctor = ($this->look_doctor_iddoctor == "&nbsp;") ? "" : $this->look_doctor_iddoctor; 
         //----- lookup - patients_idpatient
         $this->look_patients_idpatient = $this->patients_idpatient; 
         $this->Lookup->lookup_patients_idpatient($this->look_patients_idpatient, $this->patients_idpatient) ; 
         $this->look_patients_idpatient = ($this->look_patients_idpatient == "&nbsp;") ? "" : $this->look_patients_idpatient; 
         $this->sc_proc_grid = true; 
         $_SESSION['scriptcase']['grid_nursery_events']['contr_erro'] = 'on';
if (!isset($_SESSION['lang'])) {$_SESSION['lang'] = "";}
if (!isset($this->sc_temp_lang)) {$this->sc_temp_lang = (isset($_SESSION['lang'])) ? $_SESSION['lang'] : "";}
 $check_sql = "SELECT event_status.event_status_descr".$this->sc_temp_lang." 
FROM event INNER JOIN event_status ON event.idevent_status = event_status.idevent_status
WHERE event.idevent = ".$this->event_idevent ;
 
      $nm_select = $check_sql; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_select; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->rs = array();
      if ($SCrx = $this->Db->Execute($nm_select)) 
      { 
          $SCy = 0; 
          $nm_count = $SCrx->FieldCount();
          while (!$SCrx->EOF)
          { 
                 for ($SCx = 0; $SCx < $nm_count; $SCx++)
                 { 
                        $this->rs[$SCy] [$SCx] = $SCrx->fields[$SCx];
                 }
                 $SCy++; 
                 $SCrx->MoveNext();
          } 
          $SCrx->Close();
      } 
      elseif (isset($GLOBALS["NM_ERRO_IBASE"]) && $GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->rs = false;
          $this->rs_erro = $this->Db->ErrorMsg();
      } 


if (isset($this->rs[0][0]))     
{
    $this->evt_status  = $this->rs[0][0];
}
else     
{
	$this->evt_status  = '';
}
if (isset($this->sc_temp_lang)) {$_SESSION['lang'] = $this->sc_temp_lang;}
$_SESSION['scriptcase']['grid_nursery_events']['contr_erro'] = 'off'; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         $this->Texto_tag .= "</tr>\r\n";
         $rs->MoveNext();
      }
      $this->Texto_tag .= "</table>\r\n";
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['export_sel_columns']['field_order']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['field_order'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['export_sel_columns']['field_order'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['export_sel_columns']['field_order']);
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['export_sel_columns']['usr_cmp_sel']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['usr_cmp_sel'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['export_sel_columns']['usr_cmp_sel'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['export_sel_columns']['usr_cmp_sel']);
      }
      $rs->Close();
   }
   //----- edit_rec
   function NM_export_edit_rec()
   {
         $this->edit_rec = NM_charset_to_utf8($this->edit_rec);
         $this->edit_rec = str_replace('<', '&lt;', $this->edit_rec);
         $this->edit_rec = str_replace('>', '&gt;', $this->edit_rec);
         $this->Texto_tag .= "<td>" . $this->edit_rec . "</td>\r\n";
   }
   //----- doctor_iddoctor
   function NM_export_doctor_iddoctor()
   {
         nmgp_Form_Num_Val($this->look_doctor_iddoctor, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $this->look_doctor_iddoctor = NM_charset_to_utf8($this->look_doctor_iddoctor);
         $this->look_doctor_iddoctor = str_replace('<', '&lt;', $this->look_doctor_iddoctor);
         $this->look_doctor_iddoctor = str_replace('>', '&gt;', $this->look_doctor_iddoctor);
         $this->Texto_tag .= "<td>" . $this->look_doctor_iddoctor . "</td>\r\n";
   }
   //----- patients_idpatient
   function NM_export_patients_idpatient()
   {
         nmgp_Form_Num_Val($this->look_patients_idpatient, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $this->look_patients_idpatient = NM_charset_to_utf8($this->look_patients_idpatient);
         $this->look_patients_idpatient = str_replace('<', '&lt;', $this->look_patients_idpatient);
         $this->look_patients_idpatient = str_replace('>', '&gt;', $this->look_patients_idpatient);
         $this->Texto_tag .= "<td>" . $this->look_patients_idpatient . "</td>\r\n";
   }
   //----- complaints
   function NM_export_complaints()
   {
         $this->complaints = html_entity_decode($this->complaints, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->complaints = strip_tags($this->complaints);
         $this->complaints = NM_charset_to_utf8($this->complaints);
         $this->complaints = str_replace('<', '&lt;', $this->complaints);
         $this->complaints = str_replace('>', '&gt;', $this->complaints);
         $this->Texto_tag .= "<td>" . $this->complaints . "</td>\r\n";
   }
   //----- prescription
   function NM_export_prescription()
   {
         $this->prescription = html_entity_decode($this->prescription, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->prescription = strip_tags($this->prescription);
         $this->prescription = NM_charset_to_utf8($this->prescription);
         $this->prescription = str_replace('<', '&lt;', $this->prescription);
         $this->prescription = str_replace('>', '&gt;', $this->prescription);
         $this->Texto_tag .= "<td>" . $this->prescription . "</td>\r\n";
   }
   //----- nursery_datetime
   function NM_export_nursery_datetime()
   {
             if (substr($this->nursery_datetime, 10, 1) == "-") 
             { 
                 $this->nursery_datetime = substr($this->nursery_datetime, 0, 10) . " " . substr($this->nursery_datetime, 11);
             } 
             if (substr($this->nursery_datetime, 13, 1) == ".") 
             { 
                $this->nursery_datetime = substr($this->nursery_datetime, 0, 13) . ":" . substr($this->nursery_datetime, 14, 2) . ":" . substr($this->nursery_datetime, 17);
             } 
             $conteudo_x =  $this->nursery_datetime;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD HH:II:SS");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->nursery_datetime, "YYYY-MM-DD HH:II:SS  ");
                 $this->nursery_datetime = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DH", "ddmmaaaa;hhiiss"));
             } 
         $this->nursery_datetime = NM_charset_to_utf8($this->nursery_datetime);
         $this->nursery_datetime = str_replace('<', '&lt;', $this->nursery_datetime);
         $this->nursery_datetime = str_replace('>', '&gt;', $this->nursery_datetime);
         $this->Texto_tag .= "<td>" . $this->nursery_datetime . "</td>\r\n";
   }
   //----- evt_status
   function NM_export_evt_status()
   {
         $this->evt_status = html_entity_decode($this->evt_status, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->evt_status = strip_tags($this->evt_status);
         $this->evt_status = NM_charset_to_utf8($this->evt_status);
         $this->evt_status = str_replace('<', '&lt;', $this->evt_status);
         $this->evt_status = str_replace('>', '&gt;', $this->evt_status);
         $this->Texto_tag .= "<td>" . $this->evt_status . "</td>\r\n";
   }
   //----- idhistory
   function NM_export_idhistory()
   {
             nmgp_Form_Num_Val($this->idhistory, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $this->idhistory = NM_charset_to_utf8($this->idhistory);
         $this->idhistory = str_replace('<', '&lt;', $this->idhistory);
         $this->idhistory = str_replace('>', '&gt;', $this->idhistory);
         $this->Texto_tag .= "<td>" . $this->idhistory . "</td>\r\n";
   }
   //----- history_datetime
   function NM_export_history_datetime()
   {
             if (substr($this->history_datetime, 10, 1) == "-") 
             { 
                 $this->history_datetime = substr($this->history_datetime, 0, 10) . " " . substr($this->history_datetime, 11);
             } 
             if (substr($this->history_datetime, 13, 1) == ".") 
             { 
                $this->history_datetime = substr($this->history_datetime, 0, 13) . ":" . substr($this->history_datetime, 14, 2) . ":" . substr($this->history_datetime, 17);
             } 
             $conteudo_x =  $this->history_datetime;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD HH:II:SS");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->history_datetime, "YYYY-MM-DD HH:II:SS  ");
                 $this->history_datetime = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DH", "ddmmaaaa;hhiiss"));
             } 
         $this->history_datetime = NM_charset_to_utf8($this->history_datetime);
         $this->history_datetime = str_replace('<', '&lt;', $this->history_datetime);
         $this->history_datetime = str_replace('>', '&gt;', $this->history_datetime);
         $this->Texto_tag .= "<td>" . $this->history_datetime . "</td>\r\n";
   }
   //----- diagnosis
   function NM_export_diagnosis()
   {
         $this->diagnosis = html_entity_decode($this->diagnosis, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->diagnosis = strip_tags($this->diagnosis);
         $this->diagnosis = NM_charset_to_utf8($this->diagnosis);
         $this->diagnosis = str_replace('<', '&lt;', $this->diagnosis);
         $this->diagnosis = str_replace('>', '&gt;', $this->diagnosis);
         $this->Texto_tag .= "<td>" . $this->diagnosis . "</td>\r\n";
   }

   //----- 
   function grava_arquivo_rtf()
   {
      global $nm_lang, $doc_wrap;
      $this->Rtf_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $rtf_f       = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo, "w");
      require_once($this->Ini->path_third      . "/rtf_new/document_generator/cl_xml2driver.php"); 
      $text_ok  =  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
      $text_ok .=  "<DOC config_file=\"" . $this->Ini->path_third . "/rtf_new/doc_config.inc\" >\r\n"; 
      $text_ok .=  $this->Texto_tag; 
      $text_ok .=  "</DOC>\r\n"; 
      $xml = new nDOCGEN($text_ok,"RTF"); 
      fwrite($rtf_f, $xml->get_result_file());
      fclose($rtf_f);
   }

   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT") {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT") {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "SC_FORMAT_REGION") {
           $this->nm_data->SetaData($dt_in, strtoupper($form_in));
           $prep_out  = (strpos(strtolower($form_in), "dd") !== false) ? "dd" : "";
           $prep_out .= (strpos(strtolower($form_in), "mm") !== false) ? "mm" : "";
           $prep_out .= (strpos(strtolower($form_in), "aa") !== false) ? "aaaa" : "";
           $prep_out .= (strpos(strtolower($form_in), "yy") !== false) ? "aaaa" : "";
           return $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", $prep_out));
       }
       else {
           nm_conv_form_data($dt_out, $form_in, $form_out);
           return $dt_out;
       }
   }
   function progress_bar_end()
   {
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events'][$path_doc_md5][1] = $this->Tit_doc;
      $Mens_bar = $this->Ini->Nm_lang['lang_othr_file_msge'];
      if ($_SESSION['scriptcase']['charset'] != "UTF-8") {
          $Mens_bar = sc_convert_encoding($Mens_bar, "UTF-8", $_SESSION['scriptcase']['charset']);
      }
      $this->pb->setProgressbarMessage($Mens_bar);
      $this->pb->setDownloadLink($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $this->pb->setDownloadMd5($path_doc_md5);
      $this->pb->completed();
   }
   //---- 
   function monta_html()
   {
      global $nm_url_saida, $nm_lang;
      include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_nursery_events'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_nursery_events'] ?> :: RTF</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
<?php
if ($_SESSION['scriptcase']['proc_mobile'])
{
?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<?php
}
?>
  <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
  <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
  <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
  <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
  <META http-equiv="Pragma" content="no-cache"/>
 <link rel="shortcut icon" href="../_lib/img/scriptcase__NM__ico__NM__favicon.ico">
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
 <?php
 if(isset($this->Ini->str_google_fonts) && !empty($this->Ini->str_google_fonts))
 {
 ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->Ini->str_google_fonts ?>" />
 <?php
 }
 ?>
  <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_css ?>" /> 
</HEAD>
<BODY class="scExportPage">
<?php echo $this->Ini->Ajax_result_set ?>
<table style="border-collapse: collapse; border-width: 0; height: 100%; width: 100%"><tr><td style="padding: 0; text-align: center; vertical-align: middle">
 <table class="scExportTable" align="center">
  <tr>
   <td class="scExportTitle" style="height: 25px">RTF</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
     <?php echo nmButtonOutput($this->arr_buttons, "bexportview", "document.Fview.submit()", "document.Fview.submit()", "idBtnView", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->Arquivo ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grid_nursery_events_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_nursery_events"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<FORM name="F0" method=post action="./"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="volta_grid"> 
</FORM> 
</BODY>
</HTML>
<?php
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $str_highlight_ini = "";
      $str_highlight_fim = "";
      if(substr($nm_campo, 0, 23) == '<div class="highlight">' && substr($nm_campo, -6) == '</div>')
      {
           $str_highlight_ini = substr($nm_campo, 0, 23);
           $str_highlight_fim = substr($nm_campo, -6);

           $trab_campo = substr($nm_campo, 23, -6);
           $tam_campo  = strlen($trab_campo);
      }      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($tam_campo >= $cont2)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $str_highlight_ini . $trab_saida . $str_highlight_ini;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $str_highlight_ini . $trab_saida . $str_highlight_ini;
   } 
}

?>
