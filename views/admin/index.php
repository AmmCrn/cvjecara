<main>
    <a href="admin/create" id="create-button" style="vertical-align: middle">+</a>

    <form action="" method="get" style="display: inline-block; vertical-align: middle; width: 90%;">
    <div>
        <input class="search" type="text" name="search" placeholder="Search" value="<?php echo $search ?>">
        <button class="button" type="submit">Search</button>
    </div>
    </form>
<table style="margin-top: 0">
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
            <td class="tadmin">
                <a class="button" href="/admin/update?id=<?php echo $product['id'] ?>">Edit</a>
                <br />
                <form method="post" action="/admin/delete" style="display: inline-block">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button class="button" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php if ($_SESSION['page'] > 1): ?>
<a class="button" href="/admin?<?php echo "search=$search&page=".$_SESSSION['page']-1 ?>">Prev</a>
<?php endif ?>
<span class="button"><?php echo $_SESSION['page'] ?></span>
<?php if(ceil(count($products)/10) > $_SESSION['page']): ?>
<a class="button" href="/admin?<?php echo "search=$search&page=".$_SESSION['page']+1; ?>">Next</a>
<?php endif ?>
<a class="button" href="logout">Log Out</a>
</main>