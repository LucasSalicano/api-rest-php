<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UsuariosTest extends TestCase
{
    use DatabaseTransactions;

    private \Faker\Generator $faker;
    private array $dados = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker\Factory::create('pt_BR');

        $this->dados = [
            "nome" => $this->faker->name,
            "cpf" => $this->faker->cpf(false),
            "data_nascimento" => $this->faker->date
        ];
    }

    public function testIndexUsuario()
    {
        $this->get('api/usuarios')
            ->seeStatusCode(200)
            ->isJson();
    }

    public function testStoreUsuario()
    {
        $this->post('/api/usuarios', $this->dados)
            ->seeStatusCode(201)
            ->seeInDatabase('usuarios', $this->dados)
            ->seeJsonStructure(
                [
                    'nome',
                    'cpf',
                    'data_nascimento',
                    'created_at',
                    'updated_at',
                    'id'
                ]
            );
    }

    public function testStoreUsuarioValidacaoCpfDuplicado()
    {
        $this->post('/api/usuarios', $this->dados);

        $this->post('/api/usuarios', $this->dados)
            ->seeStatusCode(400)
            ->seeJsonEquals([
                "erro" => "Já existe um usuário com o mesmo CPF cadastrado."
            ]);
    }

    public function testStoreUsuarioValidacaoCpfInvalido()
    {
        $this->dados["cpf"] = "123456";

        $this->post('/api/usuarios', $this->dados);

        $this->post('/api/usuarios', $this->dados)
            ->seeStatusCode(400)
            ->seeJsonEquals([
                "erro" => "O CPF informado é inválido."
            ]);
    }

    public function testShowUsuario()
    {
        $request = $this->post('/api/usuarios', $this->dados);

        $this->get("/api/usuarios/{$request->response->json('id')}")
            ->seeStatusCode(200)
            ->seeInDatabase('usuarios', $this->dados)
            ->seeJsonStructure(
                [
                    'nome',
                    'cpf',
                    'data_nascimento',
                    'created_at',
                    'updated_at',
                ]
            );
    }

    public function testPutUsuario()
    {
        $novosDados = [
            "nome" => $this->faker->name,
            "cpf" => $this->faker->cpf(false),
            "data_nascimento" => $this->faker->date
        ];

        $request = $this->post('/api/usuarios', $this->dados);
        $this->put("/api/usuarios/{$request->response->json('id')}", $novosDados)
            ->seeStatusCode(200)
            ->seeInDatabase('usuarios', $novosDados)
            ->notSeeInDatabase('usuarios', $this->dados);
    }

    public function testDeleteUsuario()
    {
        $request = $this->post('/api/usuarios', $this->dados);

        $this->delete("/api/usuarios/{$request->response->json('id')}")
            ->seeStatusCode(204)
            ->notSeeInDatabase('usuarios', $this->dados);
    }
}
