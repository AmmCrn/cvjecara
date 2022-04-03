<main>

<?php 
    foreach ($errors as $er) {
        echo "<h4 class='err'>" . $er . "</h4><br/>";
    }
?>

<form method="post" enctype="multipart/form-data">
    <?php if ($product['image']): ?>
        <img src="/<?php echo $product['image'] ?>" style="width: 20%">
    <?php endif; ?>

    <div class="form-elem">
        <label>Image</label><br>
        <input type="file" name="image">
    </div>
    <div class="form-elem">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $product['name'] ?>">
    </div>
    <div class="form-elem">
        <label>Description</label>
        <textarea name="desc"><?php echo $product['desc'] ?></textarea>
    </div>
    <div class="form-elem">
        <label>Product price</label>
        <input type="number" step=".01" name="price" value="<?php echo $product['price'] ?>">
    </div>
    
    <button type="submit">Submit</button>
</form>

</main>