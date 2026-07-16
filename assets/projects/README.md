# Imagens dos projetos

As imagens exibidas no portfólio são configuradas no campo `images` de `projects.JSON`. Os arquivos devem ser salvos em `assets/images/projects/`.

## Organização dos arquivos

Crie uma pasta para cada projeto usando exatamente o valor do campo `slug`, sem espaços nem acentos:

```text
assets/images/projects/
└── cosplay-score-system/
    ├── tela-inicial.webp
    └── avaliacao.webp
```

Use preferencialmente WebP, proporção 16:9 e resolução aproximada de 1600 × 900 px. PNG, JPG, JPEG e AVIF também são aceitos. Comprima cada arquivo antes de adicioná-lo e tente mantê-lo abaixo de 500 KB. Use somente letras minúsculas, números e hífens nos nomes.

## Preenchimento do JSON

`images` deve ser sempre uma lista. O caminho em `src` é relativo a `assets/images/projects/`; não repita esse prefixo.

Projeto ainda sem imagem:

```json
"images": []
```

Projeto com uma imagem:

```json
"images": [
  {
    "src": "cosplay-score-system/tela-inicial.webp",
    "alt": "Tela inicial com a lista de candidatos do concurso"
  }
]
```

Projeto com várias imagens:

```json
"images": [
  {
    "src": "cosplay-score-system/tela-inicial.webp",
    "alt": "Tela inicial com a lista de candidatos do concurso"
  },
  {
    "src": "cosplay-score-system/avaliacao.webp",
    "alt": "Formulário usado pelo jurado para avaliar um candidato"
  }
]
```

A primeira imagem é usada como capa do card. Todas aparecem, na mesma ordem, na página de detalhes. Não adicione um campo com a quantidade: o portfólio conta automaticamente os itens da lista.

## Limites e cuidados

- Adicione de uma a quatro capturas realmente úteis por projeto; o carregador aceita no máximo seis.
- Descreva em `alt` o conteúdo e a função da tela, evitando textos genéricos como “imagem do projeto”.
- Não use caminhos absolutos, `..`, barras invertidas ou URLs externas.
- Não coloque uma string diretamente em `images`; mantenha os colchetes e um objeto para cada arquivo.
- Confira vírgulas e aspas para preservar um JSON válido.
- Arquivos ausentes, formatos não aceitos e itens inválidos são ignorados sem impedir a exibição do projeto.
- Prints de qualquer proporção são exibidos inteiros. O card os acomoda dentro de uma área 16:9 sem recortar o conteúdo.

Depois de editar, execute o servidor local e confira o card e a página de detalhes:

```bash
php -S localhost:8000 router.php
```
