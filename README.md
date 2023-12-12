

# Teste Laravel - Aplicação Upload de Arquivo

### Stack utilizada
- PHP 8.1
- Laravel 10
- PHPUNIT
- PostgreSQL
- Docker + Docker Compose

## Rodando projeto local

Para iniciar o projeto, execute o seguinte comando:

```
make start
```

## Testes unitários

Para validar os testes unitários, execute
```
make unit-tests
```
![img.png](img.png)

## Comandos úteis

### Realizar build da imagem docker
```make build``` 
### Atualizar os pacotes do composer
`make update`:

### Executa as migrations
`make db-migrate`

### Rodar as Seeds
`make db-seed`


## Melhorias Migrations
- Inclusão de indices nas principais colunas, otimizando a pesquisa em ambas tabelas
- Adição do campo de `status` na coluna `documents`, facilitando a visualização dos arquivos já processados dos pendentes.
