<main>

<form action="" method="get">
    <div>
        <input class="search" type="text" name="search" placeholder="Search" value="<?php echo $search ?>">
        <button class="button" type="submit">Search</button>
    </div>
</form>
<table>
    <thead>
        <tr>
            <th></th>
            <th>Ime</th>
            <th>Opis</th>
            <th>Cijena</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php for($i = ($_SESSION['page']-1)*10; $i < (int)$_SESSION['page']*10; $i++ ){
                $product = $products[$i];
                if(!$product) break;
            ?>
            <tr>
            <td class="timg">
                <?php if ($product['image']): ?>
                    <img src="/<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>" class="product-img">
                <?php endif; ?>
            </td>
            <td class="tname"><?php echo $product['name'] ?></td>
            <td class="tdesc"><?php echo $product['desc'] ?></td>
            <td class="tprice"><?php echo $product['price'] ?></td>
            <td class="tbuy">
                <a class="button" style="padding: 1em 2em" href="#">Buy</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php if ($_SESSION['page'] > 1): ?>
<a class="button" href="/shop?<?php echo "search=$search&page=".$_SESSSION['page']-1 ?>">Prev</a>
<?php endif ?>
<span class="button"><?php echo $_SESSION['page'] ?></span>
<?php if(ceil(count($products)/10) > $_SESSION['page']): ?>
<a class="button" href="/shop?<?php echo "search=$search&page=".$_SESSION['page']+1; ?>">Next</a>
<?php endif ?>
</main>