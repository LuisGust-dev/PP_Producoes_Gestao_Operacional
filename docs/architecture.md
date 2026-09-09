# PP Check - Fundacao

## Arquitetura

- Laravel MVC com Blade, Tailwind CSS e Alpine.js via Breeze.
- Models concentram relacionamentos e calculos simples de progresso.
- Form Requests validam entrada administrativa.
- Policies separam acesso de Administrador e Equipe.
- Services guardam regras operacionais sensiveis, como quantidade e liberacao.

## Entidades

- `users`: usuarios com `role` (`admin` ou `team`) e `active`.
- `categories`: agrupamento operacional dos equipamentos.
- `equipment`: catalogo por tipo de equipamento, ainda por quantidade.
- `events`: agenda operacional com status, responsavel, tags de categoria e dados de liberacao.
- `event_equipment`: checklist quantitativo dos equipamentos cadastrados.
- `event_custom_items`: itens especificos do evento fora do estoque oficial.
- `event_logs`: auditoria de acoes por evento.
- `equipment_occurrences`: problemas e manutencoes vinculados ao evento.

## Relacionamentos

- Categoria tem muitos equipamentos.
- Equipamento pertence a categoria e pode aparecer em muitos eventos.
- Evento tem muitos equipamentos do evento, itens personalizados, logs e ocorrencias.
- Usuario pode ser responsavel, liberar evento e registrar alteracoes.

## Regras Principais

- Cada evento recebe sua propria lista de equipamentos.
- Quantidade separada nao passa da necessaria.
- Quantidade carregada nao passa da necessaria.
- Quantidade retornada nao passa da carregada.
- Evento so pode ser liberado quando todos os itens obrigatorios foram carregados.
- Toda alteracao relevante registra usuario e horario.

## Fluxo

Cadastrar evento -> adicionar equipamentos -> conferir preparacao -> conferir carregamento -> liberar saida -> conferir retorno -> registrar ocorrencias -> consultar historico.

## Ordem de Implementacao

1. Fundacao Laravel, Breeze, roles, migrations, models e seeders.
2. Layout mobile-first, dashboard e navegacao inferior.
3. CRUD inicial de eventos, equipamentos e categorias.
4. Checklist de preparacao/carregamento/retorno com auditoria.
5. Ocorrencias, historico, filtros avancados e usuarios administrativos.
6. Preparacao PWA, QR Code e controle individual por unidade fisica.
