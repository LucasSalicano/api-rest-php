# API Rest PHP - Simulador Caixa Eletrônico 🏧

## Executando a API 🛎️

1. Clonando o repositório em um diretório:
      ```
      git clone git@github.com:LucasSalicano/api-rest-php.git
      ```
2. Dentro do diretório do projeto executar o comando para inciar os containers 🐳:
   
      ```
      docker-compose up -d
      ```
3. Em outro terminal acessar o bash do container api_php com o seguinte comando:
      ```
      docker exec -it api_php /bin/bash
      composer update
      ```
4. Rodar as Migrate e o Seeders
      ```
      php artisan migrate
      php artisan db:seed --class=TipoContasSeeder
      ```


Pronto, a API deverá estar rodando em seu localhost:8080 😀

## ✔️ Métodos
Requisições para a API possui os seguintes padrões:

| Método | Descrição |
|---|---|
| `GET` | Retorna informações de um ou mais registros. |
| `POST` | Utilizado para criar um novo registro. |
| `PUT` | Atualiza todos os dados de um registro. |
| `DELETE` | Remove um registro do sistema. |

## ✔️ Respostas

| Código | Descrição |
|---|---|
| `200` | Requisição executada com sucesso.|
| `201` | Recurso criado com sucesso.|
| `204` | Nenhum recurso encontrado.|
| `400` | Parâmetros enviados são divergentes com os disponiveis.|
| `404` | Recurso não existe.|

# Usuários

## ➡️ Cadastrar Usuários /api/usuarios [`POST`]

| Parâmetro | Tipo |  Descrição |
|---|---|---|
| `nome` | `string` | nome em formato de texto |
| `cpf`  | `string` | cpf com 11 dígitos |
| `data_nascimento`  | `string` | data no formato Y-m-d |

+ Requisição (application/json)

    + Body

            {
                "nome" : "lucas",
                "cpf" : "12345678911",
                "data_nascimento" : "2001-01-25"
            }

+ Response 201 (application/json)

    + Body

            {
                "nome" : "lucas",
                "cpf" : "12345678911",
                "data_nascimento" : "2001-01-25",
                "updated_at": "2021-09-07T13:16:35.000000Z",
                "created_at": "2021-09-07T13:16:35.000000Z",
                "id": 1
            }
    
## ⚠️ Casos de Erro ️ 

Caso o CPF seja diferente de 11 digitos é retornado um ``StatusCode 400`` com o response abaixo:

+ Response 400 (application/json)

    + body example

            {
                "erro": "O CPF ínformado é inválido."
            }

Caso o CPF já existir cadastrado é retornado um ``StatusCode 400`` com o response abaixo:

+ Response 400 (application/json)

    + body example

            {
                "erro": "Já existe um usuário com o mesmo CPF cadastrado."
            }


## ➡️ Listar todos os usuários /api/usuarios [`GET`]

Lista todos os usuários cadastrados de forma paginada ``15 / per_page``.

+ Response 200 (application/json)

    + body example
      
          {
          "current_page": 1,
          "data": [
               {
                    "nome" : "lucas",
                    "cpf" : "12345678911",
                    "data_nascimento" : "01/01/2021",
                    "updated_at": "2021-09-07T13:16:35.000000Z",
                    "created_at": "2021-09-07T13:16:35.000000Z",
                    "id": 1
                }
          ],
          "first_page_url": "http://localhost:8080/api/usuarios?page=1",
          "from": 1,
          "last_page": 1,
          "last_page_url": "http://localhost:8080/api/usuarios?page=1",
          "links": [
              {
                  "url": null,
                  "label": "pagination.previous",
                  "active": false
              },
              {
                  "url": "http://localhost:8080/api/usuarios?page=1",
                  "label": "1",
                  "active": true
              },
              {
                  "url": null,
                  "label": "pagination.next",
                  "active": false
              }
          ],
          "next_page_url": null,
          "path": "http://localhost:8080/api/usuarios",
          "per_page": 15,
          "prev_page_url": null,
          "to": 14,
          "total": 14
          }

## ➡️ Consultar único usuário /api/usuarios/{usuarioId} [`GET`]

+ Response 200 (application/json)

    + body example

          {
              "id": 1,
              "nome": "maria",
              "cpf": "12345678912",
              "data_nascimento": "2021-01-01",
              "created_at": "2021-09-04T19:15:49.000000Z",
              "updated_at": "2021-09-04T19:15:49.000000Z"
          }

## ➡️ Atualizar usuário /api/usuarios/{usuarioId} [`PUT`]


| Parâmetro | Tipo |  Descrição |
|---|---|---|
| `nome` | `string` | nome em formato de texto |
| `cpf`  | `string` | cpf com 11 dígitos |
| `data_nascimento`  | `string` | data no formato Y-m-d |

