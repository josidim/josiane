<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscricao extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct() {
        parent::__construct();
 $this->load->model('Inscricao_m','inscricao_m');
   $this->load->model('Admin_m','admin_m',TRUE);
 $this->admin_m->logged();
   
 
}
 
	

	public function index()
	
	{
	

Redirect('inscricao/listar');


	}
	
	
	public function cadastrar()
	
	{
	$this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');
	$this -> form_validation ->set_rules('datains','DATA','trim|required');
	$this -> form_validation ->set_rules('situacao','Estado','trim|required');
	$this -> form_validation ->set_rules('codserv','Servidor','trim|required');
	$this -> form_validation ->set_rules('codturma','Turma','trim|required');
	$this -> form_validation ->set_rules('motivo','Motivação','trim|max_length[100]');
	    if ($this->form_validation->run() == FALSE)
                { 			
					
							$cursos =  $this->inscricao_m->retorna_curso();
							//$essa = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
							//$datav['turmas'] = $this->inscricao_m->retorna_turma();
                        	$datav['servs'] = $this->inscricao_m->retorna_serv();
                        	$option = "<option value=''></option>";
	foreach($cursos -> result()  as $linha) {
	$option .= "<option value='$linha->codcurso'>$linha->modulo</option>";			
		}
				$datav['options_cursos'] = $option;

		
                        	$this->load->view('inscritos/ins_cad', $datav);
                        	

                       
                }
                else
                {
					
                     $dados=elements(array('datains','codserv','situacao','codturma','motivo'), $this ->input->post());
                  
                
                    $this->inscricao_m->inserir($dados);
             
                
		    $this->load->view('inscritos/ins_cad',$datav);

}
	
	
	}
	
	
	public function busca_cursos_turmas($id){
		
	
		
		$turma = $this->inscricao_m->retorna_turma();
		
		$option = "<option value=''></option>";
		foreach($turma -> result() as $linha) {
			$option .= "<option value='$linha->codturma'>$linha->nometurma</option>";			
		}
		
		echo $option;
	}
	

	


	public function editar()
	{
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');
		$this -> form_validation ->set_rules('datains','DATA','trim|required');
		$this -> form_validation ->set_rules('situacao','Estado','trim|required');
		$this -> form_validation ->set_rules('motivo','Motivação','trim|max_length[100]');
	    if ($this->form_validation->run() == FALSE)
                {
							$datav['servs'] = $this->inscricao_m->retorna_serv();
                        	$datav['turmas'] = $this->inscricao_m->retorna_turma_all();
                        	$this->load->view('inscritos/ins_atu', $datav);
					
                }
                else
                {
             $dados=elements(array('datains','codserv','situacao','codturma','motivo'), $this ->input->post());
                  
                  
                
                $this->inscricao_m->atualizar_do($dados,array('codinscricao' => $this->input->post('$idins')));
             
                
		$this->load->view('inscritos/ins_atu', $datav);

}
		}
		
		
		

		
		public function deletar()
	{
							$datav['servs'] = $this->inscricao_m->retorna_serv();
                        	$datav['turmas'] = $this->inscricao_m->retorna_turma_del();
                        	$this->load->view('inscritos/ins_del', $datav);
		
   
		if($this->input->post('$idins')>0):

	 $this->inscricao_m->deletar_do(array('codinscricao' => $this->input->post('$idins')));
	 
	 endif;
	  
		}

public function listar(){
			
			
			 $this->load->library('pagination');
	$maximo = 5;
	$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
	$config['base_url'] = base_url('administrador.php/inscricao/listar');
	$config['total_rows'] =$this->inscricao_m->contaRegistros();
	$config['per_page'] =  $maximo;
	//$config['first_link'] = 'Primeiro';
	//$config['last_link'] = 'Último';
	$config['next_link'] = 'Próximo';
	$config['prev_link'] = 'Anterior';
	$this->pagination->initialize($config);
	
	$datas['page'] = $this->pagination->create_links();
	$datas['query2'] = $this->inscricao_m->do_pesquisa($maximo, $inicio);
					
	$this->load->view('inscritos/ins_v', $datas);
	
			
			
			}//fimfuncao

