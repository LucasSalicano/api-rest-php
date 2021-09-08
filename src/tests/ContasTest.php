<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ContasTest extends TestCase
{
    use DatabaseTransactions;

    private \Faker\Generator $faker;
    private array $dados = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker\Factory::create('pt_BR');

        $usuarioData = [
            "nome" => $this->faker->name,
            "cpf" => $this->faker->cpf(false),
            "data_nascimento" => $this->faker->date
        ];

        $usuarioRequest = $this->post('/api/usuarios', $usuarioData);

        $this->dados = [
            "usuarios_id" => $usuarioRequest->response->json('id'),
            "tipo_conta_id" => 1,
            "saldo" => $this->faker->randomNumber(3)
        ];
    }

    public function testIndexContas()
    {
        $this->get('/api/contas')
            ->seeStatusCode(200)
            ->seeJson();
    }

    public function testStoreContas()
    {
        $this->post('/api/contas', $this->dados)
            ->seeStatusCode(201)
            ->seeInDatabase('contas', $this->dados)
            ->seeJsonStructure([
                'usuarios_id',
                'tipo_conta_id',
                'saldo'
            ]);
    }

    public function testShowContaId()
    {
        $request = $this->post('/api/contas', $this->dados);
        $this->get("/api/contas/{$request->response->json('id')}")
            ->seeStatusCode(200)
            ->seeJsonContains($this->dados);
    }
}
