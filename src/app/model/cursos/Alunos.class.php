<?php


class Alunos extends TRecord{

    const TABLENAME = 'pessoas';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';

    private $cursos;
 
    public function __constructor($id = NULL ){
        parent::__constructor($id);

        parent::addAttribute('nome');
        parent::addAttribute('cursos_id');
    }
   
    public function get_cursos(){
        if (empty($this->cursos)){
            $this->cursos = new Cursos($this->cursos_id);
        return $this->cursos; 
        }
    }
 
}