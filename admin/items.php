<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle = 'Items';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // start manage page
    }elseif ($do == 'Add'){
        // start add page
        ?>
            <div class=" login-form text-center">
                <form  method="post" class="form" action="items.php?do=Store">
                    <h3 class="text-center">Add New Item</h3>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="name" placeholder="Enter Item Name!" required >
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="description" placeholder="Enter Item Description!"  required>
                    </div>
                    <div class="form-group">
                        <input type="text" value="" name="price"  class="form-control" placeholder="Enter Item Price!" required>
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="country" placeholder="Enter Country Made!" required>
                    </div>
                    <div class="form-group ">
                        <label for="status"> Status</label>
                        <select name="status" id="status">
                            <option value="0">........</option>
                            <option value="1">New</option>
                            <option value="1">Like New</option>
                            <option value="1">Used</option>
                            <option value="1">Very Old</option>
                        </select>
                    </div>
                    <button class="btn btn-warning" type="reset">Reset Data <i class="fas fa-redo"></i></button>
                    <button type="submit" name="addNewItem" class="btn btn-primary">Add Item <i class="fas fa-folder-plus"></i> </button>
                </form>
            </div>
        <?php
    }
    include $temps . 'footer.php';
}else{
    header('Location: index.php');
}