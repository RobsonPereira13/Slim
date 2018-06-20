<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;


//Begin Cliente
$app->get('/clientes/[{id}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/clientes' route");
    $new_response = $response->withJson($args);
   
    return $new_response;
});

$app->post('/clientes', function (Request $request, Response $response) {
    $post_data = json_decode($request->getBody(), true);
    $this->logger->info("Slim-Skeleton '/clientes' POST route $post_data");
  
    return $response->withJson($post_data);
});
//End Cliente

//Begin Table Turistico
$app->get('/turisticos', function (Request $request, Response $response) {
    $sql = "SELECT * FROM turisticos;";
    try{

    	$db = new db();
    	$db = $db->connect();
    	$stmt = $db->query($sql);
    	$turisticos = $stmt->fetchAll(PDO::FETCH_OBJ);
    	$db=null;
    	echo json_encode($turisticos);

    }catch(PDOException $e){
    	echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->get('/turisticos/{id}', function (Request $request, Response $response) {
    $id= $request->getAttribute('id');

    $sql = "SELECT * FROM turisticos WHERE tur_id = $id;";
    try{

        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $turisticos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($turisticos);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->post('/turisticos', function (Request $request, Response $response) {
    $nome= $request->getParam('nome');
    $cidade = $request->getParam('cidade');
    $foto = $request->getUploadedFiles('foto');
    $sql = "INSERT INTO turisticos (nome,cidade,foto) VALUES (:nome,:cidade,:foto)";
    try{

        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':cidade',$cidade);
        $stmt->bindParam(':foto',$foto);
        $stmt->execute();
        echo '{"notice": {"text": "Turistico cadastrado"}';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->put('/turisticos/[{id}]', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nome= $request->getParam('nome');
    $cidade = $request->getParam('cidade');
    $foto = $request->getUploadedFiles('foto');
    $sql = "UPDATE turisticos SET nome =:nome,cidade =:cidade,foto:foto WHERE tur_id=$id";
    try{

        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':cidade',$cidade);
        $stmt->bindParam(':foto',$foto);
        $stmt->execute();
        echo '{"notice": {"text": "Turistico Atualizado"}';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->delete('/turisticos/[{id}]', function(Request $request, Response $response){
   $id = $request->getAttribute('id');

   $sql = "DELETE FROM turisticos WHERE tur_id = $id;";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        echo '{"notice": {"text": "Turistico Removido"}';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    } 
});
//End Turistico

//Begin Hotelaria
$app->get('/hotelarias', function (Request $request, Response $response) {
    $sql = "SELECT * FROM hotelarias;";
    try{

        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $hotelarias = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($hotelarias);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->get('/hotelarias/[{id}]', function (Request $request, Response $response) {
    $id= $request->getAttribute('id');

    $sql = "SELECT * FROM hotelarias WHERE hotel_id = $id;";
    try{

        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $hotelarias = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($hotelarias);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->post('/hotelarias', function (Request $request, Response $response) {
    $nome= $request->getParam('nome');
    $cnpj= $request->getParam('cnpj');
    $telefone= $request->getParam('telefone');
    $email= $request->getParam('email');
    $cidade = $request->getParam('cidade');
    $foto = $request->getUploadedFiles('foto');
    $sql = "INSERT INTO hotelarias (nome,cnpj,telefone,email,cidade,foto) VALUES (:nome,:cnpj,:telefone,:email,:cidade,:foto)";
    try{

        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':cnpj',$cnpj);
        $stmt->bindParam(':telefone',$telefone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':cidade',$cidade);
        $stmt->bindParam(':foto',$foto);
        $stmt->execute();
        echo '{"notice": {"text": "Hotelaria cadastrado"}';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->put('/hotelarias/[{id}]', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nome= $request->getParam('nome');
    $cnpj= $request->getParam('cnpj');
    $telefone= $request->getParam('telefone');
    $email= $request->getParam('email');
    $cidade = $request->getParam('cidade');
    $foto = $request->getParam('foto');

    $sql = "UPDATE hotelarias SET nome =:nome,cnpj=:cnpj,telefone=:telefone,cidade =:cidade,foto=:foto WHERE hotel_id=$id";
    try{

        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nome',$nome);
        $stmt->bindParam(':cnpj',$cnpj);
        $stmt->bindParam(':telefone',$telefone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':cidade',$cidade);
        $stmt->bindParam(':foto',$foto);
        $stmt->execute();
        echo '{"notice": {"text": "Hotelaria Atualizado"}';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->delete('/hotelarias/[{id}]', function(Request $request, Response $response){
   $id = $request->getAttribute('id');
   $sql = "DELETE FROM hotelarias WHERE hotel_id = $id;";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        echo '{"notice": {"text": "Hotelaria Removido"}';

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    } 
});
//End Hotelaria

