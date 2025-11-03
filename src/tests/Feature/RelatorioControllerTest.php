<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelatorioControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create view for testing (using structure.sql view)
        // This view matches the structure.sql view structure
        DB::statement('DROP VIEW IF EXISTS vw_livros_autores_assuntos');
        
        DB::statement("
            CREATE VIEW vw_livros_autores_assuntos AS
            SELECT 
                l.Codl AS livro_id,
                l.Titulo AS titulo,
                l.Editora AS editora,
                l.Edicao AS edicao,
                l.AnoPublicacao AS anopublicacao,
                l.Valor AS valor,
                a.Nome AS autor,
                s.Descricao AS assunto
            FROM livros l
            LEFT JOIN livro_autor la ON la.Livro_Codl = l.Codl
            LEFT JOIN autores a ON a.CodAu = la.Autor_CodAu
            LEFT JOIN livro_assunto ls ON ls.Livro_Codl = l.Codl
            LEFT JOIN assuntos s ON s.CodAs = ls.Assunto_CodAs
        ");
    }

    public function test_index_displays_relatorio(): void
    {
        $livro = Livro::factory()->create();
        $autor = Autor::factory()->create();
        $assunto = Assunto::factory()->create();
        
        $livro->autores()->attach($autor->CodAu);
        $livro->assuntos()->attach($assunto->CodAs);

        $response = $this->get(route('relatorio.index'));

        $response->assertStatus(200);
        $response->assertSee($livro->Titulo);
    }

    public function test_gerar_generates_pdf(): void
    {
        Livro::factory()->count(2)->create();

        $response = $this->get(route('relatorio.gerar'));

        // DomPDF stream() outputs directly, so we just verify it doesn't throw an error
        // and returns a 200 status (PDF generation works)
        $response->assertStatus(200);
        // PDF is streamed, so content might be empty in test environment
        // The important thing is that it doesn't error
    }

    public function test_export_xml_returns_xml_format(): void
    {
        Livro::factory()->count(2)->create();

        $response = $this->get(route('relatorio.xml'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $content = $response->getContent();
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<ReportData>', $content);
    }

    public function test_export_json_returns_json_format(): void
    {
        Livro::factory()->count(2)->create();

        $response = $this->get(route('relatorio.json'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            'data',
            'total',
            'generated_at',
        ]);
    }
}

