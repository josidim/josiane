<?php
$this->load->view('template/cabecalho');  
$this->load->view('template/menucurso'); 
$id = $this->uri->segment(3);
if ($id==NULL) redirect('curso/index'); 
$query = $this ->curso_m->atualizar($id)->row();


echo form_open("curso/editar/$id");

//echo form_close();
?>
            <td width="553" align="left" valign="top" bgcolor="#FFFFFF">
			
            
            <h1 align="center" >Alterar curso  </h1>

<table class="table table-striped" width="472" border="0" id="logon">
  <tr>
	  
    <td width="101">Nome:</td>
    <td width="361">
		<?php echo form_error('nome'); ?>
        <input name="nome" type="text" value="<?php echo set_value('nome',$query->nome); ?>" class="input_text" id="nome" />
        
    </td>
  </tr>
  <tr>
    <td>M&oacute;dulo:</td>
    <td>
		<?php echo form_error('modulo'); ?>
      <input name="modulo" type="text" value="<?php echo set_value('modulo',$query->modulo); ?>" class="input_text" id="modulo" />
     </td>
  </tr>
  <tr>
    <td>Descri&ccedil;&atilde;o:</td>
    <td>
		<?php echo form_error('descricao'); ?>
        <input type="text"  name="descricao" value="<?php echo set_value('descricao',$query->descricao); ?>" class="input_text" cols="45" rows="5" id="descricao">
      <br />
      
  </tr>
  <tr>
    <td>Carga hor&aacute;ria:</td>
    <td>
		<?php echo form_error('cargahr'); ?>
    <input type="text" name="cargahr" value="<?php echo set_value('cargahr',$query->cargahr); ?>"  id="cargahr" size="5"/>
    <br />
   <span>*Digite somente n&uacute;meros.</span></td>
  </tr>
  <tr>
    <td>&Aacute;rea tem&aacute;tica:</td>
    <td>
		<?php echo form_error('areatema'); ?>
      <input name="areatema" type="text" value="<?php echo set_value('areatema',$query->areatema); ?>" class="input_text"  id="areatema" />
      </td>
  </tr>
  <tr>
    <td>Compet&ecirc;ncia:</td>
    <td>
		<?php echo form_error('competencia'); ?>
    <input type="text"  name="competencia" value="<?php echo set_value('competencia',$query->competencia); ?>"  class="input_text" id="competencia" cols="145" rows="145"><br />
     </td>
  </tr>
  <tr>
    <td>Estado:</td>
    <td>
		<?php echo form_error('estado'); ?>
    <input type="text" name="estado" id="estado" value="<?php echo set_value('estado',$query->estado); ?>">
       
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      
    </td>
    <td align="right"><input name="proximo" type="submit" class="input_bt" id="proximo" value="Alterar" /></td>
  </tr>
</table>

				
				</td>

           
          <?php
          echo form_hidden('$idcurso',$query->codcurso);
         echo form_close();
$this->load->view('template/rodape');
?>
