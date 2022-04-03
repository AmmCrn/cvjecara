<div style="width: fit-content; margin: 2em auto; background: rgb(20,0,0); border-radius: 8px; padding: 0 1em">
    <?php foreach($errors as $err){
        echo "<h4 style='color: red;'>" . $err . "</h4>";
    } ?>

    <form method="post" style="display: block; padding: 1.5em 0 2em">
        <div class="form-elem">
            <label>Username</label>
            <input type="text" name="user">
        </div>
        <div class="form-elem">
            <label>Password</label>
            <input type="password" name="pass">
        </div>
        
        <button class="button button-dark" type="submit">Login</button>
    </form>
</div>