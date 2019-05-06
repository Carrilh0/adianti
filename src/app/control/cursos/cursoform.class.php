<?php

class cursoform extends TPage
{
 
    private $form;

    function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_cursos');

        $id = new TEntry('id');
        $nome = new TEntry('nome');

        
        $this->form->addFields([new TLabel('ID: ')],      [$id]);       
        $this->form->addFields([new TLabel('Nome')],      [$nome]);       
        $id->setEditable(false);
        $this->form->addAction('Enviar',new TAction(array($this,'onSave')),'fa:check-circle-o green');
        
 
        parent::add($this->form);

    }

    public function onEdit($param){
        try{
            if(isset($param['key'])){
                $key = $param['key'];
                TTransaction::open('sample');

                $data = new Cursos($key);
                $this->form->setData($data);

                TTransaction::close();
            }else{
                $this->form->clear();
            }
        }catch(Exception $e){
            new TMessage('error',$e-GetMessage());
        }
    }

    function onSave(){
        
            try{
                TTransaction::open('sample');
                $data = $this->form->getData('Cursos');
                
                $data->store();
    
                new TMessage('info',"Operação realizada com sucesso");
                
                TTransaction::close();
    
            }catch(Exception $e){
            new TMessage('error',$e->getMessage());
            }
        }

        
}
