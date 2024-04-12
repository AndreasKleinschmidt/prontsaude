<?php
class grid_medical_history_lookup
{
//  
   function lookup_doctor_iddoctor(&$conteudo , $doctor_iddoctor) 
   {   
      static $save_conteudo = "" ; 
      static $save_conteudo1 = "" ; 
      $tst_cache = $doctor_iddoctor; 
      if ($tst_cache === $save_conteudo && $conteudo != "&nbsp;") 
      { 
          $conteudo = $save_conteudo1 ; 
          return ; 
      } 
      $save_conteudo = $tst_cache ; 
      if (trim($doctor_iddoctor) === "" || trim($doctor_iddoctor) == "&nbsp;")
      { 
          $conteudo = "&nbsp;";
          $save_conteudo  = ""; 
          $save_conteudo1 = ""; 
          return ; 
      } 
      $nm_comando = "select namedoctor from doctors where iddoctor = $doctor_iddoctor order by namedoctor" ; 
      $conteudo = "" ; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rx = $this->Db->Execute($nm_comando)) 
      { 
          if (isset($rx->fields[0]))  
          { 
              $conteudo = $rx->fields[0]; 
          } 
          $save_conteudo1 = $conteudo ; 
          $rx->Close(); 
      } 
      elseif ($GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
          exit; 
      } 
      if ($conteudo === "") 
      { 
          $conteudo = "&nbsp;";
          $save_conteudo1 = $conteudo ; 
      } 
   }  
//  
   function lookup_tonursery(&$tonursery) 
   {
      $conteudo = "" ; 
      if ($tonursery == "Y")
      { 
          $conteudo = "" . $this->Ini->Nm_lang['lang_opt_yes'] . "";
      } 
      if ($tonursery == "N")
      { 
          $conteudo = "" . $this->Ini->Nm_lang['lang_opt_no'] . "";
      } 
      if (!empty($conteudo)) 
      { 
          $tonursery = $conteudo; 
      } 
   }  
}
?>
