# ReportViewer Implementation Guide

## Database View Information

The database view `livros_relatorio_view` is already created and contains all necessary data from the three tables (livros, autores, assuntos).

### View Structure:
- **View Name**: `livros_relatorio_view`
- **Database**: `livros_db`
- **Server**: localhost (or your Docker host IP):3306

### View Columns:
- `livro_id` - ID do livro
- `livro_titulo` - Título do livro
- `livro_editora` - Editora
- `livro_edicao` - Edição
- `livro_ano` - Ano de publicação
- `livro_valor` - Valor do livro
- `autores` - Lista de autores (concatenados)
- `assuntos` - Lista de assuntos (concatenados)

## Option 1: Standalone ReportViewer (Visual Studio / SSRS)

### Step 1: Install Required Software
1. Install Visual Studio (with ReportViewer components)
2. Or install SQL Server Reporting Services (SSRS)

### Step 2: Create Report (.rdlc file)
1. Open Visual Studio
2. Create a new Report Server Project or add Report to existing project
3. Add a new Report (.rdlc)
4. Add Data Source:
   - Type: **Database**
   - Connection String: 
     ```
     Server=localhost,3306;Database=livros_db;User Id=user;Password=userpass;Driver={MySQL ODBC 8.0 Driver};
     ```
   - Or use MySQL Connector/NET:
     ```
     Server=localhost;Port=3306;Database=livros_db;Uid=user;Pwd=userpass;
     ```

### Step 3: Design Report
1. Add Dataset pointing to `livros_relatorio_view`
2. Design table with columns:
   - Título (livro_titulo)
   - Editora (livro_editora)
   - Edição (livro_edicao)
   - Ano (livro_ano)
   - Valor (livro_valor)
   - Autores (autores)
   - Assuntos (assuntos)

### Step 4: Export or Display
- Export to PDF, Excel, etc.
- Or deploy to SSRS server for web access

## Option 2: Use XML Data Source (Remote Processing)

The Laravel application provides an XML endpoint that ReportViewer can consume:

### Step 1: Get XML Data URL
- **URL**: `http://your-domain/relatorio/xml`
- This endpoint returns data in XML format that ReportViewer can use as a remote data source

### Step 2: Configure ReportViewer
1. In your Report (.rdlc), add a new Data Source
2. Select **XML** as data source type
3. Enter the URL: `http://your-domain/relatorio/xml`
4. Map the XML elements to your report fields

### Step 3: Design Report
The XML structure is:
```xml
<ReportData>
  <Livros>
    <Livro>
      <Id>...</Id>
      <Titulo>...</Titulo>
      <Editora>...</Editora>
      <Edicao>...</Edicao>
      <Ano>...</Ano>
      <Valor>...</Valor>
      <Autores>...</Autores>
      <Assuntos>...</Assuntos>
    </Livro>
  </Livros>
</ReportData>
```

## Option 3: Embedded ReportViewer in Web

For embedding ReportViewer in the web application, you would need:
1. SSRS Server running
2. Report deployed to SSRS
3. ReportViewer control embedded via iframe or JavaScript

Alternatively, use the JSON endpoint (`/relatorio/json`) with a JavaScript-based report viewer library.

## Database Connection Details

```
Host: localhost (or Docker host IP)
Port: 3306
Database: livros_db
Username: user
Password: userpass
Driver: MySQL/MariaDB
```

## Testing the View

You can test the view with this SQL:
```sql
SELECT * FROM livros_relatorio_view LIMIT 10;
```

