# Primeiro deploy

Este projeto pode ser publicado diretamente em hospedagem compartilhada. Ele não usa banco de dados, Composer, Node.js nem instalação de dependências em produção.

## Pré-requisitos

- hospedagem com Apache e PHP 8.3 ou superior;
- suporte a regras em `.htaccess`;
- certificado HTTPS oferecido pela hospedagem;
- acesso pelo gerenciador de arquivos do painel ou por FTP.

## 1. Localizar a pasta pública

No painel da hospedagem, localize a pasta servida pelo domínio. Nomes comuns são `public_html`, `htdocs` e `www`.

O arquivo `index.php` deve ficar diretamente nessa pasta, e não dentro de uma subpasta adicional. Antes de substituir um site existente, faça uma cópia dos arquivos que já estiverem nela.

## 2. Enviar os arquivos

Envie estes diretórios e arquivos, preservando a estrutura:

```text
assets/
components/
config/
data/
views/
.htaccess
index.php
projeto.php
```

Os JSONs dentro de `assets` são necessários: o PHP lê esses arquivos no servidor, enquanto o `.htaccess` impede que o visitante os abra diretamente.

Estes itens podem permanecer somente no GitHub e não são necessários para executar o site:

```text
.git/
.gitignore
router.php
README.md
DEPLOY.md
PLANO_IMPLEMENTACAO_PORTFOLIO.md
ALTERACOES_PRE_DEPLOY_CODEX.md
assets/projects/README.md
LICENSE
.env
```

Não envie arquivos `.env`, logs, credenciais ou arquivos temporários. Os contatos em `assets/infos.JSON` são conteúdo público do portfólio e não devem ser usados para armazenar segredos.

Ao enviar a pasta `assets`, deixe `assets/projects/README.md` de fora ou remova esse arquivo da hospedagem depois do upload. Ele é apenas documentação para manutenção do repositório.

## 3. Configurar e testar

1. Selecione PHP 8.3 ou uma versão posterior no painel da hospedagem.
2. Abra a página inicial e confirme o carregamento do CSS e da foto.
3. Abra um projeto existente pela ação **Ver detalhes**.
4. Acesse `projeto.php?slug=slug-inexistente` e confirme a página de projeto não encontrado.
5. Teste GitHub, LinkedIn, e-mail e WhatsApp.
6. Confira o site em um celular.
7. Teste diretamente os endereços abaixo; nenhum deles deve revelar o conteúdo do arquivo:

```text
/assets/infos.JSON
/assets/projects/projects.JSON
/config/bootstrap.php
/data/projects.php
/router.php
/.gitignore
```

É normal o servidor responder `403` ou `404` nesses endereços.

## Solução de problemas

### Erro HTTP 500 logo após o upload

Algumas hospedagens não permitem alterar a diretiva `Options`. Comente temporariamente esta linha do `.htaccess` e teste novamente:

```apache
# Options -Indexes
```

Se isso resolver, mantenha a linha comentada e desative a listagem de diretórios pelo recurso equivalente do painel da hospedagem ou solicite essa configuração ao suporte.

### JSON ou arquivo interno aparece no navegador

Confirme que o `.htaccess` foi enviado, inclusive o ponto inicial do nome, e que a hospedagem permite sobrescrever regras. Se o arquivo continuar público, solicite ao suporte a ativação de `AllowOverride` ou um bloqueio equivalente antes de divulgar o site.

### Página sem estilo, foto ou imagens

Confirme que a pasta `assets` foi enviada sem alterar nomes e letras maiúsculas/minúsculas. Permissões usuais são `755` para diretórios e `644` para arquivos.

### Projeto existente retorna 404

Confirme que `assets/projects/projects.JSON`, `data/projects.php` e as imagens foram enviados. Não renomeie slugs ou pastas durante o upload.

## HTTPS

Ative o certificado antes de divulgar o endereço. Depois que o HTTPS estiver funcionando, configure o redirecionamento de HTTP para HTTPS pelo painel da hospedagem ou em uma etapa posterior. O projeto ainda não força esse redirecionamento e não envia HSTS.

## Checklist final

- [ ] PHP 8.3 ou superior selecionado.
- [ ] Estrutura enviada diretamente para a pasta pública.
- [ ] Página inicial, CSS, foto e imagens carregando.
- [ ] Projeto existente abrindo corretamente.
- [ ] Slug inexistente exibindo a página de erro.
- [ ] GitHub, LinkedIn, e-mail e WhatsApp testados.
- [ ] Site conferido em celular.
- [ ] JSONs e arquivos internos bloqueados.
- [ ] HTTPS ativo.
- [ ] Endereço público revisado.
