# Sistema de Cadastro de Livros

Sistema web para gerenciamento de livros, autores e assuntos desenvolvido em Laravel.

## 🚀 Requisitos

- Docker e Docker Compose
- Portas disponíveis: `8080` (web), `3306` (MySQL)

## 📦 Instalação e Execução

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd teste-tecnico-tjjud
```

### 2. Inicie os containers

```bash
docker compose up -d --build
```

### 3. Instale as dependências do Composer

```bash
docker exec php-app composer install
```

### 4. Configure o ambiente Laravel

```bash
docker exec php-app cp .env.example .env
docker exec php-app php artisan key:generate
docker exec php-app php artisan storage:link
```

### 5. Execute as migrações

```bash
docker exec php-app php artisan migrate
docker exec php-app php artisan db:seed
```

### 6. Configure permissões

```bash
docker exec -u root php-app chown -R www-data:www-data storage bootstrap/cache
docker exec -u root php-app chmod -R 775 storage bootstrap/cache
docker exec mariadb mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'user'@'%'; FLUSH PRIVILEGES;"
```

### 7. Acesse a aplicação

**URL**: http://localhost:8080

## 🧪 Testes

```bash
docker exec php-app php artisan test
```

## 📝 Comandos Úteis

```bash
# Parar containers
docker compose down

# Ver logs
docker compose logs -f

# Acessar terminal PHP
docker exec -it php-app bash

# Acessar MariaDB
docker exec -it mariadb mysql -uroot -proot livros_db

# Executar comandos Artisan
docker exec php-app php artisan <comando>
```

## 🐛 Troubleshooting

**Erro de permissão no storage:**
```bash
docker exec -u root php-app chown -R www-data:www-data storage bootstrap/cache
docker exec -u root php-app chmod -R 775 storage bootstrap/cache
```

**Porta 8080 em uso:**
Edite `docker-compose.yml` e altere `"8080:80"` para outra porta.

**Reconstruir do zero:**
```bash
docker compose down -v
docker compose up -d --build
```

**Erro "vendor not found" ou "Class not found":**
Execute `docker exec php-app composer install` para instalar as dependências.

## 🛠️ Tecnologias

- **Laravel 12** + **PHP 8.2**
- **MariaDB 10.11**
- **Docker** + **Nginx**
- **Bootstrap 5** + **Blade**

---

**Desenvolvido como teste técnico para processo seletivo**
