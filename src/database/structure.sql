-- =============================================
-- 🔍 VIEW: vw_livros_autores_assuntos
-- Descrição: Agrupa livros, autores e assuntos para uso em relatórios
-- =============================================

CREATE OR REPLACE VIEW vw_livros_autores_assuntos AS
SELECT 
    l.codl AS livro_id,
    l.titulo,
    l.editora,
    l.edicao,
    l.anopublicacao,
    l.valor,
    a.nome AS autor,
    s.descricao AS assunto
FROM livros l
LEFT JOIN livro_autor la ON la.livro_codl = l.codl
LEFT JOIN autores a ON a.codau = la.autor_codau
LEFT JOIN livro_assunto ls ON ls.livro_codl = l.codl
LEFT JOIN assuntos s ON s.codas = ls.assunto_codas;

-- =============================================
-- ⚙️ PROCEDURE: sp_livros_por_autor
-- Descrição: Retorna todos os livros de um autor específico
-- =============================================

DELIMITER $$

CREATE OR REPLACE PROCEDURE sp_livros_por_autor(IN p_autor_id INT)
BEGIN
    SELECT 
        l.titulo,
        l.editora,
        l.anopublicacao,
        l.valor
    FROM livros l
    INNER JOIN livro_autor la ON la.livro_codl = l.codl
    WHERE la.autor_codau = p_autor_id;
END$$

DELIMITER ;

-- =============================================
-- ⚠️ TRIGGER: trg_update_valor_log
-- Descrição: Cria log sempre que o valor de um livro for atualizado
-- =============================================

CREATE TABLE IF NOT EXISTS log_livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT,
    valor_antigo DECIMAL(10,2),
    valor_novo DECIMAL(10,2),
    data_alteracao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER $$

CREATE OR REPLACE TRIGGER trg_update_valor_log
BEFORE UPDATE ON livros
FOR EACH ROW
BEGIN
    IF OLD.valor <> NEW.valor THEN
        INSERT INTO log_livros (livro_id, valor_antigo, valor_novo)
        VALUES (OLD.codl, OLD.valor, NEW.valor);
    END IF;
END$$

DELIMITER ;
