<?php

class grid_events_patiente_rtf
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
                   nm_limpa_str_grid_events_patiente($cadapar[1]);
                   nm_protect_num_grid_events_patiente($cadapar[0], $cadapar[1]);
                   if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                   $Tmp_par   = $cadapar[0];
                   $$Tmp_par = $cadapar[1];
                   if ($Tmp_par == "nmgp_opcao")
                   {
                       $_SESSION['sc_session'][$script_case_init]['grid_events_patiente']['opcao'] = $cadapar[1];
                   }
               }
          }
      }
      if (isset($var_patiente)) 
      {
          $_SESSION['var_patiente'] = $var_patiente;
          nm_limpa_str_grid_events_patiente($_SESSION["var_patiente"]);
      }
      if (isset($var_doctor)) 
      {
          $_SESSION['var_doctor'] = $var_doctor;
          nm_limpa_str_grid_events_patiente($_SESSION["var_doctor"]);
      }
      if (isset($usr_group_id)) 
      {
          $_SESSION['usr_group_id'] = $usr_group_id;
          nm_limpa_str_grid_events_patiente($_SESSION["usr_group_id"]);
      }
      if (isset($usr_login) && isset($NM_contr_var_session) && $NM_contr_var_session == "Yes") 
      {
          $_SESSION['usr_login'] = $usr_login;
          nm_limpa_str_grid_events_patiente($_SESSION["usr_login"]);
      }
      if (isset($lang)) 
      {
          $_SESSION['lang'] = $lang;
          nm_limpa_str_grid_events_patiente($_SESSION["lang"]);
      }
      if (isset($var_patiente_name)) 
      {
          $_SESSION['var_patiente_name'] = $var_patiente_name;
          nm_limpa_str_grid_events_patiente($_SESSION["var_patiente_name"]);
      }
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      require_once($this->Ini->path_aplicacao . "grid_events_patiente_total.class.php"); 
      $this->Tot      = new grid_events_patiente_total($this->Ini->sc_page);
      $this->prep_modulos("Tot");
      $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['SC_Ind_Groupby'];
      if (method_exists($this->Tot,$Gb_geral))
      {
          $this->Tot->$Gb_geral();
          $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['tot_geral'][1];
      }
      if (!$this->Ini->sc_export_ajax) {
          require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
          $this->pb = new scProgressBar();
          $this->pb->setRoot($this->Ini->root);
          $this->pb->setDir($_SESSION['scriptcase']['grid_events_patiente']['glo_nm_path_imag_temp'] . "/");
          $this->pb->setProgressbarMd5($_GET['pbmd5']);
          $this->pb->initialize();
          $this->pb->setReturnUrl("./");
          $this->pb->setReturnOption('volta_grid');
          $this->pb->setTotalSteps($this->count_ger);
      }
      $this->Arquivo    = "sc_rtf";
      $this->Arquivo   .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->Arquivo   .= "_grid_events_patiente";
      $this->Arquivo   .= ".rtf";
      $this->Tit_doc    = "grid_events_patiente.rtf";
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
      $this->New_label['idevent_status'] = "" . $this->Ini->Nm_lang['lang_event_fld_idevent_status'] . "";
      $this->New_label['start_date'] = "" . $this->Ini->Nm_lang['lang_event_fld_start_date'] . "";
      $this->New_label['start_time'] = "" . $this->Ini->Nm_lang['lang_event_fld_start_time'] . "";
      $this->New_label['doctor_iddoctor'] = "" . $this->Ini->Nm_lang['lang_event_fld_doctor_iddoctor'] . "";
      $this->New_label['categ'] = "" . $this->Ini->Nm_lang['lang_event_fld_categ'] . "";
      $this->New_label['idevent'] = "" . $this->Ini->Nm_lang['lang_event_fld_idevent'] . "";
      $this->New_label['title'] = "" . $this->Ini->Nm_lang['lang_event_fld_title'] . "";
      $this->New_label['descr'] = "" . $this->Ini->Nm_lang['lang_event_fld_descr'] . "";
      $this->New_label['end_date'] = "" . $this->Ini->Nm_lang['lang_event_fld_end_date'] . "";
      $this->New_label['end_time'] = "" . $this->Ini->Nm_lang['lang_event_fld_end_time'] . "";
      $this->New_label['recurr'] = "" . $this->Ini->Nm_lang['lang_event_fld_recurr'] . "";
      $this->New_label['period'] = "" . $this->Ini->Nm_lang['lang_event_fld_period'] . "";
      $this->New_label['id_api'] = "" . $this->Ini->Nm_lang['lang_event_fld_id_api'] . "";
      $this->New_label['id_event_google'] = "" . $this->Ini->Nm_lang['lang_event_fld_id_event_google'] . "";
      $this->New_label['recur_info'] = "" . $this->Ini->Nm_lang['lang_event_fld_recur_info'] . "";
      $this->New_label['event_color'] = "" . $this->Ini->Nm_lang['lang_event_fld_event_color'] . "";
      $this->New_label['creator'] = "" . $this->Ini->Nm_lang['lang_event_fld_creator'] . "";
      $this->New_label['reminder'] = "" . $this->Ini->Nm_lang['lang_event_fld_reminder'] . "";
      $this->New_label['patients_idpatient'] = "" . $this->Ini->Nm_lang['lang_event_fld_patients_idpatient'] . "";
      $this->New_label['event_period'] = "" . $this->Ini->Nm_lang['lang_event_fld_event_period'] . "";
      $this->New_label['idevent_priority'] = "" . $this->Ini->Nm_lang['lang_event_fld_idevent_priority'] . "";
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_events_patiente']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_events_patiente']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_events_patiente']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->idevent = (isset($Busca_temp['idevent'])) ? $Busca_temp['idevent'] : ""; 
          $tmp_pos = (is_string($this->idevent)) ? strpos($this->idevent, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->idevent))
          {
              $this->idevent = substr($this->idevent, 0, $tmp_pos);
          }
          $this->title = (isset($Busca_temp['title'])) ? $Busca_temp['title'] : ""; 
          $tmp_pos = (is_string($this->title)) ? strpos($this->title, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->title))
          {
              $this->title = substr($this->title, 0, $tmp_pos);
          }
          $this->descr = (isset($Busca_temp['descr'])) ? $Busca_temp['descr'] : ""; 
          $tmp_pos = (is_string($this->descr)) ? strpos($this->descr, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->descr))
          {
              $this->descr = substr($this->descr, 0, $tmp_pos);
          }
          $this->start_date = (isset($Busca_temp['start_date'])) ? $Busca_temp['start_date'] : ""; 
          $tmp_pos = (is_string($this->start_date)) ? strpos($this->start_date, "##@@") : false;
          if ($tmp_pos !== false && !is_array($this->start_date))
          {
              $this->start_date = substr($this->start_date, 0, $tmp_pos);
          }
          $this->start_date_2 = (isset($Busca_temp['start_date_input_2'])) ? $Busca_temp['start_date_input_2'] : ""; 
      } 
      $this->nm_where_dinamico = "";
      $_SESSION['scriptcase']['grid_events_patiente']['contr_erro'] = 'on';
