# Portfólio de Endrew Marra Pedrosa

Portfólio pessoal desenvolvido em PHP, com conteúdo organizado em componentes, views e fontes de dados JSON.

## Estado atual

A estrutura inicial prevista na Etapa 1 do plano está implementada. O perfil, a foto, os contatos e os projetos já são carregados dos arquivos existentes em `assets`, sem duplicação de conteúdo no HTML.

## Requisitos

- PHP 8.1 ou superior;
- navegador atualizado.

O projeto não precisa de banco de dados nem de instalação de dependências nesta etapa.

## Executar localmente

Na raiz do projeto, execute:

```bash
php -S localhost:8000
```

Depois, acesse [http://localhost:8000](http://localhost:8000).

## Conteúdo

- Informações pessoais e caminho da foto: `assets/infos.JSON`;
- Projetos: `assets/projects/projects.JSON`;
- Foto de perfil: `assets/images/endrew.jpeg`;
- Imagens futuras dos projetos: `assets/images/projects/`.

Os arquivos JSON ficam dentro da pasta pública do projeto. Adicione neles apenas informações que possam ser exibidas publicamente.

## Estrutura principal

```text
.
├── index.php
├── projeto.php
├── components/
│   ├── layout.php
│   ├── sidebar.php
│   ├── project-card.php
│   └── footer.php
├── views/
│   ├── home.php
│   └── project-details.php
├── data/
│   ├── profile.php
│   └── projects.php
└── assets/
    ├── css/
    ├── images/
    ├── js/
    └── projects/
```

`data/profile.php` e `data/projects.php` validam e adaptam os JSONs para os componentes PHP. A paleta original permanece em `assets/css/styles.css`.

## Licença

Este projeto está disponível sob a licença MIT.
