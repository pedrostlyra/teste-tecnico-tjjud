<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    public function test_autor_belongs_to_many_livros(): void
    {
        $autor = Autor::factory()->create();
        $livro1 = Livro::factory()->create();
        $livro2 = Livro::factory()->create();

        $autor->livros()->attach([$livro1->Codl, $livro2->Codl]);

        $this->assertCount(2, $autor->livros);
        $this->assertTrue($autor->livros->contains($livro1));
        $this->assertTrue($autor->livros->contains($livro2));
    }

    public function test_autor_can_be_created(): void
    {
        $autor = Autor::create([
            'Nome' => 'Test Author',
        ]);

        $this->assertDatabaseHas('autores', [
            'CodAu' => $autor->CodAu,
            'Nome' => 'Test Author',
        ]);
    }

    public function test_autor_has_fillable_attributes(): void
    {
        $autor = new Autor();
        $fillable = $autor->getFillable();

        $this->assertContains('Nome', $fillable);
    }
}

