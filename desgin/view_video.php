<?php

include 'Connecting/connect.php';


if(isset($_COOKIE['user_id1'])){
   $user_id = $_COOKIE['user_id1'];
}else{
   $user_id = '';
header("Location:loginT.php");
}



 if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   
}

if(isset($_POST['submit'])){

   
   $status = $_POST['status'];
 
   $title = $_POST['title'];
   
   $type_doc = $_POST['type'];

   $coursId = $_POST['course'];
  
   $date=date("Y-m-d");

   $thumb = $_FILES['thumb']['name'];

   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../fichier/'.$thumb;

   $video = $_FILES['video']['name'];
  
   
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $video_folder = '../fichier/'.$video;

   if($thumb_size ==0){
      
   }else{

   $sql = "INSERT INTO `document`(`libelle_doc`, `type_doc`, `dateDepot`, `pieceJoint`, `photo`, `status`) VALUES ('$title','$type_doc','$date','$video','$thumb','$status')";
    mysqli_query($mysqli, $sql);
      move_uploaded_file($thumb_tmp_name, $thumb_folder);
    $sql1= "SELECT MAX(id_doc) FROM document ";

    $result1=mysqli_query($mysqli,$sql1);


    while($res = mysqli_fetch_array($result1)){
    $id_doc=$res['MAX(id_doc)'];
    }

    $sql2 = "INSERT INTO `contenu` (`id_cours_CoursSoutien`, `id_doc_Document`) VALUES ($coursId,$id_doc)";
    mysqli_query($mysqli, $sql2);
      move_uploaded_file($thumb_tmp_name, $thumb_folder);
   }

   

}


   $stql="SELECT id_formateur,nom_formateur,prenom_formateur,photoF,specialite FROM formateur";
    
    $resultl=mysqli_query($mysqli,$stql);


    while($res = mysqli_fetch_array($resultl)){
    $id=$res['id_formateur'];
    $nom=$res['nom_formateur'];
    $prenom=$res['prenom_formateur'];
    $photo=$res['photoF'];
    $matiere=$res['specialite'];
    }

    
 $stql1="SELECT id_eleve,nom_eleve,prenom_eleve,photo_eleve FROM eleve";
    





  //retreive data from DataBase

  
    
    $result1=mysqli_query($mysqli,$stql1);


    while($res = mysqli_fetch_array($result1)){
    $id_eleve=$res['id_eleve'];
    $nom=$res['nom_eleve'];
    $prenom=$res['prenom_eleve'];
    $photo=$res['photo_eleve'];
    }


?>


<?php
//afficher msg
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}


?>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
  <!-- header start -->
    <header class="header">
      <section class="flex">
        <a href="home.html" class="logo">Etudiant</a>

        <form action="search.html" method="post" class="search-form">
          <input
            type="text"
            name="search_box"
            required
            placeholder="search courses..."
            maxlength="100"
          />
          <button type="submit" class="fas fa-search"></button>
        </form>

        <div class="icons">
          <div id="menu-btn" class="fas fa-bars"></div>
          <div id="search-btn" class="fas fa-search"></div>
          <div id="user-btn" class="fas fa-user"></div>
          <div id="toggle-btn" class="fas fa-sun"></div>

          
        </div>

        <div class="profile">
          <img src="fichier/<?php if($photo != null)echo $photo; else echo 'null.jpg'?>" class="image" alt="test" />
          <h3 class="name"><?php echo $nom;?></h3>
          <p class="role">eleve</p>
          <a href="profile.html" class="btn">view profile</a>
           <a href="composant/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         
        </div>
      </section>
    </header>
<!-- navbar start -->
    <div class="side-bar">
      

      <div class="profile">
        <img src="fichier/<?php if($photo != null)echo $photo; else echo 'null.jpg'?>" class="image" alt="<?php echo $photo; ?>" />
        <h3 class="name"><?php  echo $nom ." ".$prenom?></h3>
        <p class="role">Etudiant</p>
        <a href="profile.html" class="btn">view profile</a>
      </div>

      <nav class="navbar">
      <a href="homeLog.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
      <a href="MyCourses1.php"><i class="fas fa-chalkboard-user"></i><span>My courses</span></a>
      <a href="about.html"><i class="fas fa-question"></i><span>about</span></a>
      <a href="complaint.php"><i class="fa-solid fa-note-sticky"></i><span>complaint</span></a>
      <a href="newmsg.php"><i class="fas fa-headset"></i><span>Send Message</span></a>
   </nav>
    </div>
   <!-- navbar finish -->





<section class="view-content">

   <?php

     $stql="SELECT * FROM document WHERE type_doc like 'video' and id_doc =$get_id";
    
    $result=mysqli_query($mysqli,$stql);


    while($res = mysqli_fetch_array($result)){
   $id_doc1=$res['id_doc'];
    $libelle_doc1=$res['libelle_doc'];
    $type_doc1=$res['type_doc'];
    $date1=$res['dateDepot'];
    $status1=$res['status'];
    $video1=$res['pieceJoint'];
    $photo2=$res['photo'];
    }
    
    
     ?>
   <div class="container">
 
      <video src="fichier/<?= $video1 ?>" autoplay controls poster="fichier/<?= $thumb ?>" class="video"></video>
      <div class="date"><i class="fas fa-calendar"></i><span><?= $date1; ?></span></div>
      <h3 class="title"><?= $libelle_doc1; ?></h3>
      
      
      <form action="" method="post">
         <div class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
           
         </div>
      </form>
   </div>
 

</section>













<script src="js/admin_script.js"></script>

</body>
</html>