+ Requisição (application/json)

    + Body

            {
                "nome" : "lucas",
                "cpf" : "12345678911",
                "data_nascimento" : "2021-05-05"
            }

+ Response 201 (application/json)

    + Body

            {
                "nome" : "lucas 2",
                "cpf" : "987654321087",
                "data_nascimento" : "2005-05-05",
                "updated_at": "2021-09-07T13:16:35.000000Z",
                "created_at": "2021-09-07T13:16:35.000000Z",
                "id": 1
            }

## ➡️ Remover usuário /api/usuarios/{usuarioId} [`DELETE`]

Em caso de sucesso é retornado o ``StatusCode 204 (Not Content)``

## ⚠️  Casos de Erro ️
___

Se o ``usuarioId`` informado não existir é retornado o ``StatusCode 404`` com o response abaixo:

+ Response 404 (application/json)
    + Body
    
            {
                "erro": "Recurso não encontrado"
            }

# Contas

## ➡️ Cadastrar Conta /api/contas [`POST`]

| Parâmetro | Tipo |  Descrição |
|---|---|---|
| `usuarios_id` | `integer` | código de identificação do usuário |
| `tipo_conta_id`  | `integer` | ``1 - CONTA CORRENTE`` ou ``2 - CONTA POUPANÇA`` |
| `saldo`  | `integer` | saldo inicial da conta |

+ Requisição (application/json)

    + Body
    
            {
                "usuarios_id" : 1,
                "tipo_conta_id" : 2,
                "saldo" : 0
            }

+ Response 201 (application/json)

    + Body

            {
                "usuarios_id": 1,
                "tipo_conta_id": 2,
                "saldo": 0,
                "updated_at": "2021-09-07T13:52:53.000000Z",
                "created_at": "2021-09-07T13:52:53.000000Z",
                "id": 19
            }

## ➡️ Listar Contas /api/contas [`GET`]    

Será retornando todos as contas do banco de dados de forma paginada ``15 / per_page``.

