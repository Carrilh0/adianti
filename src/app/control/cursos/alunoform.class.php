<?php

class alunoform extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('form_alunos');

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cursos = new TDBCombo('cursos_id','sample','Cursos','id','nome');
        $id->setEditable(FALSE);
        
        $this->form->addFields([new TLabel('ID: ')], [$id]);       
        $this->form->addFields([new TLabel('Nome: ')], [$nome]);
        $this->form->addFields([new TLabel('Cursos: ')], [$cursos]);

        $this->form->addAction('Enviar',new TAction(array($this,'onSave')),'fa:check-circle-o green');

        parent::add($this->form);

    }

    public function onEdit($param){
        try{
            if(isset($param['key'])){
                        

                $key = $param['key'];
                TTransaction::open('sample');
                
                $data = new Alunos($key);
                $this->form->setData($data);
    
                TTransaction::close();
            
            }else{
                $this->form->clear();
            }
    
        }catch(Exception $e){
                new TMessage('error',$e->getMessage());
            }
    
    }
    
    function onSave($param){
        
        try{
        
        TTransaction::open('sample');
        
        $data = $this->form->getData('Alunos');
        $data->store();
        TTransaction::close();

        new TMessage('info', "Operação realizada com sucesso");

        }catch(Exception $e){
            new TMessage('error',$e->getMessage());
        }
        
    }

} 