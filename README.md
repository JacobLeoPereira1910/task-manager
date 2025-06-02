# Task Manager - Prova PL Fullstack - TECSA

Projeto de avaliação para vaga de Desenvolvedor Fullstack. Sistema completo de gerenciamento de tarefas com autenticação, CRUD, filtros, ordenação.

## Funcionalidades

- Autenticação via JWT (Login)
- CRUD de tarefas com API RESTful
- Filtros e ordenação no frontend
- Validação de dados no frontend e backend
- Backend PHP, MySQL, Apache
- Frontend com HTML, Bootstrap e JavaScript (sem frameworks)
- Docker e Docker Compose prontos para subir o ambiente local

## Requisitos

- Docker
- Docker Compose

## Como Rodar

```bash
git clone https://github.com/JacobLeoPereira1910/task-manager
cd task-manager
docker-compose up --build
Após subir, acesse em: http://localhost:9000
```

Login
A autenticação está implementada com JWT.

Usuário: tecsa
Senha: tecsa
Os dados estão hardcoded propositalmente em login.php para facilitar testes e avaliação. O token JWT é armazenado no localStorage após o login e usado nas requisições autenticadas.

Testes
Não houve tempo hábil para implementar testes unitários ou de integração no backend. O código está preparado para tal, com estrutura em camadas e uso de classes isoladas para facilitar testes em endpoints.

Banco de Dados
O container MySQL será criado automaticamente com:
Banco: taskdb

Usuário: user
Senha: password

O script init.sql em backend/database/ garante a criação automática da tabela de tarefas ao subir o container.


