<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function flash(string $type, string $message): void { $_SESSION['flash'] = ['type'=>$type,'message'=>$message]; }
function getFlash(): ?array { $flash=$_SESSION['flash']??null; unset($_SESSION['flash']); return $flash; }
function csrfToken(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verifyCsrf(): void { if(!hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Permintaan tidak valid. Silakan kembali dan coba lagi.');} }
function rupiah(float|int $value): string { return 'Rp '.number_format((float)$value,0,',','.'); }
