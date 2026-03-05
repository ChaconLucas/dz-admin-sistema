# Sistema de Promoções e Ofertas - CMS

## ✅ Implementação Completa

O sistema de gerenciamento de promoções foi implementado com sucesso!

## 📋 Arquivos Criados/Modificados

### Novos Arquivos

- `cms/setup_promotions.php` - Script para criar a tabela no banco
- `cms/create_promotions_table.sql` - SQL da estrutura da tabela

### Arquivos Modificados

- `cms/promos.php` - Página funcional completa
- `cms/cms_api.php` - Adicionados 6 novos endpoints

## 🚀 Como Usar

### 1. Criar a Tabela no Banco de Dados

Acesse via navegador:

```
http://localhost/admin-teste/admin/src/php/dashboard/cms/setup_promotions.php
```

OU execute manualmente o SQL:

```
admin/src/php/dashboard/cms/create_promotions_table.sql
```

### 2. Acessar o Sistema

Acesse:

```
http://localhost/admin-teste/admin/src/php/dashboard/cms/promos.php
```

## 🎯 Funcionalidades Implementadas

### ✓ Listar Promoções

- Tabela com todas as promoções
- Exibe título, cupom vinculado, período, ordem e status
- Mensagem quando não há promoções

### ✓ Criar Nova Promoção

- Modal com formulário completo
- Campos: título, subtítulo, badge, cupom, botão, datas, ordem
- Validação de campos obrigatórios
- Seleção de cupons ativos do sistema

### ✓ Editar Promoção

- Mesma interface do criar
- Carrega dados existentes
- Atualiza sem recarregar página

### ✓ Ativar/Desativar

- Toggle rápido do status
- Atualização em tempo real

### ✓ Excluir Promoção

- Confirmação antes de excluir
- Remoção permanente do banco

### ✓ Cards Estatísticas

- Promoções Ativas (atualizadas dinamicamente)
- Total de Ofertas (atualizadas dinamicamente)

## 🔌 API Endpoints

Todos os endpoints estão em `cms_api.php`:

1. **list_promotions** - Lista todas as promoções
2. **add_promotion** - Cria nova promoção
3. **update_promotion** - Atualiza promoção existente
4. **toggle_promotion** - Ativa/desativa promoção
5. **delete_promotion** - Exclui promoção
6. **list_coupons_simple** - Lista cupons para seleção

## 📊 Estrutura da Tabela

```sql
cms_home_promotions
- id (INT, AUTO_INCREMENT)
- titulo (VARCHAR 255)
- subtitulo (VARCHAR 255)
- badge_text (VARCHAR 50) - Ex: "15% OFF"
- button_text (VARCHAR 100)
- button_link (VARCHAR 255)
- cupom_id (INT, FK para cupons)
- data_inicio (DATE)
- data_fim (DATE)
- ordem (INT)
- ativo (TINYINT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

## 🎨 Design

- ✅ Mantém layout existente do CMS
- ✅ Cores e tipografia originais
- ✅ Sidebar e header inalterados
- ✅ Componentes reutilizados
- ✅ Responsivo e compatível com dark mode

## 🔒 Segurança

- ✅ Verificação de sessão
- ✅ Prepared statements (SQL Injection)
- ✅ Validação de dados
- ✅ Headers JSON corretos
- ✅ FOREIGN KEY com cupons

## 📝 Exemplo de Uso

1. Crie um cupom no sistema (CMS > Cupons)
2. Acesse CMS > Promoções
3. Clique em "Nova Promoção"
4. Preencha:
   - Título: "Primeira compra com desconto!"
   - Subtítulo: "Seja bem-vinda à nossa loja"
   - Badge: "15% OFF"
   - Selecione o cupom criado
   - Defina o período de validade
5. Salve e a promoção estará ativa!

## 🐛 Solução de Problemas

### Erro "Tabela não existe"

Execute o `setup_promotions.php` via navegador

### Cupons não aparecem

Verifique se há cupons ativos no sistema

### Erro ao salvar

Verifique logs do PHP e permissões do banco

## ✨ Próximos Passos (Opcional)

- [ ] Adicionar upload de imagem para banner
- [ ] Preview da promoção antes de salvar
- [ ] Duplicar promoção existente
- [ ] Relatório de performance de promoções
- [ ] Integração com front-end da loja
