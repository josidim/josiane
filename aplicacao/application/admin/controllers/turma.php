<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turma extends CI_Controller {

	
	
	public function __construct() {
        parent::__construct();
 $this->load->model('Turma_m','turma_m');
   $this->load->model('Admin_m','admin_m',TRUE);
 $this->admin_m->logged();
   
 
}
 
	
	
	public function index()
	
	{
	

Redirect('turma/listar');
	}
	public function cadastrar()
	
	{
	$this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');
	$this -> form_validation ->set_rules('codcurso','Curso','trim|required|max_length[100]');
	$this -> form_validation ->set_rules('nometurma','NOME','trim|required|max_length[100]');
	$this -> form_validation ->set_rules('diasemana[]','Dias da semana','trim|required');
	$this -> form_validation ->set_rules('datainicio','Data de início','trim|required');
	$this -> form_validation ->set_rules('datafim','Data do fim','trim|required');
	$this -> form_validation ->set_rules('horainicio','Hora de início','trim|required');
	$this -> form_validation ->set_rules('horafim','Hora do Fim','trim|required');
	$this -> form_validation ->set_rules('codcurso','Curso','trim|required');
	    if ($this->form_validation->run() == FALSE)
                {
                        	$data['cursos'] = $this->turma_m->retorna_curso();
$this->load->view('turma/turma_cad', $data);
                       
                }
                else
                {
			
					
				            $dados=elements(array('nometurma', 'diasemana', 'datainicio', 'datafim', 'horainicio', 'horafim', 'codcurso'), $this->input->post());
							$dados['diasemana'] = implode('/', $dados['diasemana'] );//checkboxs dos dias da semana foi preciso usar a função explode
                
                    $this->turma_m->inserir($dados);
             
                
		$this->load->view('turma/turma_cad',$data);

}
	
	}
	
	
	
	

	


	public function editar()
	{
	$this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');
	$this -> form_validation ->set_rules('nometurma','NOME','trim|required|max_length[100]');
	$this -> form_validation ->set_rules('diasemana[]','Dias da semana','required');
	$this -> form_validation ->set_rules('datainicio','Data de início','trim|required');
	$this -> form_validation ->set_rules('datafim','Data do fim','trim|required');
	$this -> form_validation ->set_rules('horainicio','Hora de início','trim|required');
	$this -> form_validation ->set_rules('horafim','Hora do Fim','trim|required');
	$this -> form_validation ->set_rules('codcurso','Curso','trim|required');
	    if ($this->form_validation->run() == FALSE)
                {
					$data['cursos'] = $this->turma_m->retorna_curso_all();
                        $this->load->view('turma/turma_atu',$data);
                }
                else
                {
   
                  $dados=elements(array('nometurma', 'diasemana', 'datainicio', 'datafim', 'horainicio', 'horafim', 'codcurso'), $this->input->post());
                  $dados['diasemana'] = implode('/', $dados['diasemana'] );
                
                $this->turma_m->atualizar_do($dados,array('codturma' => $this->input->post('$idturma')));
             
                
		$this->load->view('turma/turma_atu',$data);

}
		}
		
		
		

		
		public function deletar()
	{
		$data['cursos'] = $this->turma_m->retorna_curso_all();
                        
		 $this->load->view('turma/turma_del',$data);
		if($this->input->post('$idturma')>0):

	 $this->turma_m->deletar_do(array('codturma' => $this->input->post('$idturma')));
	 
	 endif;
	  
		}






	public function listar(){
			
			
			 $this->load->library('pagination');
	$maximo = 8;
	$inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
	$config['base_url'] = base_url('administrador.php/turma/listar/'); 
	$config['total_rows'] =$this->turma_m->contaRegistros();
	$config['per_page'] =  $maximo;
	$config['first_link'] = 'Primeiro';
	$config['last_link'] = 'Último';
	$config['next_link'] = 'Próximo';
	$config['prev_link'] = 'Anterior';
	$this->pagination->initialize($config);
	
	$datas['page'] = $this->pagination->create_links();
	$datas['query2'] = $this->turma_m->do_pesquisa($maximo, $inicio);
					
	$this->load->view('turma/turma_v', $datas);
	
			
			
			}//endfuncao

	
}//endcontroler

