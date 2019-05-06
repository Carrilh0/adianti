<?php

class cursolist extends TPage{

    private $datagrid; //variavel para armazenar o datagrid
    private $loaded;    //variavel para armazenar os dados do banco e jogar na lista
    
    public function __construct(){
        parent::__construct();
    
    
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid());    //Pegando a classe do bootsrap a salvando na variavel da grid
        $this->datagrid->width = '100%';
        
        $id = new TDataGridColumn('id','#','left');    //coluna da grid ID
        $nome = new TDataGridColumn('nome','Nome','left'); //coluna da grid Nome

        $this->datagrid->addColumn($id);
        $this->datagrid->addColumn($nome);

        $edit = new TDataGridAction(array('cursoform','onEdit'));
        $edit->setLabel('Editar');
        $edit->setImage('fa:search blue');
        $edit->setField('id');

        $action_group = new TDataGridActionGroup('Opções','bs:th');
        $action_group->addHeader('Opções Disponiveis');
        $action_group->addAction($edit);

        $this->datagrid->addActionGroup($action_group);

        $this->datagrid->createModel();

        parent::add($this->datagrid);
    }
    
    function onReload(){
        try{
            TTransaction::open('sample');
            $cursos = Cursos::getObjects();
            $this->datagrid->addItems($cursos);
            TTransaction::close();
        }catch(Exception $e){
            new TMessage('error',$e->getMessage());
        }
    }
    
    
    
    function show()  //function da listagem na grid
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