if (!isset($_SESSION['usr_group_id'])) {$_SESSION['usr_group_id'] = "";}
if (!isset($this->sc_temp_usr_group_id)) {$this->sc_temp_usr_group_id = (isset($_SESSION['usr_group_id'])) ? $_SESSION['usr_group_id'] : "";}
 $today = date("Y-m-d");
$this->nm_where_dinamico = " AND start_date <= ".$this->Ini->sc_Sql_Protect($today, "date");

if ( $this->sc_temp_usr_group_id == 3 )
{
	$this->NM_cmp_hidden["bt_add"] = 'off';if (!isset($this->NM_ajax_event) || !$this->NM_ajax_event) {$_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['php_cmp_sel']["bt_add"] = 'off'; }
}
if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_dinamico']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_dinamico'] != $this->nm_where_dinamico) {
    $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_dinamico'] = $this->nm_where_dinamico;
    unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['inicio']);
}
if (isset($this->sc_temp_usr_group_id)) {$_SESSION['usr_group_id'] = $this->sc_temp_usr_group_id;}
$_SESSION['scriptcase']['grid_events_patiente']['contr_erro'] = 'off'; 
      if  (!empty($this->nm_where_dinamico)) 
      {   
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_pesq'] .= $this->nm_where_dinamico;
      }   
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_name']))
      {
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_name'], ".");
          if ($Pos === false) {
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_name'] .= ".rtf";
          }
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_name'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_name']);
      }
      $this->arr_export = array('label' => array(), 'lines' => array());
      $this->arr_span   = array();

      $this->Texto_tag .= "<table>\r\n";
      $this->Texto_tag .= "<tr>\r\n";
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['field_order'] as $Cada_col)
      { 
          $SC_Label = (isset($this->New_label['idevent_status'])) ? $this->New_label['idevent_status'] : ""; 
          if ($Cada_col == "idevent_status" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['start_date'])) ? $this->New_label['start_date'] : ""; 
          if ($Cada_col == "start_date" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['start_time'])) ? $this->New_label['start_time'] : ""; 
          if ($Cada_col == "start_time" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
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
          $SC_Label = (isset($this->New_label['categ'])) ? $this->New_label['categ'] : ""; 
          if ($Cada_col == "categ" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['bt_add'])) ? $this->New_label['bt_add'] : ""; 
          if ($Cada_col == "bt_add" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['idevent'])) ? $this->New_label['idevent'] : ""; 
          if ($Cada_col == "idevent" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['title'])) ? $this->New_label['title'] : ""; 
          if ($Cada_col == "title" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['descr'])) ? $this->New_label['descr'] : ""; 
          if ($Cada_col == "descr" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $SC_Label = NM_charset_to_utf8($SC_Label);
              $SC_Label = str_replace('<', '&lt;', $SC_Label);
              $SC_Label = str_replace('>', '&gt;', $SC_Label);
              $this->Texto_tag .= "<td>" . $SC_Label . "</td>\r\n";
          }
          $SC_Label = (isset($this->New_label['end_date'])) ? $this->New_label['end_date'] : ""; 
          if ($Cada_col == "end_date" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
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
          $nmgp_select = "SELECT idevent_status, str_replace (convert(char(10),start_date,102), '.', '-') + ' ' + convert(char(8),start_date,20), str_replace (convert(char(10),start_time,102), '.', '-') + ' ' + convert(char(8),start_time,20), doctor_iddoctor, categ, idevent, title, descr, str_replace (convert(char(10),end_date,102), '.', '-') + ' ' + convert(char(8),end_date,20), patients_idpatient from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT idevent_status, start_date, start_time, doctor_iddoctor, categ, idevent, title, descr, end_date, patients_idpatient from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mssql))
      { 
       $nmgp_select = "SELECT idevent_status, convert(char(23),start_date,121), convert(char(23),start_time,121), doctor_iddoctor, categ, idevent, title, descr, convert(char(23),end_date,121), patients_idpatient from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_oracle))
      { 
          $nmgp_select = "SELECT idevent_status, start_date, start_time, doctor_iddoctor, categ, idevent, title, descr, end_date, patients_idpatient from " . $this->Ini->nm_tabela; 
      } 
      elseif (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_informix))
      { 
          $nmgp_select = "SELECT idevent_status, EXTEND(start_date, YEAR TO DAY), start_time, doctor_iddoctor, categ, idevent, title, descr, EXTEND(end_date, YEAR TO DAY), patients_idpatient from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT idevent_status, start_date, start_time, doctor_iddoctor, categ, idevent, title, descr, end_date, patients_idpatient from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_pesq'];
      $nmgp_select_count .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['where_pesq'];
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['order_grid'];
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
         $this->idevent_status = $rs->fields[0] ;  
         $this->idevent_status = (string)$this->idevent_status;
         $this->start_date = $rs->fields[1] ;  
         $this->start_time = $rs->fields[2] ;  
         $this->doctor_iddoctor = $rs->fields[3] ;  
         $this->doctor_iddoctor = (string)$this->doctor_iddoctor;
         $this->categ = $rs->fields[4] ;  
         $this->categ = (string)$this->categ;
         $this->idevent = $rs->fields[5] ;  
         $this->idevent = (string)$this->idevent;
         $this->title = $rs->fields[6] ;  
         $this->descr = $rs->fields[7] ;  
         $this->end_date = $rs->fields[8] ;  
         $this->patients_idpatient = $rs->fields[9] ;  
         $this->patients_idpatient = (string)$this->patients_idpatient;
         $this->Orig_idevent_status = $this->idevent_status;
         $this->Orig_start_date = $this->start_date;
         $this->Orig_start_time = $this->start_time;
         $this->Orig_doctor_iddoctor = $this->doctor_iddoctor;
         $this->Orig_categ = $this->categ;
         $this->Orig_idevent = $this->idevent;
         $this->Orig_title = $this->title;
         $this->Orig_descr = $this->descr;
         $this->Orig_end_date = $this->end_date;
         $this->Orig_patients_idpatient = $this->patients_idpatient;
         //----- lookup - idevent_status
         $this->look_idevent_status = $this->idevent_status; 
         $this->Lookup->lookup_idevent_status($this->look_idevent_status, $this->idevent_status, $_SESSION['lang']) ; 
         $this->look_idevent_status = ($this->look_idevent_status == "&nbsp;") ? "" : $this->look_idevent_status; 
         //----- lookup - doctor_iddoctor
         $this->look_doctor_iddoctor = $this->doctor_iddoctor; 
         $this->Lookup->lookup_doctor_iddoctor($this->look_doctor_iddoctor, $this->doctor_iddoctor) ; 
         $this->look_doctor_iddoctor = ($this->look_doctor_iddoctor == "&nbsp;") ? "" : $this->look_doctor_iddoctor; 
         //----- lookup - categ
         $this->look_categ = $this->categ; 
         $this->Lookup->lookup_categ($this->look_categ, $this->categ, $_SESSION['lang']) ; 
         $this->look_categ = ($this->look_categ == "&nbsp;") ? "" : $this->look_categ; 
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['field_order'] as $Cada_col)
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
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['export_sel_columns']['field_order']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['field_order'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['export_sel_columns']['field_order'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['export_sel_columns']['field_order']);
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['export_sel_columns']['usr_cmp_sel']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['usr_cmp_sel'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['export_sel_columns']['usr_cmp_sel'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['export_sel_columns']['usr_cmp_sel']);
      }
      $rs->Close();
   }
   //----- idevent_status
   function NM_export_idevent_status()
   {
         nmgp_Form_Num_Val($this->look_idevent_status, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $this->look_idevent_status = NM_charset_to_utf8($this->look_idevent_status);
         $this->look_idevent_status = str_replace('<', '&lt;', $this->look_idevent_status);
         $this->look_idevent_status = str_replace('>', '&gt;', $this->look_idevent_status);
         $this->Texto_tag .= "<td>" . $this->look_idevent_status . "</td>\r\n";
   }
   //----- start_date
   function NM_export_start_date()
   {
             $conteudo_x =  $this->start_date;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->start_date, "YYYY-MM-DD  ");
                 $this->start_date = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         $this->start_date = NM_charset_to_utf8($this->start_date);
         $this->start_date = str_replace('<', '&lt;', $this->start_date);
         $this->start_date = str_replace('>', '&gt;', $this->start_date);
         $this->Texto_tag .= "<td>" . $this->start_date . "</td>\r\n";
   }
   //----- start_time
   function NM_export_start_time()
   {
             $conteudo_x =  $this->start_time;
             nm_conv_limpa_dado($conteudo_x, "HH:II:SS");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->start_time, "HH:II:SS  ");
                 $this->start_time = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("HH", "hhiiss"));
             } 
         $this->start_time = NM_charset_to_utf8($this->start_time);
         $this->start_time = str_replace('<', '&lt;', $this->start_time);
         $this->start_time = str_replace('>', '&gt;', $this->start_time);
         $this->Texto_tag .= "<td>" . $this->start_time . "</td>\r\n";
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
   //----- categ
   function NM_export_categ()
   {
         nmgp_Form_Num_Val($this->look_categ, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $this->look_categ = NM_charset_to_utf8($this->look_categ);
         $this->look_categ = str_replace('<', '&lt;', $this->look_categ);
         $this->look_categ = str_replace('>', '&gt;', $this->look_categ);
         $this->Texto_tag .= "<td>" . $this->look_categ . "</td>\r\n";
   }
   //----- bt_add
   function NM_export_bt_add()
   {
         $this->bt_add = NM_charset_to_utf8($this->bt_add);
         $this->bt_add = str_replace('<', '&lt;', $this->bt_add);
         $this->bt_add = str_replace('>', '&gt;', $this->bt_add);
         $this->Texto_tag .= "<td>" . $this->bt_add . "</td>\r\n";
   }
   //----- idevent
   function NM_export_idevent()
   {
             nmgp_Form_Num_Val($this->idevent, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         $this->idevent = NM_charset_to_utf8($this->idevent);
         $this->idevent = str_replace('<', '&lt;', $this->idevent);
         $this->idevent = str_replace('>', '&gt;', $this->idevent);
         $this->Texto_tag .= "<td>" . $this->idevent . "</td>\r\n";
   }
   //----- title
   function NM_export_title()
   {
         $this->title = html_entity_decode($this->title, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->title = strip_tags($this->title);
         $this->title = NM_charset_to_utf8($this->title);
         $this->title = str_replace('<', '&lt;', $this->title);
         $this->title = str_replace('>', '&gt;', $this->title);
         $this->Texto_tag .= "<td>" . $this->title . "</td>\r\n";
   }
   //----- descr
   function NM_export_descr()
   {
         $this->descr = html_entity_decode($this->descr, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->descr = strip_tags($this->descr);
         $this->descr = NM_charset_to_utf8($this->descr);
         $this->descr = str_replace('<', '&lt;', $this->descr);
         $this->descr = str_replace('>', '&gt;', $this->descr);
         $this->Texto_tag .= "<td>" . $this->descr . "</td>\r\n";
   }
   //----- end_date
   function NM_export_end_date()
   {
             $conteudo_x =  $this->end_date;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->end_date, "YYYY-MM-DD  ");
                 $this->end_date = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         $this->end_date = NM_charset_to_utf8($this->end_date);
         $this->end_date = str_replace('<', '&lt;', $this->end_date);
         $this->end_date = str_replace('>', '&gt;', $this->end_date);
         $this->Texto_tag .= "<td>" . $this->end_date . "</td>\r\n";
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
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente'][$path_doc_md5][1] = $this->Tit_doc;
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
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente']['rtf_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_events_patiente'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_titl'] ?> - event :: RTF</TITLE>
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
<form name="Fdown" method="get" action="grid_events_patiente_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_events_patiente"> 
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
