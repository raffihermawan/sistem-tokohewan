<?php
// ========================================================
// 1. WAJIB DIPALING ATAS: init + auth + NO HTML
// ========================================================
require_once __DIR__ . '/../init.php';
require_login();

$title = 'Create Sale';

// Ambil data awal, belum ada output HTML
$customers = $pdo->query('SELECT * FROM customers ORDER BY name ASC')->fetchAll();
$pets = $pdo->query('SELECT * FROM pets WHERE stock > 0 ORDER BY name ASC')->fetchAll();

$invoice_no = 'INV-' . date('Ymd') . '-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);

// ========================================================
// 2. PROSES FORM DULU (SEBELUM TEMPLATE DI-RENDER)
// ========================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? null;
    $items = $_POST['items'] ?? [];
    $total = 0;

    // Hitung total
    foreach ($items as $item) {
        if ($item['pet_id'] && $item['qty'] > 0) {
            $stmt = $pdo->prepare('SELECT price FROM pets WHERE id=?');
            $stmt->execute([$item['pet_id']]);
            $pet = $stmt->fetch();
            if ($pet) $total += $pet['price'] * $item['qty'];
        }
    }

    // Validasi total
    if ($total > 0) {
        // Insert sale
        $stmt = $pdo->prepare('INSERT INTO sales (invoice,customer_id,total,paid) VALUES (?,?,?,?)');
        $stmt->execute([$invoice_no, $customer_id, $total, 0]);
        $sale_id = $pdo->lastInsertId();

        // Insert items
        foreach ($items as $item) {
            if ($item['pet_id'] && $item['qty'] > 0) {
                $stmt = $pdo->prepare('SELECT price,stock FROM pets WHERE id=?');
                $stmt->execute([$item['pet_id']]);
                $pet = $stmt->fetch();

                if ($pet && $pet['stock'] >= $item['qty']) {
                    $subtotal = $pet['price'] * $item['qty'];

                    // Insert sales item
                    $stmt = $pdo->prepare('INSERT INTO sales_items (sale_id,pet_id,qty,price,subtotal) VALUES (?,?,?,?,?)');
                    $stmt->execute([$sale_id, $item['pet_id'], $item['qty'], $pet['price'], $subtotal]);

                    // Kurangi stok
                    $stmt = $pdo->prepare('UPDATE pets SET stock = stock - ? WHERE id=?');
                    $stmt->execute([$item['qty'], $item['pet_id']]);

                    // Log inventory
                    $stmt = $pdo->prepare('INSERT INTO inventory_history (pet_id,change_type,qty,note) VALUES (?,?,?,?)');
                    $stmt->execute([$item['pet_id'], 'reduce', $item['qty'], 'Sale: ' . $invoice_no]);
                }
            }
        }

        // ========================================================
        // 3. REDIRECT DI SINI — sebelum HTML template
        // ========================================================
        header('Location: invoice.php?id=' . $sale_id);
        exit;
    }
}

// ========================================================
// 4. BARU INCLUDE TEMPLATE SETELAH LOGIC SELESAI
// ========================================================
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<!-- ========================================================
     5. HTML MULAI DI SINI (AMAN 100%)
======================================================== -->

<div class="container-fluid">
  <h3>Create New Sale</h3>

  <form method="post" id="saleForm">

    <div class="mb-3">
      <label>Customer</label>
      <select name="customer_id" class="form-select">
        <option value="">-- Select Customer --</option>
        <?php foreach ($customers as $c): ?>
          <option value="<?php echo $c['id']; ?>"><?php echo e($c['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <h5>Items</h5>

      <table class="table" id="itemsTable">
        <thead>
            <tr>
                <th>Pet</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="itemsBody">
          <tr class="item-row">
            <td>
              <select name="items[0][pet_id]" class="form-select pet-select" data-row="0">
                <option value="">-- Select Pet --</option>
                <?php foreach ($pets as $p): ?>
                  <option value="<?php echo $p['id']; ?>" data-price="<?php echo $p['price']; ?>">
                    <?php echo e($p['name']); ?> (Rp<?php echo number_format($p['price'], 0, ',', '.'); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </td>

            <td><input type="number" class="form-control item-price" value="0" readonly></td>
            <td><input type="number" name="items[0][qty]" class="form-control item-qty" min="1" value="0"></td>
            <td><input type="number" class="form-control item-subtotal" value="0" readonly></td>
            <td><button type="button" class="btn btn-sm btn-danger removeItem">Remove</button></td>
          </tr>
        </tbody>
      </table>

      <button type="button" class="btn btn-sm btn-secondary" id="addItemBtn">Add Item</button>
    </div>

    <div class="mb-3">
      <label>Total: <strong id="totalAmount">Rp 0</strong></label>
    </div>

    <button class="btn btn-primary">Process Sale</button>

  </form>
</div>

<script>
/* JS tetap sama */
let itemCount = 1;

document.getElementById('addItemBtn').addEventListener('click', function() {
    let row = document.querySelector('.item-row').cloneNode(true);
    row.querySelector('.pet-select').setAttribute('data-row', itemCount);
    row.querySelector('.pet-select').name = 'items[' + itemCount + '][pet_id]';
    row.querySelector('.item-qty').name = 'items[' + itemCount + '][qty]';
    document.getElementById('itemsBody').appendChild(row);
    itemCount++;
    attachHandlers();
});

function attachHandlers() {
    document.querySelectorAll('.pet-select').forEach(sel => {
        sel.addEventListener('change', function() {
            let row = this.closest('tr');
            let price = this.options[this.selectedIndex].getAttribute('data-price') || 0;
            row.querySelector('.item-price').value = price;
            calculateSubtotal(row);
        });
    });

    document.querySelectorAll('.item-qty').forEach(qty => {
        qty.addEventListener('change', function() {
            calculateSubtotal(this.closest('tr'));
        });
    });

    document.querySelectorAll('.removeItem').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('tr').remove();
            calculateTotal();
        });
    });
}

function calculateSubtotal(row) {
    let price = parseFloat(row.querySelector('.item-price').value) || 0;
    let qty = parseInt(row.querySelector('.item-qty').value) || 0;
    row.querySelector('.item-subtotal').value = price * qty;
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.item-subtotal').forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

attachHandlers();
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
