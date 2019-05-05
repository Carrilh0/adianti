<?php

class alunoform extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();

        $this->form = new BootstrapFormBuilder('form_alunos');

        $nome = new TEntry('nome');
        $cursos = new TDBCombo('cursos_id','sample','Cursos','id','nome');

        $this->form->addFields([new TLabel('Nome: ')], [$nome]);
        $this->form->addFields([new TLabel('Cursos: ')], [$cursos]);

        $this->form->addAction('Enviar',new TAction(array($this,'onSave')),'fa:check-circle-o green');

        parent::add($this->form);

    }

    function onSave(){
        
        try{
        TTransaction::open('sample');
        
        $data = $this->form->getData('Alunos');
        $alunos->store();
        TTransaction::close();

        new TMessage('info', "{$alunos->nome} Cadastrado com sucesso");
        
        }catch(Exception $e){
            new TMessage('error',$e->getMessage());
        }

    }

} 