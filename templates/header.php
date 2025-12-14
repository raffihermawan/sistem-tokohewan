<?php
if (!defined('BASE_URL')) define('BASE_URL', '/sistem-tokohewan');
require_once __DIR__ . '/../init.php';
?><!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Manajemen Toko Hewan Peliharaan">
  <meta name="theme-color" content="#2c3e50">
  <title><?php echo isset($title) ? e($title) : 'Petshop - Sistem Manajemen'; ?></title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
  
  <style>
    /* Additional responsive utilities */
    @media (max-width: 768px) {
      .container-fluid {
        padding: 0.5rem;
      }
    }
  </style>
</head>
<body>
<?php
