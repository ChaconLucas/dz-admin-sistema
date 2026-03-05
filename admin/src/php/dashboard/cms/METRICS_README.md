# Sistema de Métricas da Empresa - CMS D&Z

## 📊 Visão Geral

Sistema completo de gerenciamento das métricas exibidas na HOME do site (ex: "98% - Clientes satisfeitas", "50k+ - Produtos vendidos").

## 🗄️ Estrutura do Banco de Dados

### Tabela: `cms_home_metrics`

```sql
CREATE TABLE cms_home_metrics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor VARCHAR(20) NOT NULL,        -- Ex: "98%", "50k+", "4.9", "24h"
    label VARCHAR(60) NOT NULL,        -- Ex: "Clientes satisfeitas"
    tipo ENUM('texto','numero','percentual') DEFAULT 'texto',
    ordem INT DEFAULT 0,               -- Ordem de exibição
    ativo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Índices:**

- `idx_ativo` - Performance na busca de métricas ativas
- `idx_ordem` - Facilita ordenação

## 🚀 Setup Inicial

### 1. Criar a Tabela

Acesse via navegador:

```
/admin/src/php/dashboard/cms/setup_metrics.php
```

Ou execute manualmente:

```
/admin/src/php/dashboard/cms/create_metrics_table.sql
```

### 2. Dados Iniciais

O setup já insere 4 métricas padrão:

- 98% - Clientes satisfeitas
- 50k+ - Produtos vendidos
- 4.9 - Avaliação média
- 24h - Entrega rápida

## 📁 Arquivos Modificados/Criados

### Criados:

1. `/admin/src/php/dashboard/cms/create_metrics_table.sql` - Schema SQL
2. `/admin/src/php/dashboard/cms/setup_metrics.php` - Script de setup

### Modificados:

1. `/admin/src/php/dashboard/cms/cms_api.php` - Adicionadas 5 actions
2. `/admin/src/php/dashboard/cms/metrics.php` - Implementação completa do CRUD
3. `/cliente/cms_data_provider.php` - Método `getActiveMetrics()`
4. `/cliente/index.php` - Renderização dinâmica das métricas

## 🔌 API Endpoints

### 1. Listar Métricas

```
POST cms_api.php?action=list_metrics

Response:
{
  "success": true,
  "items": [...],
  "counts": {
    "active": 3,
    "total": 4
  }
}
```

### 2. Adicionar Métrica

```
POST cms_api.php
action=add_metric
valor=99%
label=Satisfação garantida
tipo=percentual
ordem=5
ativo=1

Response:
{
  "success": true,
  "message": "Métrica criada com sucesso!",
  "id": 5
}
```

### 3. Atualizar Métrica

```
POST cms_api.php
action=update_metric
id=1
valor=99%
label=Clientes satisfeitas
tipo=percentual
ordem=1
ativo=1
```

### 4. Ativar/Desativar

```
POST cms_api.php
action=toggle_metric
id=1

Response:
{
  "success": true,
  "ativo": false
}
```

### 5. Excluir Métrica

```
POST cms_api.php
action=delete_metric
id=1
```

## 🎨 Funcionalidades da Interface Admin

**Página:** `/admin/src/php/dashboard/cms/metrics.php`

### Cards do Topo

- **Métricas Ativas:** Contagem de métricas com `ativo = 1`
- **Total Cadastradas:** Total de métricas no banco

### Listagem

Tabela com colunas:

- Valor (destaque visual)
- Descrição
- Tipo (badge colorido)
- Ordem
- Status (Ativa/Inativa)
- Ações (Editar, Toggle, Excluir)

### Modal de Criação/Edição

Campos:

- **Valor** (obrigatório, max 20 chars)
- **Descrição** (obrigatório, max 60 chars)
- **Tipo** (select: texto/numero/percentual)
- **Ordem** (number, default 0)
- **Métrica Ativa** (checkbox)

### Estados da Página

1. **Loading:** Spinner enquanto carrega
2. **Vazio:** Mensagem amigável se não houver métricas
3. **Setup Needed:** Botão para criar tabela se não existir
4. **Com Dados:** Tabela completa com ações

## 🌐 Integração no Site do Cliente

### CMSProvider - Novo Método

```php
// cliente/cms_data_provider.php
public function getActiveMetrics() {
    // Busca métricas com ativo = 1
    // Ordenadas por: ordem ASC, id ASC
    // Retorna: array de métricas
}
```

### Uso no index.php

```php
<?php
// Buscar métricas
$metricas = $cms->getActiveMetrics();

// Renderizar dinamicamente
if (!empty($metricas)):
    foreach ($metricas as $metrica): ?>
        <div class="fade-in-up">
            <div><?php echo htmlspecialchars($metrica['valor']); ?></div>
            <p><?php echo htmlspecialchars($metrica['label']); ?></p>
        </div>
    <?php endforeach;
endif;
?>
```

## 🔒 Segurança

### Validações Implementadas:

- ✅ Prepared statements (MySQLi)
- ✅ Limite de caracteres (valor: 20, label: 60)
- ✅ Tipo ENUM validado (texto|numero|percentual)
- ✅ Verificação de sessão (admin only)
- ✅ Sanitização HTML na exibição (`htmlspecialchars`)
- ✅ Try-catch com mensagens de erro amigáveis

### Tratamento de Erros:

- Se tabela não existir: exibe botão de setup
- Se API falhar: alerta JavaScript com mensagem
- Erros SQL: logged e retornados em JSON

## 📝 Exemplos de Uso

### Criar Métrica de Texto

```
Valor: 24h
Label: Entrega expressa
Tipo: texto
```

### Criar Métrica Percentual

```
Valor: 98%
Label: Satisfação dos clientes
Tipo: percentual
```

### Criar Métrica Numérica

```
Valor: 4.9
Label: Avaliação média na loja
Tipo: numero
```

## 🎯 Boas Práticas

1. **Ordenação:** Use números sequenciais (1, 2, 3, 4) para facilitar
2. **Valores Curtos:** Mantenha valores concisos (max 20 chars)
3. **Labels Descritivas:** Use descrições claras e objetivas
4. **Ativas:** Mantenha apenas 3-5 métricas ativas para não poluir a página
5. **Tipos:** Use tipos corretos para manter consistência semântica

## 🔄 Atualizações Dinâmicas

- ✅ Modal abre/fecha sem recarregar
- ✅ Adicionar/Editar atualiza tabela via AJAX
- ✅ Toggle ativa/inativa em tempo real
- ✅ Excluir com confirmação
- ✅ Contadores atualizados automaticamente
- ✅ Site cliente atualiza ao recarregar página

## 🐛 Troubleshooting

### Tabela não existe

**Solução:** Acesse `setup_metrics.php` e execute o setup

### Métricas não aparecem no site

**Possíveis causas:**

1. Métricas estão inativas (verifique campo `ativo`)
2. Cache do navegador (Ctrl+F5)
3. Erro na query (verifique logs PHP)

### API retorna erro 500

**Verificar:**

1. Conexão com banco (`conexao.php`)
2. Tabela criada corretamente
3. Logs em `cms_api_errors.log`

## 📊 Estatísticas da Implementação

- **Arquivos Criados:** 2
- **Arquivos Modificados:** 4
- **Endpoints API:** 5
- **Linhas de Código:** ~600
- **Validações:** 7
- **Features:** CRUD completo + Toggle + Ordenação

---

**Desenvolvido seguindo os padrões do CMS D&Z**
**Mantém identidade visual e arquitetura existente**
