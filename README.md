**SGSchool — Sistema de Gestão Escolar**

O SGSchool é uma aplicação web desenvolvida pelo **Eng. Agostinho** para facilitar a organização e a gestão das principais atividades de uma instituição de ensino. O projeto utiliza Laravel, PHP, Bootstrap 5 e MySQL.

Entre as funcionalidades previstas estão a gestão de inscrições e matrículas, bem como a organização de cursos, turmas, salas e anos letivos. A aplicação procura reunir essas informações num único sistema, com páginas simples e fáceis de utilizar.

**Como executar o projeto localmente:**

1. Clone o repositório do GitHub e abra a pasta do projeto no terminal.
2. Instale as dependências com `composer install`.
3. Copie `.env.example` para `.env` e configure a ligação à base de dados MySQL.
4. Gere a chave da aplicação com `php artisan key:generate`.
5. Crie as tabelas com `php artisan migrate`.
6. Inicie o servidor com `php artisan serve`.
7. Abra no navegador o endereço local apresentado no terminal.

O projeto está em desenvolvimento e poderá receber novas funcionalidades conforme as necessidades da instituição.
