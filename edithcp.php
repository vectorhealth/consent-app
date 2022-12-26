<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=consentmgt", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$current_id = $_GET['ID'] ?? 1;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['hcp-name'];
    $email = $_POST['hcp-email'];
    $lic = $_POST['hcp-lic'];
    $date = $_POST['hcp-date'];
    $add1 = $_POST['hcp-add1'];
    $add2 = $_POST['hcp-add2'];
    $city = $_POST['hcp-city'];
    $status = $_POST['hcp-status'];
    $state = $_POST['hcp-state'];
    $phone = $_POST['hcp-phone'];
    $postal = $_POST['hcp-postal'];
    $country = $_POST['hcp-country'];
    $comment = $_POST['hcp-comment'];

    $sql = "UPDATE `HCP` SET `Name`='" . $name . "',`License`='" . $lic . "',`GeneralConsentStatusID`='" . $status . "',`Email`='" . $email . "',`Date`='" . $date . "',`Username`='test',`Phone`='" . $phone . "',`AddressLine1`='" . $add1 . "',`AddressLine2`='" . $add2 . "',`City`='" . $city . "',`Country`='" . $country . "',`StateProvince`='" . $state . "',`PostalCode`='" . $postal . "',`Comment`='" . $comment . "' WHERE VHID = '" . $current_id. "'";

    try { 
        $conn->exec($sql);
        echo '<script>
                    alert("HCP has been updated")
                </script>';
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }


}

?>

<!DOCTYPE html>


<html lang="en">

<head>




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    </link>

</head>

<body onload="loaded()">






    <!-- ADD HCP NAME -->
    <div class="admin-signin-panel mb-3">

        <div class="navigation">
            <ul>
                <li><img height="60" src="https://i.postimg.cc/q42Syqqb/thumbnail.png?dl=1" /></li>

                <li class="main-heading">
                    <h2>HCP Consent Management Console</h>
                </li>

                <li>
                    <span class="google-name" id="google-name">Emilio Seplulveda</span>
                    &nbsp;
                    &nbsp;
                    <button onclick="logout()" type="button" class="btn btn-warning">Log Out</button>


                </li>
            </ul>
        </div>



        <a class="btn btn-primary btn-back" href="home.php">Back</a>


        <div class="input-form add-hcp-form">

            <img src="imgs/left.PNG" height="250" width="300" />

            <?php
                            $sql = "SELECT * FROM HCP WHERE VHID = " . $current_id;
                            $result = $conn->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>



            <form class="form-signin w-50" method="post" action="edithcp.php">

                <img class="logo-img" src="thumbnail.PNG" />
                <h1 class="h3 mb-3  align-center"><b>EDIT HCP</b></h1>



                <div class="form-group">
                    <label for="User Name">HCP Name <span class="c-red">*</span></label>
                    <input value="<?php echo $row["Name"] ?>" name="hcp-name" type="text" class="form-control" id="hcp-name"
                        placeholder="Example: Anna Maria">
                </div>


                <!-- <div class="form-group">
                    <label for="User ID">HCP Id <span class="c-red">*</span></label>
                    <input type="text" class="form-control" id="hcp-uid" placeholder="Example: HCP Id">
                </div> -->

                <div class="form-group">
                    <label for="User ID">Email <span class="c-red">*</span></label>
                    <input value="<?php echo $row["Email"] ?>"name="hcp-email" type="text" class="form-control" id="hcp-emaill"
                        placeholder="Example: annamaria@gmail.com">
                </div>

                <!-- <div class="form-group">
                    <label for="Licence IDs">Licence IDs (Separated by comma)</label>
                    <input type="text" class="form-control" id="hcp-licenceids" placeholder="Example: 3084141,3121234,...">
                </div> -->

                <div class="form-group">
                    <label for="Self LIC">Self LIC <span class="c-red">*</span></label>
                    <input value="<?php echo $row["License"] ?>" name="hcp-lic" type="text" class="form-control" id="hcp-selflic"
                        placeholder="Example: 3084141">
                </div>


                <div class="form-group">
                    <label for="HCP Status">HCP Status <span class="c-red">*</span></label>
                    <select  name="hcp-status" id="hcp-status">
                        <option value="1">No Status</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                        <option value="4">Pending Approval</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Date">Date <span class="c-red">*</span></label>
                    <input value="<?php echo $row["Date"] ?>" name="hcp-date" type="date" class="form-control" id="hcp-date" placeholder="Example: Date">
                </div>

                <div class="form-group">
                    <label for="User Phone">Phone <span class="c-red">*</span></label>
                    <input value="<?php echo $row["Phone"] ?>" name="hcp-phone" type="text" class="form-control" id="hcp-phonee"
                        placeholder="Example: +1-541-754-3010	">
                </div>



                <div class="form-group">
                    <label for="Address Line 1">Address Line 1</label>
                    <input value="<?php echo $row["AddressLine1"] ?>" name="hcp-add1" type="text" class="form-control" id="hcp-address11"
                        placeholder="Example: Via Alessandro Manzoni 85">
                </div>

                <div class="form-group">
                    <label for="Address Line 2">Address Line 2</label>
                    <input value="<?php echo $row["AddressLine2"] ?>" name="hcp-add2" type="text" class="form-control" id="hcp-address22"
                        placeholder="Example: Diabala district">
                </div>


                <div class="form-group">
                    <label for="City">City <span class="c-red">*</span></label>
                    <input value="<?php echo $row["City"] ?>" name="hcp-city" type="text" class="form-control" id="hcp-city" placeholder="Example: Pometo">
                </div>

                <div class="form-group">
                    <label for="State-Province">State/Province <span class="c-red">*</span></label>
                    <input value="<?php echo $row["StateProvince"] ?>" name="hcp-state" type="text" class="form-control" id="hcp-stateprovince"
                        placeholder="Example: Pavia">
                </div>


                <div class="form-group">
                    <label for="Postal Code">Postal Code <span class="c-red">*</span></label>
                    <input value="<?php echo $row["PostalCode"] ?>" name="hcp-postal" type="text" class="form-control" id="hcp-postalcode"
                        placeholder="Example: 27040">
                </div>


                <div class="form-group">
                    <label for="Country">Country <span class="c-red">*</span></label>
                    <input value="<?php echo $row["Country"] ?>" name="hcp-country" type="text" class="form-control" id="hcp-country"
                        placeholder="Example: Italy">
                </div>

                <div class="form-group">
                    <label for="Comments">Comments</label>
                    <input value="<?php echo $row["Comment"] ?>" name="hcp-comment" type="text" class="form-control" id="hcp-comments"
                        placeholder="Example: This is a comment">
                </div>



                <button type="submit" class="btn btn-primary">Submit</button>



            </form>

            <?php
                }
            }?>

            <img src="imgs/right.PNG" height="250" width="300" />


        </div>

    </div>






    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>

    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-database.js"></script>

    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-storage.js"></script>

    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-firestore.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-analytics.js"></script>


    <script src="config.js"></script>

    <script src="app.js"></script>

</body>




</html>