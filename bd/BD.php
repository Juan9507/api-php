<?php
    $pdo = null;
    $host = "localhost";
    $user= "root";
    $password = "";
    $bd ="tutoriales"; // Base de datos a cual nos vamos a conectar

    function conectar(){
       try {
            $GLOBALS['pdo']=new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['bd']."",$GLOBALS['user'], $GLOBALS['password']);
            $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $e) {
        //    print "Error!: No se pudo conectar a la bd ".$bd."</br>";
           print "\nError!: ".$e."</br>";
           die();
       }

    }

    function desconectar(){
        $GLOBALS['pdo']=null;
    }

    function metodoGet($query){
        try {
            conectar();
            $setencia =$GLOBALS['pdo']->prepare($query);
            $setencia->setFetchMode(PDO::FETCH_ASSOC);
            $setencia->execute();
            desconectar();
            return $setencia;
        } catch (Exception $e) {
            die("Error: ".$e);
        }
    }

    function metodoPost($query, $queryAutoIncrement){
        try {
            conectar();
            $setencia =$GLOBALS['pdo']->prepare($query);
            $setencia->execute();
            $idAutoIncrement = metodoGet($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
            $resultado = array_merge($idAutoIncrement, $_POST);
            $setencia->closeCursor();
            desconectar();
            return $setencia;
        } catch (Exception $e) {
            die("Error: ".$e);
        }
    }

    function metodoPut($query){
        try {
            conectar();
            $setencia =$GLOBALS['pdo']->prepare($query);
            $setencia->execute();
            $resultado = array_merge($_GET, $_POST);
            $setencia->closeCursor();
            desconectar();
            return $setencia;
        } catch (Exception $e) {
            die("Error: ".$e);
        }
    }

    function metodoDelete($query){
        try {
            conectar();
            $setencia =$GLOBALS['pdo']->prepare($query);
            $setencia->execute();
            $setencia->closeCursor();
            desconectar();
            return $_GET['id'];
        } catch (Exception $e) {
            die("Error: ".$e);
        }
    }
