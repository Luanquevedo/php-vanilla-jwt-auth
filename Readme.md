# Auth JWT Manual API

Uma API de autenticação robusta desenvolvida em **PHP Vanilla**, focada em demonstrar conceitos de engenharia de software sem a dependência de frameworks pesados. O projeto implementa autenticação JWT (JSON Web Token), arquitetura MVC, roteamento manual e persistência de dados com MySQL utilizando UUID v7.

## 🚀 Funcionalidades

- **Autenticação JWT**: Geração e validação de tokens para acesso a rotas protegidas.
- **UUID v7**: Implementação manual de identificadores únicos ordenáveis por tempo.
- **Arquitetura Limpa**: Separação clara entre Controllers, Models, Middlewares e Requests.
- **Sistema de Migrations**: Script CLI para gerenciamento de tabelas do banco de dados.
- **Validação de Dados**: Camada de Request dedicada para sanitização e validação de inputs.
- **Autoload Customizado**: Implementação de carregamento automático de classes baseada em PSR-4.

## 🛠️ Tecnologias Utilizadas

- **PHP 8.2+**
- **MySQL 8.0+**
- **PDO** (PHP Data Objects)
- **JWT** (Hmac SHA256)

## 📋 Pré-requisitos

- Servidor PHP local ou PHP instalado no sistema.
- Banco de dados MySQL.
- Extensões PHP ativas: `openssl`, `pdo_mysql`, `mbstring`.

## 🔧 Configuração e Instalação

1. **Configuração do Ambiente**:
   Renomeie o arquivo `.env.example` para `.env` (ou crie um novo na raiz) e configure suas credenciais:
   ```env
   APP_NAME="Projeto JWT"
   APP_DEBUG=true
   APP_URL=http://localhost:8080
   APP_KEY=sua_chave_secreta_aqui

   DB_CONNECTION=mysql
   DATABASE_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=JWT
   DB_USER=root
   DB_PASSWORD=1234
   ```

2. **Executar Migrations**:
   Para criar as tabelas necessárias no banco de dados, execute:
   ```bash
   php migrate.php
   ```

3. **Iniciar o Servidor**:
   Utilize o servidor embutido do PHP apontando para a pasta pública:
   ```bash
   php -S localhost:8080 -t public
   ```

## 🛣️ Endpoints da API

Todas as rotas possuem o prefixo `/api/v1`.

| Método | Endpoint | Descrição | Protegido? |
| :--- | :--- | :--- | :--- |
| POST | `/register` | Cadastro de novo usuário | Não |
| POST | `/login` | Autenticação e geração de token | Não |
| GET | `/health-check` | Verifica status do sistema | Não |
| GET | `/me` | Retorna o perfil do usuário logado | **Sim** |

### Exemplo de Registro (POST `/register`)
```json
{
  "name": "Luan Quevedo",
  "email": "luan@exemplo.com",
  "password": "senha_segura_123",
  "confirm": "senha_segura_123",
  "birth": "1995-05-15"
}
```

### Exemplo de Login (POST `/login`)
```json
{
  "email": "luan@exemplo.com",
  "password": "senha_segura_123"
}
```

## 🔐 Como utilizar o Token

Após realizar o login, você receberá um campo `token` no JSON de resposta. Para acessar as rotas protegidas (como `/me`), você deve enviar o token no cabeçalho (Header) da requisição:

**Key:** `Authorization`  
**Value:** `Bearer SEU_TOKEN_AQUI`

## 📂 Estrutura de Pastas

```text
├── config/          # Configurações de Banco de Dados e Autoload
├── Database/        # Migrations de tabelas
├── public/          # Ponto de entrada (index.php)
├── routes/          # Definição de rotas da API
├── src/             # Código fonte principal
│   ├── Controllers/ # Lógica de controle
│   ├── Core/        # Classes base (JWT, Env, Router)
│   ├── Middlewares/ # Filtros de requisição (Auth)
│   ├── Models/      # Interação com Banco de Dados
│   └── Requests/    # Validação de formulários/JSON
└── migrate.php      # Executor de migrations via CLI
```

---
Desenvolvido por Luan Quevedo
```