<?php
require '../app/Views/partials/header.php';
// Hitung total keseluruhan
$grand_total = array_sum(array_column($cart_items, 'subtotal') ?? []);
?>

<div class="cart-wrapper" style="background-color: #F0F8FF; padding: 30px;">
    <h1 style="color: #1E3A8A;">Keranjang Belanja Anda</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div style="background-color: #22C55E; color: #FFFFFF; padding: 10px; margin-bottom: 15px;">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <p>Keranjang Anda kosong. Yuk, segera cari sepatu favorit Anda!</p>
        <a href="/app.php/" class="btn-primary" style="background-color: #60A5FA;">Lanjut Belanja</a>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; background-color: #FFFFFF;">
            <thead>
                <tr style="background-color: #93C5FD;">
                    <th style="padding: 10px; text-align: left; color: #1E3A8A;">Produk</th>
                    <th style="padding: 10px; color: #1E3A8A;">Harga Satuan</th>
                    <th style="padding: 10px; color: #1E3A8A;">Jumlah</th>
                    <th style="padding: 10px; color: #1E3A8A;">Subtotal</th>
                    <th style="padding: 10px; color: #1E3A8A;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td style="padding: 10px; color: #1E3A8A;"><?= htmlspecialchars($item['name']) ?></td>
                        <td style="padding: 10px; text-align: center;">Rp <?= number_format($item['price']) ?></td>
                        <td style="padding: 10px; text-align: center;"><?= $item['qty'] ?></td>
                        <td style="padding: 10px; text-align: right;">Rp <?= number_format($item['subtotal']) ?></td>
                        <td style="padding: 10px; text-align: center;">
                            <a href="/app.php/cart/remove/<?= $item['id'] ?>" style="color: #EF4444;">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right; color: #1E3A8A;">
            <h2>Total Belanja: Rp <?= number_format($grand_total) ?></h2>
            <a href="/app.php/checkout" class="btn-primary"
                style="background-color: #60A5FA; color: #FFFFFF; padding: 10px 20px; display: inline-block; margin-top: 10px;">
                Lanjut ke Checkout
            </a>
        </div>
    <?php endif; ?>
</div>

</body>

</html>