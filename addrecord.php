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

    $id = $_POST['hcp-id'];
    $date = $_POST['hcp-date'];
    $status = $_POST['hcp-status'];
    $comment = $_POST['hcp-comment'];
    // $document = $_POST['hcp-document'];

    if(isset($_FILES['hcp-document'])){
        $errors= array();
        $file_name = $_FILES['hcp-document']['name'];
        $file_size =$_FILES['hcp-document']['size'];
        $file_tmp =$_FILES['hcp-document']['tmp_name'];
        $file_type=$_FILES['hcp-document']['type'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $extensions= array("txt", "doc", "docx", "pdf", "xls", "xlsx", "ppt", "pptx", "TXT", "DOC", "DOCX", "PDF", "XLS", "XLSX", "PPT", "PPTX");
        
        if(in_array($file_ext,$extensions)=== false){
           $errors[]="extension not allowed, please choose a document file.";
        }
        
        if(empty($errors)==true){
           move_uploaded_file($file_tmp,"docs/".$file_name);
        }else{
           print_r($errors);
        }

        $sql = "INSERT INTO `hcp_history`(`Date`, `GeneralConsentStatusID`, `IssuedBy`, `HCPID`, `SupportingDocumentPath`, `Comment`) VALUES ('" . $date . "','" . $status . "','test','" . $id . "','".$file_name."','" . $comment . "')";

        try {
            $conn->exec($sql);
            echo '<script>
                    alert("HCP Record has been added")
                </script>';
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
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






    <!-- ADD HCP HISTORY -->
    <div id="N6s45nqg5mKU6vIcDwNvzCizUL9B1ld6" class=" admin-signin-panel">

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


        <div class="input-form">

            <img src="imgs/left.PNG" height="250" width="300" />


            <form class="form-signin w-50" method="post" action="addrecord.php" enctype="multipart/form-data">


                <img class="logo-img" src="thumbnail.PNG" />
                <h1 class="h3 mb-3  align-center"><b>ADD RECORD</b></h1>


                <div class="form-group">
                    <label for="Date">Date <span class="c-red">*</span></label>
                    <input name="hcp-date" type="date" class="form-control" id="record-date"
                        placeholder="Example: Date">
                </div>

                <div class="form-group">
                    <label for="inputState">Status <span class="c-red">*</span></label>
                    <select class="form-control" name="hcp-status" id="record-status">
                        <option value="1">No Status</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                        <option value="4">Pending Approval</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="Comments">Comments</label>
                    <input name="hcp-comment" type="text" class="form-control" id="record-comments"
                        placeholder="Example: Comments">
                </div>

                <div class="form-group">
                    <label for="Attached Documents">Attached Documents</label>
                    <input name="hcp-document" type="file" class="form-control-file" id="record-file">
                </div>

                <input hidden value="<?php echo $current_id ?>" name="hcp-id" />


                <button type="submit" class="btn btn-primary">Submit</button>



            </form>

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