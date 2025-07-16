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
-   **NestJS (consumidor opcional para Kafka)**

---

## 📂 Estrutura de Diretórios

```plaintext
.
├── .docker/                     # Configurações Docker (MySQL, Redis, Kafka, etc.)
├── .devcontainer/              # Configurações para desenvolvimento com VSCode Remote Containers
├── core/                       # Módulos de domínio (entidades, casos de uso e abstrações de infraestrutura)
├── config/                     # Configurações da aplicação
├── routes/                     # Rotas
├── docker-compose.yml          # Stack principal
├── docker-compose.kafka.yml    # Stack Kafka/Zookeeper
├── docker-compose.monitoring.yml # Stack de observabilidade
├── docker-compose.elk.yml      # Stack ELK (Elasticsearch, Logstash, Kibana)
└── ...
```

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
    docker-compose up -d
    ```

3. Instale as dependências:

    ```bash
    docker exec -it auth-api-php composer install
    ```

4. Gere a chave da aplicação:

    ```bash
    docker exec -it auth-api-php php artisan key:generate
    ```

5. Execute as migrations:
    ```bash
    docker exec -it auth-api-php php artisan migrate
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
    docker-compose -f docker-compose.kafka.yml up -d
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

---

## 🧾 Licença

Este projeto é distribuído sob a licença **MIT**. Veja o arquivo `LICENSE` para mais detalhes.
