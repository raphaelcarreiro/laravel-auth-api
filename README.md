# Laravel Auth API

API de autenticação construída com Laravel, estruturada de forma modular e preparada para ambientes Docker, incluindo monitoramento, mensageria com Kafka e integração com ELK Stack.

---

## 🚀 Tecnologias Utilizadas

-   **Laravel** (PHP)
-   **Docker & Docker Compose**
-   **MySQL**
-   **Redis**
-   **Kafka**
-   **ELK Stack (Elasticsearch, Logstash, Kibana)**
-   **Grafana + Prometheus + Loki**
-   **OpenTelemetry**
-   **JWT para autenticação**

---

## 📂 Estrutura de Diretórios

```plaintext
.
├── .docker/                     # Configurações Docker (MySQL, Redis, Kafka, etc.)
├── .devcontainer/              # Configurações para desenvolvimento com VSCode Remote Containers
├── core/                       # Módulos de domínio (casos de uso, entidades e abstrações de infraestrutura)
├── config/                     # Configurações da aplicação
├── routes/                     # Rotas
├── docker-compose.yml          # Stack principal
├── docker-compose.kafka.yml    # Stack Kafka/Zookeeper
├── docker-compose.monitoring.yml # Stack de observabilidade
├── docker-compose.elk.yml      # Stack ELK (Elasticsearch, Logstash, Kibana)
└── ...
```

---

---

## 🐳 Instalação do Docker e Docker Compose no Ubuntu (incluindo WSL)

### 1. Atualize o sistema

```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Instale dependências

```bash
sudo apt install apt-transport-https ca-certificates curl software-properties-common lsb-release gnupg -y
```

### 3. Adicione o repositório oficial do Docker

```bash
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker.gpg
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

### 4. Instale o Docker Engine e o Docker Compose Plugin

```bash
sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y
```

### 5. Verifique a instalação

```bash
docker --version
docker compose version
```

### 6. Adicione seu usuário ao grupo `docker` (para evitar sudo)

```bash
sudo usermod -aG docker $USER
newgrp docker
```

### 7. Ative o Docker no WSL (se necessário)

```bash
wsl --update
wsl --shutdown
```

> Reinicie o terminal após isso.

---

## ⚙️ Como Executar

### Pré-requisitos

-   Docker
-   Docker Compose
-   VSCode (recomendado com extensão _Dev Containers_)

### Ambiente de Desenvolvimento

1. Copie o arquivo `.env.example`:

    ```bash
    cp .env.example .env
    ```

2. Suba os containers:

    ```bash
    docker compose up -d
    ```

3. Instale as dependências:

    ```bash
    docker compose exec app composer install
    ```

4. Gere a chave da aplicação:

    ```bash
    docker compose exec app php artisan key:generate
    ```

5. Execute as migrations:
    ```bash
    docker compose exec app php artisan migrate
    ```

---

## 🔐 Autenticação

A autenticação utiliza **JWT**. Após login bem-sucedido, um token será retornado e deverá ser enviado no header das requisições subsequentes:

```http
Authorization: Bearer <seu-token>
```

---

## 📈 Observabilidade

O projeto inclui suporte a monitoramento e logging via:

-   **Grafana** – acessível via `http://localhost:3000`
-   **Prometheus** – métrica de aplicações em `http://localhost:9090`
-   **Loki + Promtail** – coleta e centraliza logs da aplicação
-   **Elasticsearch + Kibana** – logs estruturados e visualização via `http://localhost:5601`

### Portas padrão

| Serviço         | Porta  |
| --------------- | ------ |
| Grafana         | `3000` |
| Prometheus      | `9090` |
| Kibana          | `5601` |
| Elasticsearch   | `9200` |
| AKHQ (Kafka UI) | `8080` |

---

## 📦 Kafka

O Kafka é usado como broker de mensagens. Há suporte para múltiplos consumidores e producers PHP ou Node.js (ex: NestJS).

### Comandos úteis

-   Subir stack Kafka:

    ```bash
    docker compose -f docker-compose.kafka.yml up -d
    ```

-   Monitorar via AKHQ:
    Acesse: `http://localhost:8080`

---

## 🛠️ Desenvolvimento com DevContainer

Este projeto é compatível com o ambiente de desenvolvimento remoto via VSCode.

### Passos:

1. Certifique-se de ter a extensão **Remote - Containers** instalada no VSCode.
2. Abra a pasta do projeto no VSCode.
3. Clique em `Reabrir em Container` (ou use o comando da paleta de comandos).
4. O VSCode construirá o container com base nas configurações de `.devcontainer/`.
