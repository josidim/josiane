<?php
$this->load->view('template/cabecalho');  

//echo validation_errors();
echo form_open("cadastro/autenticar");


?>
            <td width="553" align="left" valign="top" bgcolor="#FFFFFF">
			
            <?php	
            if($this->session->flashdata('editarok')):
echo'<p>'.$this->session->flashdata('editarok').'</p>';
endif
?>
            <h1 align="center" ><font color="#00009C">Autenticar Certificado<br> </font>   </h1>

<table width="472" border="0" id="logon">
 
   <tr>
	 <td width="101" >Digite a chave:</td>
    <td width="361" >
		
        <input name="chave" type="text" value="<?php echo set_value('chave'); ?>"  id="chave" />
        <br><?php echo form_error('chave'); ?><br>
    </td>
    
  </tr>
   <td>Digite a  data de  emisão:</td>
    <td>
		        <input name="data" type="date" value="<?php echo set_value('data'); ?>"  id="data" />
        <br><?php echo form_error('data'); ?><br>
    </td>

      
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;  </td>
  </tr>
  <tr>
    <td>
           <td align="left">  <?php echo anchor('login','<input name="inicio" type="button" class="input_bt" id="inicio" value="&nbsp;In&iacute;cio&nbsp;" />');?> </td>

    </td>
    <td align="right"><input name="Enviar" type="submit" class="input_bt" id="Enviar" value="Enviar" /></td>
  </tr>


				
				</td>


           
          <?php
         echo form_close();
$this->load->view('template/rodape');
?>
</table>
