<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    public function test_livro_belongs_to_many_autores(): void
    {
        $livro = Livro::factory()->create();
        $autor1 = Autor::factory()->create();
        $autor2 = Autor::factory()->create();

        $livro->autores()->attach([$autor1->CodAu, $autor2->CodAu]);

        $this->assertCount(2, $livro->autores);
        $this->assertTrue($livro->autores->contains($autor1));
        $this->assertTrue($livro->autores->contains($autor2));
    }

    public function test_livro_belongs_to_many_assuntos(): void
    {
        $livro = Livro::factory()->create();
        $assunto1 = Assunto::factory()->create();
        $assunto2 = Assunto::factory()->create();

        $livro->assuntos()->attach([$assunto1->CodAs, $assunto2->CodAs]);

        $this->assertCount(2, $livro->assuntos);
        $this->assertTrue($livro->assuntos->contains($assunto1));
        $this->assertTrue($livro->assuntos->contains($assunto2));
    }

    public function test_livro_can_be_created_with_required_fields(): void
    {
        $livro = Livro::create([
            'Titulo' => 'Test Book',
            'Editora' => 'Test Publisher',
            'Edicao' => 1,
            'AnoPublicacao' => '2024',
            'Valor' => 50.00,
        ]);

        $this->assertDatabaseHas('livros', [
            'Codl' => $livro->Codl,
            'Titulo' => 'Test Book',
            'Editora' => 'Test Publisher',
            'Valor' => 50.00,
        ]);
    }

    public function test_livro_has_fillable_attributes(): void
    {
        $livro = new Livro();
        $fillable = $livro->getFillable();

        $this->assertContains('Titulo', $fillable);
        $this->assertContains('Editora', $fillable);
        $this->assertContains('Edicao', $fillable);
        $this->assertContains('AnoPublicacao', $fillable);
        $this->assertContains('Valor', $fillable);
    }
}

