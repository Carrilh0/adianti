<?php

class WelcomeView extends TPage
{
 
    private $form;

    function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder;


        $nome = new TEntry('nome');
        $sobrenome = new TEntry('sobrenome');
        $idade = new TEntry('idade');
        
        $this->form->addFields([new TLabel('Nome')],      [$nome]);
        $this->form->addFields([new TLabel('Sobrenome')],      [$sobrenome]);
        $this->form->addFields([new TLabel('Idade')],      [$idade]);
        
        
        $this->form->addAction('Enviar',new TAction(array($this,'onSave')),'fa:check-circle-o green');
        

        parent::add($this->form);

    }

        function onMostrar(){
            $data = $this->form->getData();
            $mensagem = $data->nome;
            new TMessage('info',"{$data->nome}");

        }
        function onSave(){
        
            try{
                TTransaction::open('sample');
                $data = $this->form->getData();
                
                $pessoa = new pessoa();
                $pessoa->nome = $data->nome;
                $pessoa->sobrenome = $data->sobrenome;
                $pessoa->idade = $data->idade;
                $pessoa->store();
    
                new TMessage('info',"{$pessoa->nome} Acaba de ser cadastrado");
                
                TTransaction::close();
    
            }catch(Exception $e){
            new TMessage('error',$e->getMessage());
            }
        }

}
