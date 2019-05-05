<?php

class cursoform extends TPage
{
 
    private $form;

    function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder;


        $nome = new TEntry('nome');

        
        $this->form->addFields([new TLabel('Nome')],      [$nome]);       
        
        $this->form->addAction('Enviar',new TAction(array($this,'onSave')),'fa:check-circle-o green');
        
 
        parent::add($this->form);

    }

        function onSave(){
        
            try{
                TTransaction::open('sample');
                $data = $this->form->getData();
                
                $cursos = new cursos();
                $cursos->nome = $data->nome;

                $cursos->store();
    
                new TMessage('info',"Curso {$cursos->nome} Cadastrado com sucesso");
                
                TTransaction::close();
    
            }catch(Exception $e){
            new TMessage('error',$e->getMessage());
            }
        }

}
