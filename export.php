<?php
require_once __DIR__ . '/config/bootstrap.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="laporan-inventaris.csv"');
$out=fopen('php://output','w');
fputcsv($out,['ID','Produk','Kategori','Supplier','Harga','Stok','Nilai Stok']);
$stmt=$pdo->query('SELECT p.id,p.name,c.name category_name,s.name supplier_name,p.price,p.stock,(p.price*p.stock) value FROM products p JOIN categories c ON c.id=p.category_id JOIN suppliers s ON s.id=p.supplier_id ORDER BY p.id');
while($row=$stmt->fetch())fputcsv($out,[$row['id'],$row['name'],$row['category_name'],$row['supplier_name'],$row['price'],$row['stock'],$row['value']]);
fclose($out); exit;