+ Response 200 (application/json)

    + body example

            {
            "current_page": 1,
            "data": ["
                  {
                      "id": 1,
                      "usuarios_id": 2,
                      "tipo_conta_id": 2,
                      "saldo": 6220,
                      "created_at": "2021-09-04T19:16:01.000000Z",
                      "updated_at": "2021-09-07T03:40:45.000000Z"
                  },
            "first_page_url": "http://localhost:8080/api/usuarios?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost:8080/api/usuarios?page=1",
            "links": [
              {
                  "url": null,
                  "label": "pagination.previous",
                  "active": false
              },
              {
                  "url": "http://localhost:8080/api/usuarios?page=1",
                  "label": "1",
                  "active": true
              },
              {
                  "url": null,
                  "label": "pagination.next",
                  "active": false
              }
            ],
            "next_page_url": null,
            "path": "http://localhost:8080/api/usuarios",
            "per_page": 15,
            "prev_page_url": null,
            "to": 14,
            "total": 14
            }

## ➡️ Consultar única conta /api/usuarios/{contaId} [`GET`]


+ Response 200 (application/json)

    + body example

          {
              "id": 1,
              "usuarios_id": 2,
              "tipo_conta_id": 2,
              "saldo": 6220,
              "created_at": "2021-09-04T19:16:01.000000Z",
              "updated_at": "2021-09-07T03:40:45.000000Z"
          }

## ⚠️  Casos de Erro ️
Em caso de a contaId não existir é retornado o ``StatusCode 204 (Not Content)``

# Operações 

## ➡️ Depósito na conta /api/deposito [`POST`]


| Parâmetro | Tipo |  Descrição |
|---|---|---|
| `contas_id` | `integer` | código de identificação da conta |
| `valor`  | `integer` | valor para depósito |

+ Requisição (application/json)

    + Body

            {
                "contas_id" : 1,
                "valor" : 1500
            }

+ Response 200 (application/json)

    + Body
        
            {
                "contas_id": 1,
                "conta_destino_id": null,
                "tipo": "DEPOSITO",
                "valor": 1500,
                "updated_at": "2021-09-07T16:55:46.000000Z",
                "created_at": "2021-09-07T16:55:46.000000Z",
                "id": 70
            }

## ⚠️  Casos de Erro ️

Em caso do parâmetro ``contas_id`` não existir é retornado o ``StatusCode 204 (Not Content)``

## ➡️ Saque na conta /api/saque [`POST`]


| Parâmetro | Tipo |  Descrição |
|---|---|---|
| `contas_id` | `integer` | código de identificação da conta |
| `valor`  | `integer` | valor de saque |

+ Requisição (application/json)

    + Body

            {
                "contas_id" : 1,
                "valor" : 590
            }

+ Response 200 (application/json)

    + Body

            {
                "100": 5,
                "50": 1,
                "20": 2
            }

É retornado a quantidade de notas em que o simulador do caixa eletrônico deveria disponibilizar para saque, possuindo apenas notas de R$ 100, 50 e 20.

## ⚠️  Casos de Erro 


Se o valor de saque for maior que o saldo disponível é retornado o ``StatusCode 400 (Bad Request)`` com o response:

+ Response 400 (application/json)

    + Body

            {
                "erro": "Não foi possivel realizar esta operação: saldo insuficiente"
            }

Se for realizar a tentativa de saque de valores fracionados (exemplo: R$ 25,35,45) é retornado:

+ Response 400 (application/json)

    + Body

            {
                "erro": "Não foi possivel realizar esta operação"
            }

Se o saque for menor que 20 é retornado: 

+ Response 400 (application/json)

    + Body

            {
                "erro": "Não foi possivel realizar esta operação: Não hà cedulas"
            }

## ➡️ Transferência entre contas /api/transferencia [`POST`]


| Parâmetro | Tipo |  Descrição |
|---|---|---|
| `contas_id` | `integer` | código de identificação da conta |
| `contas_destino_id` | `integer` | código de identificação da conta de destino|
| `valor`  | `integer` | valor da transferência |

+ Requisição (application/json)

    + Body

            {
              "contas_id" : 1,
              "contas_destino_id" : 2,
              "valor" : 1500
            }

+ Response 200 (application/json)

    + Body
    
              {
                  "contas_id": 1,
                  "conta_destino_id": 2,
                  "tipo": "TRANSFERENCIA",
                  "valor": 1500,
                  "updated_at": "2021-09-07T17:06:48.000000Z",
                  "created_at": "2021-09-07T17:06:48.000000Z",
                  "id": 74
              }


## ⚠️  Casos de Erro ️
Se o valor da transferência for maior que o saldo disponível é retornado o ``StatusCode 400 (Bad Request)`` com o response:

+ Response 400 (application/json)

    + Body

            {
                "erro": "Não foi possivel realizar esta operação: saldo insuficiente"
            }

Se a conta de destino for inválida é retornado  ``StatusCode 400 (Bad Request)`` com o response:

+ Response 400 (application/json)

    + Body

            {
                "erro": "Não foi possivel realizar esta operação: Conta de destino é inválida"
            }


## ➡️ Extrato da conta /api/extrato/{contas_id} [`GET`] 


| Parâmetro da url | Tipo |  Descrição |
|---|---|---|
| `operacao` | `string` | ``deposito`` / ``saque`` / ``transferencia`` |
| `data_inicio` | `date` | data de início formatada em Y-m-d|
| `data_final`  | `date` | data final formatada em Y-m-d |

+ Requisição (application/json)

    + URL Example

            http://localhost:8080/api/extrato/1/?operacao=saque&dataInicio=2021-04-08&dataFinal=2021-09-08
    
+ Response 200 (application/json)

    + Body

            {
            "current_page": 1,
            "data": [
              {
                  "id": 72,
                  "contas_id": 1,
                  "conta_destino_id": null,
                  "tipo": "SAQUE",
                  "valor": 590,
                  "created_at": "2021-09-07T16:58:22.000000Z",
                  "updated_at": "2021-09-07T16:58:22.000000Z"
              },
              {
                  "id": 71,
                  "contas_id": 1,
                  "conta_destino_id": null,
                  "tipo": "SAQUE",
                  "valor": 50,
                  "created_at": "2021-09-07T16:58:13.000000Z",
                  "updated_at": "2021-09-07T16:58:13.000000Z"
              },
            "first_page_url": "http://localhost:8080/api/usuarios?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost:8080/api/usuarios?page=1",
            "links": [
              {
                  "url": null,
                  "label": "pagination.previous",
                  "active": false
              },
              {
                  "url": "http://localhost:8080/api/usuarios?page=1",
                  "label": "1",
                  "active": true
              },
              {
                  "url": null,
                  "label": "pagination.next",
                  "active": false
              }
            ],
            "next_page_url": null,
            "path": "http://localhost:8080/api/usuarios",
            "per_page": 15,
            "prev_page_url": null,
            "to": 14,
            "total": 14
            }

É possível filtrar os extratos das contas através da ``operação`` e entre ``datas``. Caso queira exibir todos os tipos de transações de todas as datas, passar apenas o paramêtro ``contas_id`` exemplo:
``http://localhost:8080/api/extrato/1``
os extratos são retornados de forma paginadas.

## ⚠️  Casos de Erro ️

Caso a conta não exista é retornado um ``StatusCode 204 (Not Content)``

# 🧪 Testes

1. Para rodar os testes precisamos executar o comando para acessar o terminal do container:

     ```
    docker exec -it api_php /bin/bash
     ```

2. Rodar comando do PHPUnit

    ```
    ./vendor/phpunit/phpunit/phpunit
     ```
