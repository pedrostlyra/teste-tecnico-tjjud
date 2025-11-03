# Decisões Técnicas e Arquiteturais

Este documento detalha as decisões técnicas, escolhas de tecnologias e justificativas arquiteturais do projeto Sistema de Cadastro de Livros.

## 📋 Sumário

- [Filosofia do Projeto](#filosofia-do-projeto)
- [Stack Tecnológico](#stack-tecnológico)
- [Arquitetura](#arquitetura)
- [Decisões de Banco de Dados](#decisões-de-banco-de-dados)
- [Padrões de Código](#padrões-de-código)
- [Testes](#testes)
- [Segurança](#segurança)
- [Performance](#performance)
- [Escalabilidade](#escalabilidade)

---

## 🎯 Filosofia do Projeto

### Objetivo Principal

Desenvolver um sistema web completo para gerenciamento de livros, autores e assuntos, seguindo boas práticas de desenvolvimento e padrões modernos do Laravel.

### Princípios Adotados

1. **Simplicidade**: Solução direta e manutenível, sem over-engineering
2. **Padrões Laravel**: Seguir convenções do framework
3. **Testabilidade**: Código testável com cobertura adequada
4. **Manutenibilidade**: Código limpo e bem documentado

---

## 🛠️ Stack Tecnológico

### Framework: Laravel 12

**Decisão**: Utilizar Laravel como framework principal

**Justificativas**:
- ✅ Framework maduro e amplamente utilizado
- ✅ Ecossistema rico com pacotes e ferramentas
- ✅ Documentação extensa e comunidade ativa
- ✅ Convenções que aceleram desenvolvimento
- ✅ ORM Eloquent poderoso e intuitivo
- ✅ Sistema de rotas e middlewares robusto
- ✅ Validação integrada e elegante
- ✅ Suporte nativo a testes

**Alternativas Consideradas**:
- **Symfony**: Mais verboso, curva de aprendizado maior
- **CodeIgniter**: Menos moderno, menor ecossistema
- **Framework próprio**: Desnecessário para o escopo

### Linguagem: PHP 8.2

**Decisão**: PHP 8.2 como versão mínima

**Justificativas**:
- ✅ Performance melhorada (JIT compiler)
- ✅ Tipos mais robustos (Union Types, Match Expression)
- ✅ Melhor suporte a async
- ✅ Compatibilidade com Laravel 12

### Banco de Dados: MariaDB 10.11

**Decisão**: MariaDB ao invés de MySQL

**Justificativas**:
- ✅ 100% compatível com MySQL
- ✅ Open source e comunidade ativa
- ✅ Performance similar ou superior
- ✅ Melhor suporte a features modernas
- ✅ Versão estável e testada

**Alternativas Consideradas**:
- **MySQL**: Similar, mas MariaDB tem melhor suporte comunitário
- **PostgreSQL**: Mais robusto, mas requer mais configuração
- **SQLite**: Não adequado para produção com relacionamentos complexos

### Containerização: Docker

**Decisão**: Docker Compose para ambiente de desenvolvimento

**Justificativas**:
- ✅ Ambiente isolado e reproduzível
- ✅ Fácil setup para novos desenvolvedores
- ✅ Consistência entre ambientes
- ✅ Fácil deploy em produção
- ✅ Não polui máquina local com dependências

### Servidor Web: Nginx

**Decisão**: Nginx ao invés de Apache

**Justificativas**:
- ✅ Performance superior para conteúdo estático
- ✅ Configuração mais simples
- ✅ Melhor uso de recursos
- ✅ Amplamente usado em produção Laravel
- ✅ Suporte nativo a PHP-FPM

---

## 🏗️ Arquitetura

### Padrão MVC (Model-View-Controller)

**Decisão**: Seguir padrão MVC do Laravel

**Estrutura**:
- **Models**: `app/Models/` - Lógica de negócio e relacionamentos
- **Views**: `resources/views/` - Templates Blade
- **Controllers**: `app/Http/Controllers/` - Lógica de controle

**Justificativas**:
- ✅ Padrão nativo do Laravel
- ✅ Separação clara de responsabilidades
- ✅ Fácil manutenção e escalabilidade
- ✅ Testabilidade

### Separação Web vs API

**Decisão**: Remover controllers API, manter apenas web

**Justificativas**:
- ✅ Requisito era apenas CRUD web simples
- ✅ Reduz complexidade desnecessária
- ✅ Menos código para manter
- ✅ Foco em funcionalidade core

**Quando seria necessário API**:
- Integração com mobile apps
- SPA (Single Page Application)
- Integração com sistemas externos
- Microserviços

### Form Requests para Validação

**Decisão**: Usar FormRequest classes ao invés de validação inline

**Justificativas**:
- ✅ Separação de responsabilidades
- ✅ Reutilização de regras
- ✅ Mensagens customizadas
- ✅ Preparação de dados (prepareForValidation)
- ✅ Testabilidade

**Estrutura**:
```php
app/Http/Requests/
├── LivroRequest.php    # Validação de livros
├── AutorRequest.php    # Validação de autores
└── AssuntoRequest.php  # Validação de assuntos
```

### Factories para Testes

**Decisão**: Criar factories para todos os models

**Justificativas**:
- ✅ Geração rápida de dados de teste
- ✅ Manutenção fácil
- ✅ Dados realistas
- ✅ Padrão Laravel

---

## 🗄️ Decisões de Banco de Dados

### Nomenclatura de Colunas

**Decisão**: Usar PascalCase para colunas (ex: `Codl`, `Titulo`, `AnoPublicacao`)

**Justificativas**:
- ✅ Mantém compatibilidade com estrutura existente
- ✅ Convenção do projeto legado
- ✅ Evita necessidade de refatoração

**Alternativa Considerada**:
- **snake_case**: Mais comum no Laravel, mas quebraria compatibilidade

### Chaves Primárias Customizadas

**Decisão**: Usar chaves primárias não-convencionais (`Codl`, `CodAu`, `CodAs`)

**Justificativas**:
- ✅ Compatibilidade com estrutura existente
- ✅ Laravel suporta via `$primaryKey`
- ✅ Evita breaking changes

### Relacionamentos Many-to-Many

**Decisão**: Usar tabelas pivot com nomes explícitos (`livro_autor`, `livro_assunto`)

**Justificativas**:
- ✅ Clareza na estrutura
- ✅ Fácil manutenção
- ✅ Nomes descritivos
- ✅ Suporte a chaves estrangeiras customizadas

### Views para Relatórios

**Decisão**: Criar view `vw_livros_autores_assuntos` no banco de dados

**Justificativas**:
- ✅ Performance: agregação no banco
- ✅ Reutilização: múltiplos relatórios podem usar
- ✅ Consistência: dados sempre atualizados
- ✅ Compatibilidade: ReportViewer/Crystal Reports podem usar diretamente

**Estrutura da View**:
```sql
CREATE VIEW vw_livros_autores_assuntos AS
SELECT 
    l.codl AS livro_id,
    l.titulo, l.editora, l.edicao, l.anopublicacao, l.valor,
    a.nome AS autor,
    s.descricao AS assunto
FROM livros l
LEFT JOIN livro_autor la ON la.livro_codl = l.codl
LEFT JOIN autores a ON a.codau = la.autor_codau
LEFT JOIN livro_assunto ls ON ls.livro_codl = l.codl
LEFT JOIN assuntos s ON s.codas = ls.assunto_codas;
```

### Triggers para Auditoria

**Decisão**: Implementar trigger `trg_update_valor_log`

**Justificativas**:
- ✅ Auditoria automática
- ✅ Rastreabilidade de mudanças
- ✅ Implementado no banco (performance)
- ✅ Não requer mudanças no código

### Stored Procedures

**Decisão**: Criar procedure `sp_livros_por_autor`

**Justificativas**:
- ✅ Performance para consultas complexas
- ✅ Reutilização
- ✅ Disponível para ReportViewer
- ✅ Abstração de lógica de negócio

---

## 📝 Padrões de Código

### Convenções de Nomenclatura

**Models**: PascalCase singular
- `Livro`, `Autor`, `Assunto`

**Controllers**: PascalCase com sufixo `Controller`
- `LivroController`, `AutorController`

**Routes**: kebab-case
- `/livros`, `/autores`, `/relatorio`

**Methods**: camelCase
- `index()`, `create()`, `store()`, `update()`

### Validação

**Decisão**: Validação em FormRequest classes

**Estrutura**:
```php
public function rules(): array {
    return [
        'campo' => 'required|string|max:40',
    ];
}

public function messages(): array {
    return [
        'campo.required' => 'Mensagem customizada',
    ];
}
```

**Justificativas**:
- ✅ Centralização de regras
- ✅ Mensagens customizadas em português
- ✅ Preparação de dados (ex: formatação de moeda)

### Tratamento de Erros

**Decisão**: Try-catch em controllers críticos

**Justificativas**:
- ✅ Logs apropriados
- ✅ Mensagens amigáveis ao usuário
- ✅ Rastreabilidade de erros

**Estrutura**:
```php
try {
    // Operação
} catch (QueryException $e) {
    \Log::error('DB Error: ' . $e->getMessage());
    return response()->json(['erro' => 'Erro ao acessar banco'], 500);
} catch (\Exception $e) {
    \Log::error('Unexpected Error: ' . $e->getMessage());
    return response()->json(['erro' => 'Erro inesperado'], 500);
}
```

### Transações de Banco

**Decisão**: Usar transações em operações complexas

**Justificativas**:
- ✅ Integridade de dados
- ✅ Rollback automático em caso de erro
- ✅ Consistência

**Onde usado**:
- `store()` e `update()` em controllers
- Operações que modificam múltiplas tabelas

---

## 🧪 Testes

### Framework: PHPUnit

**Decisão**: PHPUnit (padrão Laravel)

**Justificativas**:
- ✅ Integrado ao Laravel
- ✅ Familiar para desenvolvedores PHP
- ✅ Suporte completo a recursos Laravel
- ✅ Documentação extensa

### Estratégia de Testes

**Decisão**: Testes unitários + testes de feature

**Estrutura**:
- **Unit Tests**: Models, Requests, lógica isolada
- **Feature Tests**: Controllers, rotas, fluxos completos

**Justificativas**:
- ✅ Cobertura completa
- ✅ Testes rápidos (unit) e integrados (feature)
- ✅ Fácil identificação de problemas

### Banco de Testes: SQLite In-Memory

**Decisão**: SQLite para testes

**Justificativas**:
- ✅ Extremamente rápido
- ✅ Não requer configuração
- ✅ Isolamento completo
- ✅ Limpeza automática

**Limitações**:
- SQLite não suporta todas as features MySQL (ex: GROUP_CONCAT com SEPARATOR)
- Views complexas são puladas em testes

### Factories

**Decisão**: Factories para todos os models

**Justificativas**:
- ✅ Geração rápida de dados
- ✅ Dados realistas
- ✅ Reutilização
- ✅ Manutenção fácil

---

## 🔒 Segurança

### Validação de Input

**Decisão**: Validação em múltiplas camadas

**Camadas**:
1. **Frontend**: HTML5 validation (UX)
2. **FormRequest**: Validação server-side (obrigatória)
3. **Database**: Constraints e tipos (última linha)

**Justificativas**:
- ✅ Defesa em profundidade
- ✅ Segurança mesmo se frontend for bypassado
- ✅ Integridade de dados

### SQL Injection

**Decisão**: Usar Eloquent ORM exclusivamente

**Justificativas**:
- ✅ Prepared statements automáticos
- ✅ Escape de parâmetros
- ✅ Type-safe queries

**Exceção**: Views e procedures (SQL raw, mas controlado)

### XSS (Cross-Site Scripting)

**Decisão**: Escaping automático do Blade

**Justificativas**:
- ✅ Proteção automática
- ✅ `{{ }}` escapa automaticamente
- ✅ `{!! !!}` apenas quando necessário

### CSRF Protection

**Decisão**: Token CSRF em todos os formulários

**Justificativas**:
- ✅ Proteção nativa do Laravel
- ✅ `@csrf` em todos os forms
- ✅ Validação automática

---

## ⚡ Performance

### Eager Loading

**Decisão**: Usar `with()` para carregar relacionamentos

**Justificativas**:
- ✅ Evita N+1 queries
- ✅ Performance significativamente melhor
- ✅ Fácil implementação

**Exemplo**:
```php
Livro::with(['autores', 'assuntos'])->get();
```

### Paginação

**Decisão**: Paginar resultados de listagens

**Justificativas**:
- ✅ Menor uso de memória
- ✅ Melhor UX
- ✅ Performance melhor

**Padrão**: 10-15 itens por página

### Cache

**Decisão**: Não implementar cache (não necessário no escopo)

**Quando seria necessário**:
- Alta concorrência
- Dados raramente atualizados
- Consultas pesadas

### Índices de Banco

**Decisão**: Usar índices padrão (chaves primárias e foreign keys)

**Justificativas**:
- ✅ Suficiente para o volume esperado
- ✅ Laravel cria índices automaticamente
- ✅ Evita otimização prematura

---

## 📈 Escalabilidade

### Arquitetura Monolítica

**Decisão**: Aplicação monolítica (não microserviços)

**Justificativas**:
- ✅ Adequado para o escopo
- ✅ Simplicidade
- ✅ Menor complexidade operacional
- ✅ Fácil manutenção

**Quando migrar para microserviços**:
- Alto volume de requisições
- Equipes separadas
- Necessidade de escalar componentes independentemente

### Banco de Dados

**Decisão**: Banco único (MariaDB)

**Justificativas**:
- ✅ Suficiente para o volume
- ✅ Simplicidade
- ✅ Transações ACID

**Estratégias de escalabilidade futura**:
- Read replicas
- Sharding (se necessário)
- Cache layer (Redis)

### Horizontal Scaling

**Decisão**: Aplicação stateless (preparada para scaling)

**Justificativas**:
- ✅ Sessões em banco/Redis (não em memória)
- ✅ Sem dependências de estado local
- ✅ Pode escalar horizontalmente facilmente

---

## 🎨 Frontend

### Template Engine: Blade

**Decisão**: Blade (nativo do Laravel)

**Justificativas**:
- ✅ Integração perfeita com Laravel
- ✅ Sintaxe limpa e expressiva
- ✅ Performance boa
- ✅ Componentes reutilizáveis

**Alternativas Consideradas**:
- **Twig**: Mais verboso
- **React/Vue**: Overkill para CRUD simples

### CSS Framework: Bootstrap 5

**Decisão**: Bootstrap 5 via CDN

**Justificativas**:
- ✅ Setup rápido
- ✅ Componentes prontos
- ✅ Responsivo
- ✅ Documentação extensa
- ✅ Não requer build step

**Alternativas Consideradas**:
- **Tailwind CSS**: Mais moderno, mas requer build
- **CSS puro**: Muito trabalho manual

### JavaScript: jQuery

**Decisão**: jQuery apenas para inputmask

**Justificativas**:
- ✅ Inputmask requer jQuery
- ✅ Código mínimo
- ✅ Funciona bem para o caso

**Alternativas Consideradas**:
- **Vanilla JS**: Mais código
- **Vue/React**: Desnecessário para máscaras

---

## 📊 Relatórios

### Geração de PDF: DomPDF

**Decisão**: DomPDF para geração de PDFs

**Justificativas**:
- ✅ Biblioteca PHP pura (sem dependências externas)
- ✅ Integração fácil com Laravel
- ✅ Templates HTML → PDF
- ✅ Suporte a CSS
- ✅ Licença permissiva

**Alternativas Consideradas**:
- **wkhtmltopdf**: Requer binário externo
- **TCPDF**: Mais complexo
- **mPDF**: Similar, mas DomPDF mais atualizado

### Estrutura de Relatórios

**Decisão**: Múltiplos formatos (PDF, XML, JSON)

**Justificativas**:
- ✅ Flexibilidade
- ✅ Compatibilidade com diferentes ferramentas
- ✅ Fácil integração

### View de Banco para Relatórios

**Decisão**: Usar view `vw_livros_autores_assuntos`

**Justificativas**:
- ✅ Performance: agregação no banco
- ✅ Reutilização
- ✅ Compatibilidade com ReportViewer
- ✅ Dados sempre atualizados

**Agregação em PHP**:
- View retorna múltiplas linhas (um por autor/assunto)
- Controller agrega em PHP com `groupBy()` e `implode()`
- Trade-off: performance vs flexibilidade

---

## 🐳 Docker

### Estratégia: Multi-container

**Decisão**: Containers separados (PHP, Nginx, MariaDB)

**Justificativas**:
- ✅ Separação de responsabilidades
- ✅ Escalabilidade independente
- ✅ Fácil manutenção
- ✅ Próximo de ambiente de produção

### PHP-FPM

**Decisão**: PHP-FPM ao invés de mod_php

**Justificativas**:
- ✅ Melhor performance
- ✅ Isolamento de processos
- ✅ Compatível com Nginx
- ✅ Padrão moderno

### Volumes

**Decisão**: Volume para código fonte

**Justificativas**:
- ✅ Hot-reload durante desenvolvimento
- ✅ Não precisa rebuild para mudanças de código
- ✅ Fácil acesso ao código

---

## 🔄 Versionamento e CI/CD

### Git

**Decisão**: Git para versionamento

**Estrutura**:
- `main`: Branch principal
- Commits descritivos
- Estrutura de pastas organizada

### CI/CD

**Decisão**: Não implementado (não no escopo)

**Quando seria necessário**:
- Múltiplos desenvolvedores
- Deploy automatizado
- Testes automáticos

**Ferramentas sugeridas**:
- GitHub Actions
- GitLab CI
- Jenkins

---

## 📚 Documentação

### README.md

**Decisão**: README completo e detalhado

**Justificativas**:
- ✅ Onboarding rápido
- ✅ Referência rápida
- ✅ Troubleshooting
- ✅ Boas práticas

### Este Documento (TECHNICAL_DECISIONS.md)

**Decisão**: Documentar decisões técnicas

**Justificativas**:
- ✅ Contexto para futuros desenvolvedores
- ✅ Justificativas de escolhas
- ✅ Alternativas consideradas
- ✅ Trade-offs

---

## 🎯 Trade-offs e Limitações

### Trade-offs Aceitos

1. **SQLite em testes**: Não suporta todas as features MySQL
   - **Solução**: Pular views complexas em testes

2. **Agregação em PHP**: Menos performático que SQL puro
   - **Justificativa**: Flexibilidade e compatibilidade

3. **Monolítico**: Não escala componentes independentemente
   - **Justificativa**: Adequado para o escopo

4. **Sem cache**: Pode ser lento com muitos dados
   - **Justificativa**: Não necessário no escopo atual

### Melhorias Futuras

1. **Cache**: Implementar Redis para consultas frequentes
2. **Queue**: Jobs assíncronos para operações pesadas
3. **API**: Se necessário para integrações
4. **Elasticsearch**: Para busca avançada
5. **CDN**: Para assets estáticos em produção

---

## ✅ Conclusão

Este projeto foi desenvolvido seguindo boas práticas do Laravel, priorizando simplicidade, manutenibilidade e testabilidade. As decisões técnicas foram tomadas considerando o escopo do projeto, mantendo a porta aberta para evoluções futuras quando necessário.

**Principais pontos fortes**:
- ✅ Arquitetura limpa e organizada
- ✅ Código testável com boa cobertura
- ✅ Documentação completa
- ✅ Ambiente Docker reproduzível
- ✅ Segurança adequada
- ✅ Performance otimizada para o escopo

---

**Documento criado em**: Novembro 2025  
**Versão do Projeto**: 1.0.0

