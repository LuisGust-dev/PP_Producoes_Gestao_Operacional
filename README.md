# PP Produções Gestão Operacional

Sistema web responsivo para controle operacional de eventos da PP Produções.

O objetivo principal é garantir que todos os equipamentos necessários sejam conferidos antes da saída para o evento e conferidos novamente no retorno.

## Tecnologias

- PHP 8.4
- Laravel 13
- Laravel Breeze
- Blade
- Tailwind CSS
- Alpine.js
- SQLite no ambiente local inicial

## Rodando localmente

Instale as dependências PHP:

```bash
composer install
```

Instale as dependências JavaScript:

```bash
npm install
```

Copie o arquivo de ambiente, caso ainda não exista:

```bash
cp .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Rode as migrations e seeders:

```bash
php artisan migrate --seed
```

Suba o servidor Laravel:

```bash
php artisan serve
```

Em outro terminal, rode o Vite:

```bash
npm run dev
```

## Login inicial

```text
admin@ppproducoes.com
password
```

## Módulos iniciais

- Autenticação
- Dashboard operacional
- Eventos
- Equipamentos
- Categorias
- Gestão de equipe pelo administrador
- Checklist inicial de preparação, carregamento e retorno
