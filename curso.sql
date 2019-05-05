create database curso;

use curso;

create table cursos(
id int primary key auto_increment not null,
nome varchar(45)
);

create table alunos(
id int primary key not null auto_increment,
nome varchar(45),
cursos_id int
);

select * from aluno;