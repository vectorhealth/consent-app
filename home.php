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
 
    $sql = "UPDATE `HCP` SET `IsDeleted`='1' WHERE VHID = '" . $_POST['hcp-id']. "'";

    try { 
        $conn->exec($sql);
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
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body onload="loaded()">






    <!-- HCP NAME AND HISTORY -->
    <div id="N6s45nqg5mKU6vIcDwNvzCizUL9B1lc5" class=" container-fluid ">



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

        <div class="welcome-msg">
            <!-- <img class="google-name-avatar" alt="Welcome Image" height="100"> -->
            <h2>Welcome, <b><span class="google-name">John Doe</span></b></h2>
        </div>

        <div class="cnt-main ">


            <div class="center">

                <h1 class="head">HCP Details</h1>

                <div>
                    <h4 class="background">
                        HCP Information
                    </h4>
                    <table>

                        <tr class="heading-row">
                            <td><b>HCP Name:</b></td>
                            <td><b>License #: </b></td>
                            <td><b>General Consent Status:</b></td>

                            <td><b>HCP Email:</b></td>
                            <td><b>DATE</b></td>
                            <td><b>User Name</b></td>
                            <td><b>Phone #</b></td>
                        </tr>

                        <tr>

                            <td class="hcp_name-container">
                                    <select data-id="select_hcp_name" id="select_hcp_name" name="status">

                                        <?php
                                    $sql = "SELECT VHID,Name FROM HCP WHERE IsDeleted = 0 AND VHID = " . $current_id;
                                    $result = $conn->query($sql);

                                    if ($result->rowCount() > 0) {
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?php echo $row["VHID"] ?>"><?php echo $row["Name"] ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                        <?php
                                    $sql = "SELECT VHID,Name FROM HCP WHERE IsDeleted = 0 AND NOT VHID = " . $current_id;
                                    $result = $conn->query($sql);

                                    if ($result->rowCount() > 0) {
                                        while ($row1 = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?php echo $row1["VHID"] ?>"><?php echo $row1["Name"] ?></option>
                                        <?php
                                        }
                                    }
                                                ?>
                                    </select>

                                </form>
                            </td>

                            <td><select data-id="select_hcp_name" name="lic-list">
                                    <?php
                                $sql = "SELECT VHID,License  FROM HCP WHERE IsDeleted = 0 AND VHID = " . $current_id;
                                $result = $conn->query($sql);

                                if ($result->rowCount() > 0) {
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $row["VHID"] ?>"><?php echo $row["License"] ?></option>
                                    <?php
                                    }
                                }
                                ?>
                                    <?php
                                $sql = "SELECT VHID,License FROM HCP WHERE NOT VHID = " . $current_id;
                                $result = $conn->query($sql);

                                if ($result->rowCount() > 0) {
                                    while ($row2 = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <option value="<?php echo $row2["VHID"] ?>"><?php echo $row2["License"] ?></option>
                                    <?php
                                    }
                                }
                                            ?>
                                </select></td>



                            <td>


                                <select name="status" data-id="select-hcp_status">
                                    <?php
                                    $sql = "SELECT ID, Description FROM GeneralConsentStatus";
                                    $result = $conn->query($sql);

                                    if ($result->rowCount() > 0) {
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php echo $row["ID"] ?>"><?php echo $row["Description"] ?></option>
                                    <?php
                                        }
                                    }
                                            ?>
                                </select>
                            </td>


                            <?php
                            $sql = "SELECT * FROM HCP WHERE IsDeleted = 0 AND VHID = " . $current_id;
                            $result = $conn->query($sql);

                            if ($result->rowCount() > 0) {
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            ?>


                            <td id="hcp-email"><?php echo $row["Email"] ?></td>


                            <td id="last-date"><?php echo $row["Date"] ?></td>
                            <td id="last-uid"><?php echo $row["Username"] ?></td>
                            <td id="contact-phone"><?php echo $row["Phone"] ?></td>

                        </tr>


                        <tr class="heading-row">

                            <td><b>Address Line 1</b></td>
                            <td><b>Address Line 2</b></td>
                            <td><b>City</b></td>
                            <td><b>State/Province</b></td>
                            <!-- <td><b>Province</b></td> -->
                            <td><b>Postal Code:</b></td>
                            <td><b>Country</b></td>
                        </tr>



                        <tr>





                            <td id="address-line-1"><?php echo $row["AddressLine1"] ?></td>

                            <td id="address-line-2"><?php echo $row["AddressLine2"] ?></td>

                            <td id="city"><?php echo $row["City"] ?></td>

                            <td id="state"><?php echo $row["StateProvince"] ?></td>


                            <td id="postal-code"><?php echo $row["PostalCode"] ?></td>


                            <td id="country"><?php echo $row["Country"] ?></td>






                        </tr>


                        <tr class="heading-row">

                            <td colspan="5"><b>Comments</b></td>
                            <td><b></b></td>
                            <td><b></b></td>

                        </tr>

                        <tr>



                            <td colspan="5">
                                <span id="comment"><i><?php echo $row["Comment"] ?></i></span>
                            </td>

                            <td>
                                <a href="edithcp.php?ID=<?php echo $row["VHID"]?>" class="btn button-view enhanced">Edit HCP</a>
                            </td>

                            <td>
                                <a href="addhcp.php"  class="btn button-view enhanced">Add HCP</a>
                            </td>

                            <td>
                                <button onclick="deleteHCP()" class="button-view enhanced">Delete HCP</button>
                                <form id="delete_hcp_form" method="post" action="home.php" hidden>
                                    <input hidden value="<?php echo $row["VHID"] ?>" name="hcp-id" />
                                </form>
                            </td>

                            <td>
                                <a href="addrecord.php?ID=<?php echo $row["VHID"]?>" class="btn button-view enhanced darklight">Add Record</a>
                            </td>

                        </tr>


                        <?php
                                }
                            }
                            ?>

                    </table>
                </div>

                <div class="cnt-bottom">
                    <h4 class="background">
                        HCP Consent History
                    </h4>
                    <!-- 
            <div class="cnt-search">
                <input type="text" placeholder="Example: Search All Fields">
                <button class="button-view"> Search</button>
            </div> -->

                    <table id="table-history">

                        <thead>
                            <tr class="background-light table-heading">
                                <td>
                                    <b>Date</b>

                                </td>
                                <td><b>Consent Status </b>

                                </td>
                                <td><b>Issued by</b>

                                </td>

                                <td><b>HCP Id</b>

                                </td>

                                <td><b>Record Id</b>

                                </td>

                                <td><b>Supporting Documentation</b>

                                </td>
                                <td><b>Comments</b>


                            </tr>
                        </thead>


                        <tbody>
                            

                        <?php
                            $sqll = "SELECT * FROM HCP_History as hh INNER JOIN GeneralConsentStatus as gcs ON hh.GeneralConsentStatusID = gcs.ID WHERE HCPID = " . $current_id;
                            $resultt = $conn->query($sqll);

                        if ($result->rowCount() > 0) {
                            while ($roww = $resultt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

               
                        <tr>
                            <td><?php echo $roww["Date"]?></td>
                            <td><?php echo $roww["Description"]?></td>
                            <td><?php echo $roww["IssuedBy"]?></td>
                            <td><?php echo $roww["HCPID"]?></td>
                            <td><?php echo $roww["RecordID"]?></td>
                            <td><a target="_blank" href="docs/<?php echo $roww["SupportingDocumentPath"]?>">Document</td>
                            <td><?php echo $roww["Comment"]?></td>
                        </tr>
      
                        <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>


                </div>



            </div>


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