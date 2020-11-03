<?php
session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle = 'Items';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        // start manage page
        $allItemsFromDB = "SELECT items.*, categories.Name AS Category_name,users.UserName AS User_name FROM items
                            INNER JOIN categories ON items.Cat_ID = categories.ID
                            INNER JOIN users ON items.Member_ID = users.UserID";
        $result = mysqli_query($connection,$allItemsFromDB);
        if ($result) {


            // table to show all Items
            ?>


            <div class="container">
                <h1 class="text-center">Manage Items</h1>
                <table class="table members-table table-responsive table-hover text-center">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Country</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Add Date</th>
                        <th>Control</th>
                    </tr>
                    <?php while($rows = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $rows['Item_ID'];?></td>
                            <td><?php echo $rows['Item_Name'];?></td>
                            <td><?php echo $rows['Item_Desc'];?></td>
                            <td><?php echo $rows['Item_Price'];?></td>
                            <td><?php echo $rows['Item_Country'];?></td>
                            <td><?php echo $rows['Category_name'];?></td>
                            <td><?php echo $rows['User_name'];?></td>
                            <td><?php echo $rows['Item_Date'];?></td>
                            <td>
                                <div class="btn-group link-group">
                                    <a href="items.php?do=Edit&ItemID=<?php echo $rows['Item_ID'];?>" class="btn btn-warning">Update <i class="fas fa-user-edit"></i></a>
                                    <a href="items.php?do=Delete&ItemID=<?php echo $rows['Item_ID'];?>" class="btn btn-danger confirm">Delete <i class="fas fa-trash"></i></a>

                                </div>
                            </td>
                        </tr>
                    <?php }?>
                </table>
                <div class="btn-group">
                    <a class="btn btn-primary add-btn " href="items.php?do=Add"> Add New Item <i class="fas fa-plus"></i> </a>
                </div>

            </div>

            <?php
        }
    }elseif ($do == 'Add'){
        // start add page
        ?>
            <div class=" login-form text-center">
                <form  method="post" class="form" action="items.php?do=Store">
                    <h3 class="text-center">Add New Item</h3>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="name" placeholder="Enter Item Name!"  >
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="description" placeholder="Enter Item Description!"  >
                    </div>
                    <div class="form-group">
                        <input type="text" value="" name="price"  class="form-control" placeholder="Enter Item Price!" >
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="country" placeholder="Enter Country Made!" >
                    </div>
                    <!-- SELECT BOX FOR STATUS-->
                    <div class="form-group ">
                        <label for="status"> Status</label>
                        <select name="status" id="status">
                            <option value="0">Select Status</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
                    <!--SELECT BOX FOR MEMBERS-->
                    <div class="form-group ">
                        <label for="user"> User</label>
                        <select name="user" id="user">
                            <option value="0">Select User</option>
                            <?php
                            $selectUsers = "SELECT * FROM users";
                            $flag =mysqli_query($connection, $selectUsers);
                            if (! $flag){
                                errorDisplay(array("Cannot Get Users"));
                            }else{
                                while( $user = mysqli_fetch_assoc($flag)){

                                    echo "<option value='" . $user['UserID'] . "'> " . $user['UserName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!--SELECT BOX FOR CATEGORIES-->
                    <div class="form-group ">
                        <label for="categories">Categories</label>
                        <select name="categories" id="categories">
                            <option value="0">Select Category</option>
                            <?php
                            $selectUsers = "SELECT * FROM categories";
                            $flag =mysqli_query($connection, $selectUsers);
                            if (! $flag){
                                errorDisplay(array("Cannot Get Users"));
                            }else{
                                while( $cat = mysqli_fetch_assoc($flag)){

                                    echo "<option value='" . $cat['ID'] . "'> " . $cat['Name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-warning" type="reset">Reset Data <i class="fas fa-redo"></i></button>
                    <button type="submit" name="addNewItem" class="btn btn-primary">Add Item <i class="fas fa-folder-plus"></i> </button>
                </form>
            </div>
        <?php
    }elseif ($do =="Store"){
        if (isset($_POST['addNewItem'])){
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $user  = $_POST['user'];
            $category = $_POST['categories'];
            $errors_array = array();
            if (empty($name)){
                $errors_array[] = "Name Of The Item Cannot Be Empty Please Enter A Name";
            }
            if (empty($desc)){
                $errors_array[] = "Description Of The Item Cannot Be Empty Please Enter Descriptive Sentences";
            }
            if (empty($price)){
                $errors_array[] = "Price Of The Item Cannot Be Empty Please Enter The Price";
            }
            if (empty($country)){
                $errors_array[] = "The Country Of Item Cannot Be Empty Please Enter Where It Is From";
            }
            if ($status == 0){
                $errors_array[] = "Please Enter The Status Of The Item";
            }
            if ($user == 0){
                $errors_array[] = "Please Enter The Member Of The Item";
            }
            if ($category == 0){
                $errors_array[] = "Please Enter The Category Of The Item";
            }
            if (empty($errors_array)){
                $insertItemQuery = "INSERT INTO `items` (`Item_Name`, `Item_Desc`, `Item_Price`, `Item_Date`, `Item_Country`, `Item_Image`, `Item_Status`, `Item_Rating`, `Cat_ID`, `Member_ID`) VALUES ( '$name', '$desc', '$price', now(), '$country', NULL, '$status', NULL, '$category', '$user')";
                $flag = mysqli_query($connection,$insertItemQuery);
                if (! $flag){
                    errorDisplay(array('Cannot Insert New Items'));
                }else{
                    successDisplay('New Item Inserted Successfully');
                    header('refresh:5;url=items.php');
                    exit();
                }
            }else{
                errorDisplay($errors_array);
            }
        }else{
            errorDisplay(array("You Can\'t Get This Page Directly"));
            header('refresh:5;url=index.php');
            exit();
        }
    }elseif ($do == 'Edit'){
        // start edit page
        if (isset($_GET['ItemID'])){
            $itemID = intval($_GET['ItemID']);
            $selectItemByID = "SELECT * FROM items WHERE Item_ID='$itemID'";
            $flag = mysqli_query($connection, $selectItemByID);
            if (! $flag){
                errorDisplay(array('Cannot Get Item'));
            }
            $row = mysqli_fetch_assoc($flag);
            ?>
            <div class=" login-form text-center">
                <form  method="post" class="form" action="items.php?do=Store">
                    <h3 class="text-center">Add New Item</h3>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="name" value="<?php echo $row['Item_Name'];?>"  >
                        <input type="text" class="form-control" name="id" value="<?php echo $row['Item_ID'];?>"  >

                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="description" value="<?php echo $row['Item_Desc'];?>"  >
                    </div>
                    <div class="form-group">
                        <input type="text" value="" name="price"  class="form-control" value="<?php echo $row['Item_Price'];?>" >
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" name="country" value="<?php echo $row['Item_Country'];?>" >
                    </div>
                    <!-- SELECT BOX FOR STATUS-->
                    <div class="form-group ">
                        <label for="status"> Status</label>
                        <select name="status" id="status">
                            <option value="1" <?php if ($row['Item_Status'] == 1) echo 'selected'?>>New</option>
                            <option value="2" <?php if ($row['Item_Status'] == 2) echo 'selected'?>>Like New</option>
                            <option value="3" <?php if ($row['Item_Status'] == 3) echo 'selected'?>>Used</option>
                            <option value="4" <?php if ($row['Item_Status'] == 4) echo 'selected'?>>Very Old</option>
                        </select>
                    </div>
                    <!--SELECT BOX FOR MEMBERS-->
                    <div class="form-group ">
                        <label for="user"> User</label>
                        <select name="user" id="user">
                            <option value="0">Select User</option>
                            <?php
                            $selectUsers = "SELECT * FROM users";
                            $flag =mysqli_query($connection, $selectUsers);
                            if (! $flag){
                                errorDisplay(array("Cannot Get Users"));
                            }else{
                                while( $user = mysqli_fetch_assoc($flag)){

                                    echo "<option value='" . $user['UserID'] . "'";
                                    if ($row['Member_ID'] == $user['UserID']){
                                        echo 'selected';
                                    }
                                    echo "> " . $user['UserName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!--SELECT BOX FOR CATEGORIES-->
                    <div class="form-group ">
                        <label for="categories">Categories</label>
                        <select name="categories" id="categories">
                            <option value="0">Select Category</option>
                            <?php
                            $selectUsers = "SELECT * FROM categories";
                            $flag =mysqli_query($connection, $selectUsers);
                            if (! $flag){
                                errorDisplay(array("Cannot Get Users"));
                            }else{
                                while( $cat = mysqli_fetch_assoc($flag)){

                                    echo "<option value='" . $cat['ID'] . "'";
                                    if ($row['Cat_ID'] == $cat['ID']){
                                        echo 'selected';
                                    }
                                    echo "> " . $cat['Name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-warning" type="reset">Reset Data <i class="fas fa-redo"></i></button>
                    <button type="submit" name="UpdateItem" class="btn btn-primary">Update Item <i class="fas fa-folder-plus"></i> </button>
                </form>
            </div>
            <?php

        }else{
            errorDisplay(array("cannot update this item you will be redirected"));
            header("refresh:5;url=items.php");
            exit();
        }
    }
    include $temps . 'footer.php';
}else{
    header('Location: index.php');
}