<div class="details-section">
    <h3 style="color: #1E3A8A;">Bahan & Deskripsi</h3>
    <p style="color: #374151;"><?= nl2br(htmlspecialchars($product['about'])) ?></p>

    <form action="/app.php/cart/add" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

        <label for="qty">Kuantitas:</label>
        <input type="number" name="qty" id="qty" value="1" min="1" max="<?= $product['stock'] ?>"
            style="width: 60px; padding: 5px; margin-bottom: 15px;">

        <button type="submit" name="action" value="add_to_cart" class="btn-primary"
            style="background-color: #60A5FA; color: #FFFFFF; padding: 10px 20px; margin-right: 10px;">
            Tambah ke Keranjang
        </button>

        <button type="submit" name="action" value="buy_now" class="btn-primary"
            style="background-color: #3B82F6; color: #FFFFFF; padding: 10px 20px;">
            Beli Sekarang
        </button>
    </form>
</div>