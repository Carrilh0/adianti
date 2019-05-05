<?php

class alunoform extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();

        $this->form = new BootstrapFormBuilder();

        $nome = new TEntry('nome');
        $cursos = new TDBCombo('cursos_id','sample','Cursos','id','nome');

        $this->form->addFields([new TLabel('Nome: ')], [$nome]);
        $this->form->addFields([new TLabel('Cursos: ')], [$cursos]);

        parent::add($this->form);

    }

} 