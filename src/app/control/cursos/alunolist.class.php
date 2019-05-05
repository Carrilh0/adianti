<?php

class alunolist extends TPage{

    private $datagrid;
    private $loaded;
    public function __construct(){
        parent::__construct();

        $form = new TQuickForm('teste');
        $form->addQuickAction('Novo', new TAction(array('alunoform','onEdit')));

        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid());
        $this->datagrid->width = '100%';

        $this->datagrid->addQuickColumn('#','id');
        $this->datagrid->addQuickColumn('Nome','nome');
        $this->datagrid->enablePopover('Nome',"{nome}");
        $this->datagrid->addQuickAction('Editar',new TDataGridAction(array('alunoform','onEdit')),'id');
        $this->datagrid->createModel();

        $box = new TVBox();
        $box->add($form);
        $box->add($this->datagrid);


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