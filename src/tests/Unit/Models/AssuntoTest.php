<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Assunto;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssuntoTest extends TestCase
{
    use RefreshDatabase;

    public function test_assunto_belongs_to_many_livros(): void
    {
        $assunto = Assunto::factory()->create();
        $livro1 = Livro::factory()->create();
        $livro2 = Livro::factory()->create();

        $assunto->livros()->attach([$livro1->Codl, $livro2->Codl]);

        $this->assertCount(2, $assunto->livros);
        $this->assertTrue($assunto->livros->contains($livro1));
        $this->assertTrue($assunto->livros->contains($livro2));
    }

    public function test_assunto_can_be_created(): void
    {
        $assunto = Assunto::create([
            'Descricao' => 'Ficção',
        ]);

        $this->assertDatabaseHas('assuntos', [
            'CodAs' => $assunto->CodAs,
            'Descricao' => 'Ficção',
        ]);
    }

    public function test_assunto_has_fillable_attributes(): void
    {
        $assunto = new Assunto();
        $fillable = $assunto->getFillable();

        $this->assertContains('Descricao', $fillable);
    }
}

