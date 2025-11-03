<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivroControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_livros(): void
    {
        $livro = Livro::factory()->create();

        $response = $this->get(route('livros.index'));

        $response->assertStatus(200);
        $response->assertSee($livro->Titulo);
    }

    public function test_create_displays_form(): void
    {
        Autor::factory()->count(2)->create();
        Assunto::factory()->count(2)->create();

        $response = $this->get(route('livros.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Livro');
    }

    public function test_store_creates_livro_with_valid_data(): void
    {
        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();

        $data = [
            'titulo' => 'Test Livro',
            'editora' => 'Test Editora',
            'edicao' => 1,
            'ano_publicacao' => '2024',
            'valor' => '50.00',
            'autores' => [$autor->CodAu],
            'assuntos' => [$assunto->CodAs],
        ];

        $response = $this->post(route('livros.store'), $data);

        $response->assertRedirect(route('livros.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('livros', [
            'Titulo' => 'Test Livro',
            'Editora' => 'Test Editora',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->post(route('livros.store'), []);

        $response->assertSessionHasErrors(['titulo', 'editora', 'valor']);
    }

    public function test_store_validates_titulo_max_length(): void
    {
        $data = [
            'titulo' => str_repeat('a', 41), // Exceeds max 40
            'editora' => 'Test',
            'valor' => '50.00',
        ];

        $response = $this->post(route('livros.store'), $data);

        $response->assertSessionHasErrors(['titulo']);
    }

    public function test_edit_displays_livro_form(): void
    {
        $livro = Livro::factory()->create();
        Autor::factory()->count(2)->create();
        Assunto::factory()->count(2)->create();

        $response = $this->get(route('livros.edit', $livro));

        $response->assertStatus(200);
        $response->assertSee($livro->Titulo);
    }

    public function test_update_modifies_livro(): void
    {
        $livro = Livro::factory()->create();
        $autor = Autor::factory()->create();

        $data = [
            'titulo' => 'Updated Title',
            'editora' => 'Updated Editora',
            'edicao' => 2,
            'ano_publicacao' => '2025',
            'valor' => '75.00',
            'autores' => [$autor->CodAu],
        ];

        $response = $this->put(route('livros.update', $livro), $data);

        $response->assertRedirect(route('livros.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('livros', [
            'Codl' => $livro->Codl,
            'Titulo' => 'Updated Title',
        ]);
    }

    public function test_destroy_deletes_livro(): void
    {
        $livro = Livro::factory()->create();

        $response = $this->delete(route('livros.destroy', $livro));

        $response->assertRedirect(route('livros.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('livros', ['Codl' => $livro->Codl]);
    }
}

