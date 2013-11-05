<?php

$db = new PDO("mysql:host=localhost;dbname=db1",'user','secret');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$db->exec('SET CHARACTER SET utf8');

//Retrive all tags
if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' && $_GET['tags'] == 'all') {
    try {
        $sql = "SELECT * FROM tags";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        }
    catch(PDOException $e)
        {
        echo $e->getMessage();
        }

}

//Add a tag
elseif($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $value = json_decode(file_get_contents('php://input'));
        $tag = $value->tag;
        $stmt = $db->prepare("INSERT INTO tags(title) VALUES(?)");
        $stmt->bindValue(1, $tag, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt) {
            $result = array();
            $result['id'] = $db->lastInsertId();
            $result['title'] = $tag;
        }
        echo json_encode($result);
        }
    catch(PDOException $e)
        {
        echo $e->getMessage();
        }

}

//Delete tag
elseif($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        $id = $_GET['id'];
        $stmt = $db->prepare("DELETE FROM tags WHERE id = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) $result = 'success'; else $result = 'error';
        echo json_encode($result);
        }
    catch(PDOException $e)
        {
        echo $e->getMessage();
        }

}

//Edit tag
elseif($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        $value = json_decode(file_get_contents('php://input'));
        $id = $value->id;
        $title = $value->title;
        $stmt = $db->prepare("UPDATE tags SET title = ? WHERE id = ?");
        $stmt->bindValue(1, $title, PDO::PARAM_STR);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            $result = array();
            $result['title'] = $title;
        }
        echo json_encode($result);
        }
    catch(PDOException $e)
        {
        echo $e->getMessage();
        }

}

else {
    echo 'Uncorrect request';
}

?>