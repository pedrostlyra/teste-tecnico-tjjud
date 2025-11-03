<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_autores(): void
    {
        $autor = Autor::factory()->create();

        $response = $this->get(route('autores.index'));

        $response->assertStatus(200);
        $response->assertSee($autor->Nome);
    }

    public function test_create_displays_form(): void
    {
        $response = $this->get(route('autores.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Autor');
    }

    public function test_store_creates_autor_with_valid_data(): void
    {
        $data = [
            'nome' => 'Test Autor',
        ];

        $response = $this->post(route('autores.store'), $data);

        $response->assertRedirect(route('autores.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('autores', [
            'Nome' => 'Test Autor',
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->post(route('autores.store'), []);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_store_validates_nome_max_length(): void
    {
        $data = [
            'nome' => str_repeat('a', 41), // Exceeds max 40
        ];

        $response = $this->post(route('autores.store'), $data);

        $response->assertSessionHasErrors(['nome']);
    }

    public function test_edit_displays_autor_form(): void
    {
        $autor = Autor::factory()->create();

        $response = $this->get(route('autores.edit', $autor));

        $response->assertStatus(200);
        $response->assertSee($autor->Nome);
    }

    public function test_update_modifies_autor(): void
    {
        $autor = Autor::factory()->create();

        $data = [
            'nome' => 'Updated Autor',
        ];

        $response = $this->put(route('autores.update', $autor), $data);

        $response->assertRedirect(route('autores.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('autores', [
            'CodAu' => $autor->CodAu,
            'Nome' => 'Updated Autor',
        ]);
    }

    public function test_destroy_deletes_autor(): void
    {
        $autor = Autor::factory()->create();

        $response = $this->delete(route('autores.destroy', $autor));

        $response->assertRedirect(route('autores.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('autores', ['CodAu' => $autor->CodAu]);
    }
}

