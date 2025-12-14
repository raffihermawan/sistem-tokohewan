<?php
$title='Inventory';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_login();

$stmt = $pdo->query('SELECT * FROM pets ORDER BY name ASC');
$pets = $stmt->fetchAll();
?>
<div class="container-fluid">
  <h3>Inventory</h3>
  <ul class="nav nav-tabs mb-3">
    <li class="nav-item"><a class="nav-link active" href="#stock" data-bs-toggle="tab">Stock Monitor</a></li>
    <li class="nav-item"><a class="nav-link" href="#add" data-bs-toggle="tab">Add Stock</a></li>
    <li class="nav-item"><a class="nav-link" href="#reduce" data-bs-toggle="tab">Reduce Stock</a></li>
    <li class="nav-item"><a class="nav-link" href="#history" data-bs-toggle="tab">History</a></li>
  </ul>
  
  <div class="tab-content">
    <div class="tab-pane fade show active" id="stock">
      <table class="table">
        <thead><tr><th>Pet</th><th>Current Stock</th><th>Price</th></tr></thead>
        <tbody>
          <?php foreach($pets as $p): ?>
            <tr>
              <td><?php echo e($p['name']); ?></td>
              <td><?php echo e($p['stock']); ?></td>
              <td><?php echo number_format($p['price'],0,',','.'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    
    <div class="tab-pane fade" id="add">
      <form action="add.php" method="post" class="row g-3">
        <div class="col-md-6">
          <label>Pet</label>
          <select name="pet_id" class="form-select" required>
            <option value="">-- Select --</option>
            <?php foreach($pets as $p): ?>
              <option value="<?php echo $p['id']; ?>"><?php echo e($p['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label>Quantity</label>
          <input type="number" name="qty" class="form-control" min="1" required>
        </div>
        <div class="col-12">
          <label>Note</label>
          <textarea name="note" class="form-control"></textarea>
        </div>
        <div class="col-12">
          <button class="btn btn-success">Add Stock</button>
        </div>
      </form>
    </div>
    
    <div class="tab-pane fade" id="reduce">
      <form action="reduce.php" method="post" class="row g-3">
        <div class="col-md-6">
          <label>Pet</label>
          <select name="pet_id" class="form-select" required>
            <option value="">-- Select --</option>
            <?php foreach($pets as $p): ?>
              <option value="<?php echo $p['id']; ?>"><?php echo e($p['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label>Quantity</label>
          <input type="number" name="qty" class="form-control" min="1" required>
        </div>
        <div class="col-12">
          <label>Note</label>
          <textarea name="note" class="form-control"></textarea>
        </div>
        <div class="col-12">
          <button class="btn btn-warning">Reduce Stock</button>
        </div>
      </form>
    </div>
    
    <div class="tab-pane fade" id="history">
      <?php
      $stmt = $pdo->query('SELECT ih.*,p.name FROM inventory_history ih JOIN pets p ON ih.pet_id=p.id ORDER BY ih.created_at DESC LIMIT 100');
      $history = $stmt->fetchAll();
      ?>
      <table class="table">
        <thead><tr><th>Pet</th><th>Type</th><th>Qty</th><th>Note</th><th>Date</th></tr></thead>
        <tbody>
          <?php foreach($history as $h): ?>
            <tr>
              <td><?php echo e($h['name']); ?></td>
              <td><?php echo ucfirst($h['change_type']); ?></td>
              <td><?php echo e($h['qty']); ?></td>
              <td><?php echo e($h['note']); ?></td>
              <td><?php echo date('d-m-Y H:i', strtotime($h['created_at'])); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
