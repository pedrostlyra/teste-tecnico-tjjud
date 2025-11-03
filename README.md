# Sistema de Cadastro de Livros

Sistema web completo para gerenciamento de livros, autores e assuntos, desenvolvido em Laravel com interface Blade e relatórios integrados.

## 📋 Índice

- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Executando o Projeto](#executando-o-projeto)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Funcionalidades](#funcionalidades)
- [Testes](#testes)
- [Banco de Dados](#banco-de-dados)
- [Relatórios](#relatórios)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)

## 🚀 Requisitos

Antes de começar, certifique-se de ter instalado:

- **Docker** (versão 20.10 ou superior)
- **Docker Compose** (versão 2.0 ou superior)
- **Git** (para clonar o repositório)

### Requisitos do Sistema

- Mínimo 4GB RAM disponível
- 2GB de espaço em disco livre
- Portas disponíveis: `8080` (web), `3306` (MySQL)

## 📦 Instalação

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd teste-tecnico-tjjud
```

### 2. Configure as permissões

No Windows, as permissões são gerenciadas automaticamente pelo Docker. Em Linux/Mac, execute:

```bash
chmod -R 755 src/storage src/bootstrap/cache
```

### 3. Inicie os containers

```bash
docker compose up -d --build
```

Este comando irá:
- Construir a imagem PHP com todas as extensões necessárias
- Iniciar o container MariaDB
- Iniciar o servidor Nginx
- Criar a rede Docker necessária

### 4. Configure o ambiente Laravel

```bash
# Copiar arquivo de ambiente
docker exec php-app cp .env.example .env

# Gerar chave da aplicação
docker exec php-app php artisan key:generate

# Criar link simbólico para storage
docker exec php-app php artisan storage:link
```

### 5. Execute as migrações

```bash
# Executar migrações
docker exec php-app php artisan migrate

# Executar seeders (popular banco de dados)
docker exec php-app php artisan db:seed
```

### 6. Configure permissões do storage

```bash
docker exec -u root php-app chown -R www-data:www-data storage bootstrap/cache
docker exec -u root php-app chmod -R 775 storage bootstrap/cache
```

## ⚙️ Configuração

### Variáveis de Ambiente

O arquivo `.env` já está configurado para funcionar com Docker. As principais configurações são:

```env
APP_NAME="Sistema de Livros"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=livros_db
DB_USERNAME=user
DB_PASSWORD=userpass
```

### Credenciais do Banco de Dados

- **Host**: `localhost` (ou `db` dentro do container)
- **Porta**: `3306`
- **Database**: `livros_db`
- **Usuário**: `user`
- **Senha**: `userpass`
- **Root Password**: `root`

## 🏃 Executando o Projeto

### Acessar a aplicação

Após iniciar os containers, acesse:

**URL**: http://localhost:8080

### Comandos Úteis

```bash
# Ver logs dos containers
docker compose logs -f

# Parar os containers
docker compose down

# Parar e remover volumes (limpar banco)
docker compose down -v

# Reconstruir containers após mudanças
docker compose up -d --build

# Acessar terminal do container PHP
docker exec -it php-app bash

# Acessar terminal do MariaDB
docker exec -it mariadb mysql -uroot -proot livros_db

# Executar comandos Artisan
docker exec php-app php artisan <comando>
```

## 📁 Estrutura do Projeto

```
teste-tecnico-tjjud/
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Configuração Nginx
│   └── php/
│       └── Dockerfile             # Imagem PHP customizada
├── src/                           # Código Laravel
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/      # Controladores web
│   │   │   ├── Requests/         # Validação de formulários
│   │   │   └── Resources/        # (removido - API não usada)
│   │   └── Models/               # Modelos Eloquent
│   ├── database/
│   │   ├── factories/             # Factories para testes
│   │   ├── migrations/           # Migrações do banco
│   │   ├── seeders/              # Seeders
│   │   └── structure.sql         # Views, Procedures, Triggers
│   ├── resources/
│   │   └── views/                # Templates Blade
│   ├── routes/
│   │   ├── web.php               # Rotas web
│   │   └── api.php               # (vazio - API removida)
│   └── tests/                    # Testes PHPUnit
├── docker-compose.yml            # Configuração Docker
└── README.md                     # Este arquivo
```

## 🎯 Funcionalidades

### CRUD de Livros

- **Listar**: Visualização paginada de todos os livros
- **Criar**: Cadastro com validação completa
- **Editar**: Atualização de dados e relacionamentos
- **Excluir**: Remoção com limpeza de relacionamentos

### CRUD de Autores

- **Listar**: Lista paginada de autores
- **Criar**: Cadastro de novos autores
- **Editar**: Atualização de dados
- **Excluir**: Remoção com detach de livros

### CRUD de Assuntos

- **Listar**: Lista paginada de assuntos
- **Criar**: Cadastro de novos assuntos
- **Editar**: Atualização de dados
- **Excluir**: Remoção com detach de livros

### Relatórios

- **Visualização Web**: Tabela interativa com dados consolidados
- **Exportação PDF**: Relatório em formato PDF (DomPDF)
- **Exportação XML**: Dados em XML para ReportViewer/Crystal Reports
- **Exportação JSON**: Dados em JSON para integrações

## 🧪 Testes

### Executar todos os testes

```bash
docker exec php-app php artisan test
```

### Executar apenas testes unitários

```bash
docker exec php-app php artisan test --testsuite=Unit
```

### Executar apenas testes de feature

```bash
docker exec php-app php artisan test --testsuite=Feature
```

### Executar testes específicos

```bash
docker exec php-app php artisan test --filter LivroControllerTest
```

### Cobertura de Testes

- **27 testes unitários**: Modelos e validações
- **21 testes de feature**: Controllers e rotas
- **Total**: 48 testes, 116 asserções

## 🗄️ Banco de Dados

### Estrutura

O banco de dados possui as seguintes tabelas:

- **livros**: Cadastro de livros
- **autores**: Cadastro de autores
- **assuntos**: Cadastro de assuntos
- **livro_autor**: Tabela pivot (livros ↔ autores)
- **livro_assunto**: Tabela pivot (livros ↔ assuntos)
- **log_livros**: Log de alterações de valores (trigger)

### Views

- **vw_livros_autores_assuntos**: View consolidada para relatórios (definida em `structure.sql`)

### Procedures

- **sp_livros_por_autor**: Retorna livros de um autor específico

### Triggers

- **trg_update_valor_log**: Registra alterações de valor no log

### Executar estrutura SQL

```bash
docker exec -i mariadb mysql -uroot -proot livros_db < src/database/structure.sql
```

## 📊 Relatórios

### Acessar Relatórios

Navegue até: http://localhost:8080/relatorio

### Formatos Disponíveis

1. **PDF**: Geração direta no navegador usando DomPDF
2. **XML**: Exportação para uso com ReportViewer/Crystal Reports
3. **JSON**: Exportação para integrações e APIs

### Usando com ReportViewer

O sistema suporta integração com ReportViewer de duas formas:

1. **Conexão direta ao banco**: Conecte ReportViewer à view `vw_livros_autores_assuntos`
2. **Fonte de dados XML**: Use o endpoint `/relatorio/xml` como fonte remota

Veja `REPORTVIEWER_SETUP.md` para instruções detalhadas.

## 🛠️ Tecnologias Utilizadas

### Backend

- **Laravel 12**: Framework PHP
- **PHP 8.2**: Linguagem de programação
- **MariaDB 10.11**: Banco de dados relacional

### Frontend

- **Blade**: Template engine do Laravel
- **Bootstrap 5**: Framework CSS
- **jQuery**: Biblioteca JavaScript
- **Inputmask**: Máscara para campos monetários

### Ferramentas

- **Docker**: Containerização
- **Nginx**: Servidor web
- **PHP-FPM**: Processador PHP
- **DomPDF**: Geração de PDFs
- **PHPUnit**: Framework de testes

### Desenvolvimento

- **Composer**: Gerenciador de dependências PHP
- **Laravel Pint**: Formatador de código
- **Laravel Tinker**: Console interativo

## 🐛 Troubleshooting

### Problema: Erro de permissão no storage

```bash
docker exec -u root php-app chown -R www-data:www-data storage bootstrap/cache
docker exec -u root php-app chmod -R 775 storage bootstrap/cache
```

### Problema: Porta 8080 já em uso

Edite `docker-compose.yml` e altere a porta:

```yaml
ports:
  - "8081:80"  # Altere 8081 para outra porta disponível
```

### Problema: Container não inicia

```bash
# Ver logs
docker compose logs

# Reconstruir do zero
docker compose down -v
docker compose up -d --build
```

### Problema: Erro ao executar migrações

```bash
# Limpar cache
docker exec php-app php artisan config:clear
docker exec php-app php artisan cache:clear

# Rodar migrações novamente
docker exec php-app php artisan migrate:fresh --seed
```

### Problema: View não encontrada

```bash
# Executar estrutura SQL manualmente
docker exec -i mariadb mysql -uroot -proot livros_db < src/database/structure.sql
```

## 📝 Comandos Artisan Úteis

```bash
# Limpar todos os caches
docker exec php-app php artisan optimize:clear

# Recriar banco de dados
docker exec php-app php artisan migrate:fresh --seed

# Listar todas as rotas
docker exec php-app php artisan route:list

# Verificar configuração
docker exec php-app php artisan config:show
```

## 🤝 Contribuindo

Este é um projeto de teste técnico. Para melhorias ou sugestões, abra uma issue ou pull request.

## 📄 Licença

Este projeto é um teste técnico e não possui licença específica.

## 👤 Autor

Desenvolvido como teste técnico para processo seletivo.

---

**Última atualização**: Novembro 2025
