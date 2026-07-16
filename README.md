# Portfólio de Endrew Marra Pedrosa

Portfólio pessoal desenvolvido em PHP, com perfil, projetos, tecnologias e contatos organizados em componentes reutilizáveis e fontes de dados JSON.

## Estado atual

O MVP do portfólio está funcional:

- página inicial com sidebar responsiva;
- conteúdo Sobre, tecnologias organizadas e contatos;
- projetos carregados dinamicamente do JSON;
- cards reutilizáveis e páginas individuais por slug;
- suporte a status, descrição completa, demonstração e até seis imagens por projeto;
- página de erro para projetos inexistentes;
- navegação por teclado, foco visível e destaque da seção atual;
- proteção dos arquivos PHP internos e cabeçalhos básicos de segurança.

Alguns status, descrições completas e o endereço público ainda dependem de conteúdo ou hospedagem a serem fornecidos.

## Tecnologias do portfólio

- PHP 8.1 ou superior;
- HTML5 semântico;
- CSS3 responsivo;
- JavaScript sem dependências;
- JSON para os dados do perfil e dos projetos.

Não há banco de dados, gerenciador de pacotes ou etapa de instalação.

## Executar localmente

Na raiz do projeto, execute:

```bash
php -S localhost:8000 router.php
```

Depois, acesse [http://localhost:8000](http://localhost:8000).

O `router.php` impede que arquivos internos, dotfiles, documentos e JSONs sejam servidos diretamente durante o desenvolvimento local.

## Atualizar o conteúdo

- Perfil, título, resumo e contatos: `assets/infos.JSON`;
- Projetos: `assets/projects/projects.JSON`;
- Instruções para capturas dos projetos: [`assets/projects/README.md`](assets/projects/README.md);
- Foto e favicon: `assets/images/profile/`;
- Capturas dos projetos: `assets/images/projects/`;
- Categorias da seção Tecnologias: `data/technologies.php`.

O primeiro item de `images` é a capa do card e todas as imagens válidas aparecem na página de detalhes. A quantidade é calculada automaticamente.

## Estrutura principal

```text
.
├── index.php
├── projeto.php
├── router.php
├── config/
│   └── bootstrap.php
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
│   ├── projects.php
│   └── technologies.php
└── assets/
    ├── css/
    ├── images/
    ├── js/
    └── projects/
```

Os arquivos em `data/` validam e adaptam os JSONs antes da renderização. A paleta original permanece em `assets/css/styles.css`.

## Publicação

- Em Apache, o `.htaccess` incluído bloqueia dotfiles, JSONs e diretórios internos. Confirme que `AllowOverride` está habilitado.
- Em Nginx ou outro servidor, configure regras equivalentes e permita acesso público somente a `index.php`, `projeto.php` e aos arquivos necessários de `assets/css`, `assets/js` e `assets/images`.
- Mantenha `display_errors` desativado em produção. O bootstrap já usa esse comportamento por padrão fora do servidor embutido do PHP.
- Ative HTTPS antes de divulgar o endereço público.

## Licença

Este projeto está disponível sob a licença MIT.
