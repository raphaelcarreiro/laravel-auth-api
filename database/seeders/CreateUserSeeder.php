<?php

namespace Database\Seeders;

use Core\User\Application\Dto\CreateUserInput;
use Core\User\Application\UseCases\CreateUserUseCase;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(CreateUserUseCase $usecase): void
    {
        $input = new CreateUserInput([
            'name' => 'Raphael Mendes Carreiro',
            'email' => 'raphaelcarreiro@hotmail.com',
            'password' => '123456789',
        ]);

        $usecase->execute($input);
    }
}
