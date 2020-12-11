<?php
$pageTitle = 'New AD';
include 'init.php';
if (isset($_SESSION['userName'])){
    // if there is session so the user logged in, display his profile
    $userName = $_SESSION['userName'];
    $selectUserStmt = "SELECT * FROM users WHERE UserName = '$userName'";
    $result = mysqli_query($connection, $selectUserStmt);
    $user = $result->fetch_assoc();
    ?>
    <h1 class="text-center hi">Welcome <?php echo $_SESSION['userName'];?></h1>


    <!--START add new item CARD-->
    <div class="inforamtion block">
        <div class="container">
            <div class="card">
                <div class="card-header text-center" style="background-color:#61b15a">
                    Create New AD <i class="fas fa-ad"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form  method="post" class="form" action="newAd.php">
                                <h3 class="text-center">Add New Item</h3>
                                <!--NAME OF ITEM-->
                                <div class="form-group ">
                                    <input type="text"
                                           class="form-control live-name"
                                           name="name"
                                           placeholder="Enter Item Name!" required pattern=".{4,}"
                                           title="item name should be at least 4 characters" >
                                </div>
                                <!--DESCRIPTION OF ITEM-->
                                <div class="form-group ">
                                    <input type="text"
                                           class="form-control live-desc"
                                           name="description"
                                           placeholder="Enter Item Description!" required
                                           pattern=".{15,}"
                                           title="The item description should be at least 15 characters">
                                </div>
                                <!--PRICE OF ITEM-->
                                <div class="form-group">
                                    <input type="text"
                                           name="price"
                                           class="form-control live-price"
                                           placeholder="Enter Item Price!"
                                           minlength="1" required>
                                </div>
                                <!--COUNTRY OF ITEM-->
                                <div class="form-group ">
                                    <input type="text"
                                           class="form-control live-country"
                                           name="country"
                                           placeholder="Enter Country Made!" pattern=".{4,}"
                                           title="The item country should be at least 4 characters"
                                           required>
                                </div>
                                <!-- SELECT BOX FOR STATUS OF ITEM-->
                                <div class="form-group ">
                                    <label for="status"> Status</label>
                                    <select name="status" id="status" required>
                                        <option value="">Select Status</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Very Old</option>
                                    </select>
                                </div>

                                <!--SELECT BOX FOR CATEGORIES OF ITEM-->
                                <div class="form-group ">
                                    <label for="categories">Categories</label>
                                    <select name="categories" id="categories" required>
                                        <option value="">Select Category</option>
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
                            <!--END OF ITEM FORM INFORMATION-->
                        </div>

                        <!--START OF ITEM SHAPE-->
                        <div class="col-md-4">
                            <div class="thumbnail item-box preview-live">
                                <span class="price-tag">$0</span>
                                <img width="200" height="200" src="layouts/images/avatar01.jpg" alt="me">
                                <div class="figure-caption">
                                    <h3>name</h3>
                                    <p>description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end add new item CARD-->

<?php
    if (isset($_POST['addNewItem'])){
        $item_name      = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $item_desc      = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $item_price     = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $item_country   = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $item_status    = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $item_category  = filter_var($_POST['categories'], FILTER_SANITIZE_NUMBER_INT);
        $userID = $_SESSION['uid'];
        $formErrors = array();
         // name validation
        if (strlen($item_name) < 4){
            $formErrors[] = "The item name should be at least 4 characters";
        }
        // description validation
        if (strlen($item_desc) < 15){
            $formErrors[] = "The item description should be at least 15 characters";
        }
        // country validation
        if (strlen($item_country) < 4){
            $formErrors[] = "The item country should be at least 4 characters";
        }
        // price validation
        if (strlen($item_price) < 1){
            $formErrors[] = "The item price should not be empty";
        }
        // status validation
        if (strlen($item_status) < 1){
            $formErrors[] = "The item status should not be empty";
        }
        // category validation
        if (strlen($item_category) < 1){
            $formErrors[] = "The item category should not be empty";
        }

        // check if there is any error
        if (! empty($formErrors)){
            errorDisplay($formErrors);
        }else{
            // store the item information
            $insertItemQuery = "INSERT INTO items (Item_Name, Item_Desc, Item_Price, 
                                Item_Date, Item_Country, Item_Status, Cat_ID, Member_ID) 
                                VALUES ('$item_name', '$item_desc', '$item_price', now(), 
                                '$item_country', '$item_status', '$item_category', '$userID')";
            $insertItemResult = mysqli_query($connection,$insertItemQuery);
            if (!$insertItemResult){
                errorDisplay(array("Item Cannot Be Added"));
            }else{
                successDisplay("Item Added Successfully");
            }
        }
    }
?>


    <?php
    include 'includes/temps/footer.php';
} else{
    // if there is no session so this user need to login
    header("Location: login.php");
    exit();
}