public function send_mail() {
		//$para = $this->input->post('txt_para', TRUE);
		$data = $this->inscricao_m->retorna_last_inscricao();
		foreach ($data as $linha){
			$idins = $linha->codinscricao;
			$nomeserv = $linha->nomeserv;
			$matriculasiapeservidor = $linha->siape;
			$nomecurso=$linha->nome;
			$mmodulo=$linha->modulo;
			$nturma=$linha->nometurma;
			$tdias=$linha->diasemana;
			$hrin=$linha->horainicio;
			$hrfim=$linha->horafim;
			$datain=$linha->datainicio;
			$dataf=$linha->datafim;
			$emailserv=$linha->email;
			$chefemail=$linha->emailchefe;
			$chefenome=$linha->nomechefe;
			
		
		
		$this->load->library("My_PHPMailer");
    $mail = new PHPMailer();
    $mail->IsSMTP(); //Definimos que usaremos o protocolo SMTP para envio.
    $mail->SMTPAuth = true; //Habilitamos a autenticação do SMTP. (true ou false)
    $mail->SMTPSecure = "ssl"; //Estabelecemos qual protocolo de segurança será usado.
    $mail->Host = "smtp.gmail.com"; //Podemos usar o servidor do gMail para enviar.
    $mail->Port = 465; //Estabelecemos a porta utilizada pelo servidor do gMail.
    $mail->Username = "josidim@gmail.com"; //Usuário do gMail
    $mail->Password = "hillsong01"; //Senha do gMail
    $mail->SetFrom('josidim@gmail.com', 'CODEP'); //Quem está enviando o e-mail.
    //$mail->AddReplyTo("response@email.com","Nome Completo"); //Para que a resposta será enviada.
    $mail->Subject = "CODEP - Confirmação da Inscrição"; //Assunto do e-mail.
    //$mail->Body = "Corpo do e-mail em HTML.<br />";
    $mail->Body = '<p><h4>CODEP-DP/DAA - Inscrições </h4></p>
           <p>&nbsp;</p>
		   <p>&nbsp;</p>
      <p>Olá, '.$nomeserv.', sua inscrição no curso '.$nomecurso.': módulo '.$mmodulo.', foi realizada com sucesso!!</p>
      <p>Certifique-se que seu chefe recebeu o e-mail de pedido de autorização da sua inscrição, pois a mesma se faz necessário para que possa concorrer a vaga do curso que selecionou.</p>
      <p>&nbsp;</p>
      <p>Você criou a sua senha de acompanhamento que servirá para verificar o estado da sua inscrição, e também possui as seguintes funcionalidades:</p>
<p>&nbsp;</p>
    <p>- Verificar se o seu chefe autorizou a sua inscrição;</p>

    <p>- Verificar a justificativa do chefe caso ele não autorize a sua inscrição e</p>

    <p>- Verificar se você foi selecionado para o curso que se inscreveu</p>

    <p>&nbsp;</p>

   
    
    <p>&nbsp;</p>

    <p>OBS: A confirmação da inscrição não garante a vaga para o curso selecionado por você, a seleção dos inscritos é determinada a partir dos critérios regulamentados pela CODEP.</p>
    <p>&nbsp;</p>
    <p>Maiores informações pelo tel. 2681-4739 / 2681-4740 ou email codep@ufrrj.br</p>';

    $mail->AltBody = "Corpo em texto puro.";
    //$destino = "josidim12342005@yahoo.com.br";
    $mail->AddAddress($emailserv, $nomeserv);
     
    /*Também é possível adicionar anexos.*/
    //$mail->AddAttachment("images/phpmailer.gif");
   // $mail->AddAttachment("images/phpmailer_mini.gif");
 
   $mail->Send();
   /*Também é possível adicionar anexos.*/
    //$mail->AddAttachment("images/phpmailer.gif");
   // $mail->AddAttachment("images/phpmailer_mini.gif");
   $mail = new PHPMailer();
    $mail->IsSMTP(); //Definimos que usaremos o protocolo SMTP para envio.
    $mail->SMTPAuth = true; //Habilitamos a autenticação do SMTP. (true ou false)
    $mail->SMTPSecure = "ssl"; //Estabelecemos qual protocolo de segurança será usado.
    $mail->Host = "smtp.gmail.com"; //Podemos usar o servidor do gMail para enviar.
    $mail->Port = 465; //Estabelecemos a porta utilizada pelo servidor do gMail.
    $mail->Username = "josidim@gmail.com"; //Usuário do gMail
    $mail->Password = "hillsong01"; //Senha do gMail
    $mail->SetFrom('josidim@gmail.com', 'CODEP'); //Quem está enviando o e-mail.
    //$mail->AddReplyTo("response@email.com","Nome Completo"); //Para que a resposta será enviada.
    $mail->Subject =  utf8_decode("CODEP - Autorização para Curso de Capacitação"); //Assunto do e-mail.
    //$mail->Body = "Corpo do e-mail em HTML.<br />";
    $mail->Body =  utf8_decode( "<p><h4> Inscrições - CODEP-DP/DAA </h4></p>
             <p>&nbsp;</p>
             <p>Servidor:$nomeserv</p>
             <p>Matrícula SIAPE:$matriculasiapeservidor</p>
			 <p>Curso escolhido:$nomecurso</p>
			 <p>Módulo:$mmodulo<p/>
			 <p>Turma:$nturma - $tdias - Horário: ".substr($hrin,0,5)."h às ".substr($hrfim,0,5)."h</p>
             <p>Início do Curso: ".  date('d/m/Y', strtotime($datain))." - Término do curso: ". date('d/m/Y', strtotime($dataf))." </p>
			 <p>&nbsp;</p>
			  <p>&nbsp;</p>
             <p>Senhor dirigente,</p>
             <p>&nbsp;</p>
          <p>Para efetivar a inscrição do servidor descrito acima é necessário a sua autorização. A não autorização deverá ser acompanhada de justificativa.</p>
		  <p>Solicitamos sua atenção ao autorizar, pois o mesmo servidor poderá realizar até 5 inscrições em cursos e ou módulos diferentes ao mesmo tempo. </p>
             <p>&nbsp;</p>
			
              <p>&nbsp;</p>
			 <p>Para autorizar a insrição do servidor no curso.<a href='http://localhost:8080/test/aplicacao/usuario.php/cadastro/conferir/".trim($matriculasiapeservidor)."/$idins'>Clique Aqui</a></p>
             
              <p>&nbsp;</p>
            <p>Acesse o cronograma do Curso de Capacitação no Link abaixo:
            <a href='http://www.ufrrj.br/codep/avisos/inscricoes.php'>http://www.ufrrj.br/codep/avisos/inscricoes.php</a></p>
             <p>&nbsp;</p>
			  <p>&nbsp;</p>
            <p>Maiores informações pelo tel. (21) (21) 2681-4739/2681-4740 ou email codep@ufrrj.br</p>");

    $mail->AltBody = "Corpo em texto puro.";
    //$destino = "josidim12342005@yahoo.com.br";
    $mail->AddAddress($chefemail, $chefenome);
    if(!$mail->Send()) {
       $datav["message"] = "ocorreu um erro durante o envio: " . $mail->ErrorInfo;
    } else {
       $datav["message"] =  "Mensagem enviada com sucesso!";
    }
    $this->load->view('inscritos/ins_cad',$datav);
}
}//fimfuncao



}//endcontroler

