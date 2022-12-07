<?php

class Artigo{

    private $mysql;

    public function __construct(mysqlI $mysql)
    {
        $this->mysql = $mysql;
    }
    //o s significa string e 2 parametro, logo 2 s. Como é inserção não precisa de retorno
    public function adicionar(string $titulo, string $conteudo): void{
        $insereArtigo = $this->mysql->prepare("INSERT INTO artigos (titulo, conteudo) VALUES(?,?)");
        $insereArtigo->bind_param('ss', $titulo, $conteudo);
        $insereArtigo->execute();
    }

    //remove um artigo
    public function remover(string $id): void{
        $removerArtigo = $this->mysql->prepare('DELETE FROM artigos WHERE id = ?');
        $removerArtigo->bind_param('s', $id);
        $removerArtigo->execute();
    }

    public function editar(string $id, string $titulo, string $conteudo): void{
        $editaArtigo = $this->mysql->prepare('UPDATE artigos SET titulo = ?, conteudo = ? WHERE id = ?');
        $editaArtigo->bind_param('sss', $titulo, $conteudo, $id);
        $editaArtigo->execute();
    }

    //pega os dados no banco e transforma em um result, depois transforma em um array.
    public function exibirTodos(): array{
        $resultado = $this->mysql->query('SELECT id, titulo, conteudo FROM artigos');
        $artigos = $resultado->fetch_all(MYSQLI_ASSOC);

        return $artigos;   
    }

    //o bind, vincula a consulta com algum parametro. o s significa string e 1 parametro.
    public function encontrarPorId(string $id): array{
        $selecionaArtigo = $this->mysql->prepare("SELECT id, titulo, conteudo FROM artigos WHERE id = ?");
        $selecionaArtigo->bind_param('s', $id);
        $selecionaArtigo->execute();
        $artigo = $selecionaArtigo->get_result()->fetch_assoc();
        return $artigo;
    }
}

?>