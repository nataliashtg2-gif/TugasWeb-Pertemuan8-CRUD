<?php
require_once __DIR__ . '/../config/bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){redirect('../index.php?page=products');}
verifyCsrf();
$id=(int)($_POST['id']??0);
$stmt=$pdo->prepare('SELECT name FROM products WHERE id=?'); $stmt->execute([$id]); $product=$stmt->fetch();
if(!$product){flash('error','Produk tidak ditemukan.');redirect('../index.php?page=products');}
try{
    $pdo->beginTransaction();
    $del=$pdo->prepare('DELETE FROM products WHERE id=?'); $del->execute([$id]);
    $log=$pdo->prepare('INSERT INTO activity_logs(action,description) VALUES(?,?)'); $log->execute(['DELETE','Menghapus produk: '.$product['name']]);
    $pdo->commit(); flash('success','Produk berhasil dihapus.');
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();flash('error','Produk gagal dihapus.');}
redirect('../index.php?page=products');
