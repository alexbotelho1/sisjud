<h1>Sistema de Cadastro de Notícias</h1>

<form action="inserir_db.php" method="post">

   <label for="nome">Nome: </label>
   <input name="nome" id="nome" type="text" />

   <label for="sobrenome">Sobrenome: </label>
   <input name="sobrenome" id="sobrenome" type="text" /><br />

   <label for="cidade">Cidade: </label>
   <input name="cidade" id="cidade" type="text" /><br />

   <label for="estado">Estado: </label>
   <input name="estado" id="estado" type="text" /><br />

   <label for="email">Email: </label>
   <input name="email" id="email" type="text" /><br />

   <label for="titulo">Título do Texto: </label>
   <input name="titulo" id="titulo" type="text" /><br />

   <label for="resumo">Resumo do Texto:</label>
   <input name="resumo" id="resumo" type="text" ><br />

   <label for="texto">Texto: </label>
   <textarea name="texto" id="texto" rows="10" cols="30" />
   </textarea><br />

   <input type="submit" value="Cadastrar">

</form>
<form action="index.php"><input type="submit" value=" Voltar "></form>

