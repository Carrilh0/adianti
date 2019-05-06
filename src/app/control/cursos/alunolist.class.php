<?php

class alunolist extends TPage{

    private $datagrid;
    private $loaded;

    public function __construct(){
        parent::__construct();

        $form = new TQuickForm();
        $form->addQuickAction('Novo', new TAction(array('alunoform','onEdit')));
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid());
        $this->datagrid->width = '100%';

        $id = new TDataGridColumn('id','#','left');
        $nome = new TDataGridColumn('nome','Nome','left');
        
        $this->datagrid->addColumn($id);
        $this->datagrid->addColumn($nome);


        $edit = new TDataGridAction(array('alunoform', 'onEdit'));
        $edit->setLabel('Editar');
        $edit->setImage('fa:search green');
        $edit->setField('id');

        $action_group = new TDataGridActionGroup('Opções','bs:th');
        $action_group->addHeader('Opções Disponiveis');
        $action_group->addAction($edit);

        $this->datagrid->addActionGroup($action_group);
        $this->datagrid->createModel();

        $box = new TVBox();
        $box->add($form);
        $box->add($this->datagrid);
        $box->style = 'width: 100%;';

        parent::add($box);
    }
    
    public function onReload($param){
        try{
            TTransaction::open('sample');
            $alunos = Alunos::getObjects();
            $this->datagrid->addItems($alunos);
            TTransaction::close();
        }catch(Exception $e){
            new TMessage('error',$e->getMessage());
        }
    }
    
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

}