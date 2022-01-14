<?php
include('connecte_db.php');
include('inc_session.php');

$record_peage=5;
$page="";

if(isset($_GET['page'])){
$page = $_GET['page'];
}

else {

$page=1;	
	
}
     
	 // recuperation des site different  s'il existe
	 $req=$bdd->prepare('SELECT societys FROM inscription_client WHERE email_user= :email_user');
     $req->execute(array(':email_user'=>$_SESSION['email_user']));
     $donnees=$req->fetch();
	 $req->closeCursor();
	 if(!empty($donnes)){
	
   // on recupere les sites
	 $sites = $donnees['societys'];
	 // on eclate sous forme de array
	 $site = explode(',',$sites);
	 // creation d'un tableau associatives
	 $sit1 =1;
	 $sit2 =2;
	 $si3=3;
	  $datas = array($sit1=>$site[0],
	                $sit2=>$site[1],
					$sit3 =>$site[2]
				);
	// on boucle sur le tableau
	  foreach($datas as $keys => $value){
      $select='<option value="'.$keys.'">'.$value.'</option>';
	}
	
	 }
		
	//paginition
	// on compte le nombre de ligne de la table
   if($_SESSION['code']==0){
   $reg=$bds->prepare('SELECT count(*) AS nbrs FROM chambre WHERE email_ocd= :email_ocd');
   $reg->execute(array(':email_ocd'=>$_SESSION['email_ocd']));
   }
   
   else{
	  $reg=$bds->prepare('SELECT count(*) AS nbrs FROM chambre WHERE email_ocd= :email_ocd AND codes= :code');
      $reg->execute(array(':code'=>$_SESSION['code'],
	                      ':email_ocd'=>$_SESSION['email_ocd'])); 
   }
   $dns=$reg->fetch();
   $totale_page=$dns['nbrs']/$record_peage;
   $totale_page = ceil($totale_page);
   $reg->closeCursor();
  
  // recupere les données sur les site existant
  $req=$bds->prepare('SELECT society,code FROM tresorie_customer WHERE email_ocd= :email_ocd');
   $req->execute(array(':email_ocd'=>$_SESSION['email_ocd']));
   $donnes = $req->fetchAll();
   $data =[];
   foreach($donnes as $values){
	  $datas =  explode(',',$values['society']);
      foreach($datas as $val){
         $data[]= $val;
	  }	  
   }

?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Logiciel en mode Saas</title>

    <!-- Custom fonts for this template-->
  
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
	.s{display:none;}
     h1,select{height:35px;border-color:#eee;text-align:center;border-bottom:1px solid #eee;font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:18px;font-weight:300;color:black;margin-left:%;}
    #collapse{width:300px;height:100px;padding:2%;position:fixed;top:60px;left:81%;border-shadow:3px 3px 3px black;}
    .bg{background:white;width:300px;border:2px solid #eee;height:210px;padding:4%;}
.center{background-color:white;width:80%;padding-top:5px;padding-bottom:50px;} .inputs,.input{margin-left:5%;float:left;}
.nav-search{width:70%;} .form-select{margin-left:40%;width:200px;height:43px;}
.inputs{font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:14px;font-weight:bold;color:green;}
#pak{position: fixed;top: 0;left: 0;width:100%;height: 100%;background-color: black;z-index:2;opacity: 0.6;}
#examp{padding:3%;position:absolute;width:60%;height:1150px;z-index:3;left:18%;top:20px;background-color:white;border-radius:10px;}
.forms{width:200px;font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:14px;font-weight:bold;color:black}
h2{	font-size:16px;margin-top:30px;width:500px;font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:14px;color:#4e73df}

input{width:50px;}
#file1,#file2,#file3,#file4{width:250px;}
#inputEmail4{width:250px;}
textarea{width:50%;} #his{width:250px;margin-left:70%;height:40px;background:#4e73df;border:2px solid #4e73df;color:white;font-family:arial;border-radius:15px;}

 #pak{width:200px;position: fixed;top: 0;left: 0;width:100%;height: 100%;background-color: black;z-index:2;opacity: 0.6;}
label{color:black;font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:14px;font-weight:bold;color:black}
 .dep {
  animation: spin 2s linear infinite;
  margin-top:10px;font-size:45px;font-weight:bold;
  }

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
#pak{position: fixed;top: 0;left: 0;width:100%;height: 100%;background-color: black;z-index:2;opacity: 0.6;}
.enre,.up,.ups{font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:14px;color:black;z-index:4;position:absolute;top:250px;left:40%;border:2px solid white;font-family:arial;font-size:14px;width:280px;height:150px;padding:2%;text-align:center;background-color:white}

.x{color:#4e73df;font-weight:bold;} .ts{padding-left:4%;} .center{width:90%;margin-left:5%;background-color:white;}

.div{color:green;} #block_delete{position: absolute;top:200px;left:40%;width:370px;;height:160px;background-color:white;z-index:4;}
 h3{color:black;padding-top:5%;font-family:Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:16px;text-align:center;}
 #button_annuler{width:120px;margin-left:6%;height:40px;color:white;background:red;margin-top:20px;border:2px solid red;text-align:center;border-radius:15px;}
 #button_delete{width:50px;height:40px;background:#4e73df;color:white;border-radius:50%;margin-left:10%;margin-top:20px;border:2px solid #4e73df;}
 .enr{color:white;padding:2%;font family:arial;background:red;width:150px;height:35px;}
 #data_delete{position:absolute;top:300px;left:25%;} #forms {color:black;}
 .color{background:#E0F1FA;} .home{color:#111E7F;font-size:18px;font-weight:bold;}
.side{color:#A9D3F2;padding:35%;text-align:center;margin-left:-8%;width:160px;height:160px;border-radius:50%;background:white;border:2px solid white;margin-top:95px;}

ul a{margin-left:3%;} #form_logo{display:none;} 
.pied_page{margin-left:60%;margin-top:10px;width:30%;} .bout{background:#06308E;border:2px solid #06308E;color:white;text-align:center;float:left;margin-left:2%;width:30px;height:30px} 
.bouts{background:white;border:2px solid white;color:#06308E;text-align:center;float:left;margin-left:2%;width:30px;height:30px} 

#logo{position:absolute;top:6px;left:1.7%;border-radius:50%;}

#tb td, #tb th {border: 1px solid #ddd;padding:3px;width:250px;text-align:center;font-size:14px;}

#tb tr:nth-child(even){background-color:#f2f2f2;}

#tb tr:hover {background-color: #ddd;}

#tb th {padding-top: 12px;padding-bottom: 12px;text-align: left;color: black;text-align:center;background:#D2EDF9;border:2px solid #D2EDF9}

#tb{margin-top:10px;} #tb td{height:90px;color:black}
.pied,.p{float:left;}
#message_datas{padding-left:2%;padding-bottom:8px;position:absolute;}
.drop{position:absolute;top:50px;width:240px;height:200px;background:white;border:2px solid white;margin-left:-5px;
background-color: white;
border-radius: 20px;
border-width: 0;
box-shadow: rgba(25,25,25,.04) 0 0 1px 0,rgba(0,0,0,.1) 0 3px 4px 0;
color: black;
cursor: pointer;
display: inline-block;
font-family: Arial,sans-serif;
font-size: 1em;
height: 250px;
padding: 0 25px;
transition: all 200ms;}

.drops{display:none;}  .users{display:none} #news_data{display:none;}

.sidebar .nav-item .nav-link span{font-size:14px;font-weight:bold;text-transform:capitalize;}
.navbar-nav{background:#06308E;}

#panier{position:fixed;left:60%;top:15px;color:black;font-size:14px;background:black;
opacity:0.7;padding:1%;color:white;border-radius:5px;}
#society{width:40%;} .mobile{display:none;}

.parent-div {
  display: inline-block;
  position: relative;
  overflow: hidden;
}
.parent-div input[type=file] {
  left: 0;
  top: 0;
  opacity: 0;
  position: absolute;
  font-size: 50px;
}
.btn-upload {
  background-color: #fff;
  border: 1px solid #000;
  color: #000;
  padding: 5px 15px;
  border-radius: 10px;
  font-size: 18px;
  font-weight: bold;
}

#menu_s{margin-left:4%;}
#menu_s a {padding:3%;font-size:14px;color:black;font-weight:none;}
.menu_mobile{display:none;}
.btns{display:none;background:white;border-color:white;color:#7BCCF8;}
.error{color:red;font-weight:bold;font-size:12px;}

@media (max-width: 575.98px) { 
#panier{display:none} .s{display:block;}
#logo{display:none;} .side{display:none;} .bs{display:none;}.bg{display:none;}
.cont1,.cont12,.cont13,.cont14{display:block;width:250px;margin-top:8px;margin-left:7%;}
.cont2{display:block;width:250px;margin-top:10px;margin-left:8%;} .center{width:95%;height:2100px;}
ul{display:none;}
.bg-gradient-primary{display:none;} .contens,.contens1{display:block;width:250px;margin-top:10px;margin-left:8%;}
.drop{position:absolute;left:7%;width:300px;}
.drops{padding:2%;position:absolute;left:7%;width:340px;display:block;background:white;
height:2800px;overflow-y:scroll} h2{margin-top:30px;border-top:1px solid #eee;color:#06308E;font-size:15px;font-weight:bold;}
.us{margin-top:5px;border-bottom:1px solid #eee;color:black;}
#news_data{display:block;} #news{display:none;} .users{display:block;color:black;}
#searchDropdown{display:none;} #examp{width:90%;height:1700px;margin-top:15px;margin-left:-3%;}
.ts{display:none;} .mobile{display:block;}
#accordionSidebar{display:none;margin-top:-150px;width:120px;} 
.menu_mobile{padding:1%;color:black;width:75%;height:700px;background:white;position:absolute;top:60px;left:0px;z-index:4;padding:3%} 
.menu_mobile a {color:black;font-size:18px;font-size:18px;border-bottom:1px solid #eee;font-family:arial;padding:1%;} .nav{margin-top:30px;margin-left:7%;} .nv{padding-left:3%;font-size:16px;}
.xs{position:absolute;top:5px;left:3%;z-index:4;}
.btns{display:display:block;background:white;border-color:white;color:#7BCCF8;}
}

@media (min-width: 768px) and (max-width: 991px) {
#panier{display:none;}
#logo{display:none;} .side{display:none;} .bs{display:none;}.bg{display:none;}
#accordionSidebar{display:none;margin-top:-150px;width:120px;} .center{width:100%;margin:0;padding:0;height:1000px;}
cont1,.cont12,.cont13,.cont14,.titre{font-size:14px;}
 h2{margin-top:20px;border-top:1px solid #eee;color:black;}
.us{margin-top:5px;border-bottom:1px solid #eee;color:black;margin-left:10%;}
#news_data{display:block;} #news{display:none;} 
.users{display:block;color:black;font-family:arial;font-size:13px;} h2{margin-left:3%;}
#caisse{font-size:14px;} .tds,.tdv,.tdc{font-size:22px;font-weight:bold;}
.user{padding-left:7%;} .dtt,.dts{font-size:20px;} .h1{font-size:14px;}
.btn{display:block;} 
#examp{padding:3%;position:absolute;width:75%;height:1350px;z-index:3;left:15%;top:20px;background-color:white;border-radius:10px;}
.drop{position:absolute;width:300px;left:-20%;top:100px;background:white;}
.drops{padding:2%;position:absolute;left:-40%;width:500px;background:white;
height:2800px;overflow-y:scroll;z-index:5;}
.center{height:1700px;} #searchDropdown{display:none;}
#his{width:250px;margin-left:60%;height:40px;background:#4e73df;border:2px solid #4e73df;color:white;font-family:arial;border-radius:15px;}
.menu_mobile{padding:1%;color:black;width:35%;height:700px;background:white;position:absolute;top:60px;left:0px;z-index:4;padding:3%} 
.menu_mobile a {color:black;font-size:18px;font-size:18px;border-bottom:1px solid #eee;font-family:arial;padding:1%;} .nav{margin-top:30px;margin-left:7%;} .nv{padding-left:3%;font-size:16px;}
.xs{position:absolute;top:5px;left:3%;z-index:4;}
.btns{display:block;background:white;border-color:white;color:#7BCCF8;}
}


@media (min-width: 992px) and (max-width: 1200px) {
 #panier{display:none;}
#logo{display:none;} .side{display:none;} .bs{display:none;}.bg{display:none;}
#accordionSidebar{display:none;width:120px;margin-top:-150px;} .center{width:100%;margin:0;padding:0;height:1000px;}
cont1,.cont12,.cont13,.cont14,.titre{font-size:14px;}
 h2{margin-top:20px;border-top:1px solid #eee;color:black;}
.us{margin-top:5px;border-bottom:1px solid #eee;color:black;margin-left:10%;}
#news_data{display:block;} #news{display:none;} 
.users{display:block;color:black;font-family:arial;font-size:13px;} h2{margin-left:3%;}
#caisse{font-size:14px;} .tds,.tdv,.tdc{font-size:22px;font-weight:bold;}
.user{padding-left:7%;} .dtt,.dts{font-size:20px;} .h1{font-size:14px;}
.btn{display:block;} 
#examp{padding:3%;position:absolute;width:75%;height:1350px;z-index:3;left:15%;top:20px;background-color:white;border-radius:10px;}
.drop{position:absolute;width:300px;left:-20%;top:100px;background:white;}
.drops{padding:2%;position:absolute;left:-40%;width:500px;background:white;
height:2800px;overflow-y:scroll;z-index:5;}
.center{height:1700px;} #searchDropdown{display:none;}
#his{width:250px;margin-left:60%;height:40px;background:#4e73df;border:2px solid #4e73df;color:white;font-family:arial;border-radius:15px;}
.menu_mobile{padding:1%;color:black;width:30%;height:700px;background:white;position:absolute;top:60px;left:0px;z-index:4;padding:3%} 
.menu_mobile a {color:black;font-size:18px;font-size:18px;border-bottom:1px solid #eee;font-family:arial;padding:1%;} .nav{margin-top:30px;margin-left:7%;} .nv{padding-left:3%;font-size:16px;}
.xs{position:absolute;top:5px;left:3%;z-index:4;}
.btns{display:block;background:white;border-color:white;color:#7BCCF8;}
}




</style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include('inc_menu_principale.php');?>
        <!-- End of Sidebar -->
        

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <span id="sidebar" class="btns">
                        <i class="fa fa-bars"></i>
                    </span>

                    <!-- Topbar Search -->
                    <form
                        class="navbar-search">
                        <div class="input-group">
                            
                           <div class="inputs">
                               Ajouter un local  <button type="button" class="btn btn-primary" id="but">
                              +</button>
                            </div>

                        <div class="input"><select class="form-select form-select-sm" aria-label=".form-select-sm example">
                         <option value="">Type de logement</option>
						  <option value="1">chambre single</option><option value="2">chambre double</option>
                           <option value="3">chambre triple</option><option value="4">chambre twin</option><option value="5">chambre standard</option><option value="6">chambre deluxe</option>
                          <option value="7">studio double</option>
						  <option value="8">appartement meublé</option>
                          </select>
						  
                          </div>    
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- 404 Error Text -->
                    <div class="center">
					<?php
					
		// on recupere les variable existante $_SESSION 
        $smart_from =($page -1)*$record_peage;
   // emttre la requete sur le fonction
   if($_SESSION['code']!=0) {
    $req=$bds->prepare('SELECT id,id_chambre,chambre,type_logement,equipements,equipement,cout_nuite,cout_pass,icons,infos FROM chambre WHERE email_ocd= :email_ocd AND codes= :code ORDER BY id DESC LIMIT '.$smart_from.','.$record_peage.'');
    $req->execute(array(':code'=>$_SESSION['code'],
	                   ':email_ocd'=>$_SESSION['email_ocd']));
   }
   
   else{
	 $req=$bds->prepare('SELECT id,id_chambre,chambre,type_logement,equipements,equipement,cout_nuite,cout_pass,icons,infos FROM chambre WHERE email_ocd= :email_ocd  ORDER BY id DESC LIMIT '.$smart_from.','.$record_peage.'');
     $req->execute(array(':email_ocd'=>$_SESSION['email_ocd']));  
	 }
	
	$rem='<span class="ts"></span>';
	$rt=",";
	$rs='<span class="ts"><i style="font-size:12px" class="fa">&#xf00c;</i></span>';
				
                        echo'	<table id="tb">
     <thead>
     <tr class="tf">
      <th scope="col"><i class="material-icons" style="font-size:17px;color:#111E7F">home</i>Type de logement</th>
	  <th scope="col">Local désigné</th>
	  <th scope="col">Equipements principaux</th>
	   <th scope="col">Equipements secondaire</th>
	   <th scope="col">Nbrs occupants</th>
	  <th scope="col">Tarif</th>
	  <th scope="col">Description</th>
	  <th scope="col">Découvrir</th>
	  <th scope="col">Modifier</th>
	  <th scope="col">Supprimer</th>
      </tr>
      </thead>
      <tbody>';
       
	while($donnees = $req->fetch()) {
	
	// afficher dans un tableau les données des chambres
	 echo'<tr>
      <td> <span class="home">'.$donnees['type_logement'].'</span></td>
	  <td class="color">'.$donnees['chambre'].'</td>
	  <td><h3>équipements</h3><span class="div">'.str_replace($rt,$rem,$donnees['equipement']).'</span></td>
	  <td><i style="font-size:12px" class="fa">&#xf00c;</i> '.str_replace($rt,$rs,$donnees['equipements']).'
	  </td>
      <td>'.$donnees['icons'].'</td>
	  <td class="color">tarif/journalier<br/>'.$donnees['cout_nuite'].' xof<br/><br/>tarif/horaire<br/>'.$donnees['cout_pass'].'xof</td>
      <td>'.$donnees['infos'].'</td>
	  <td><a href="view_data_home.php?home='.$donnees['id_chambre'].'" title="plus d\'infos"><i class="fas fa-eye" style="font-size:13px"></i></a></td>
	  <td><a href="edit_data_home.php?home='.$donnees['id_chambre'].'" title="modifier"><i class="material-icons" style="font-size:13px">create</i></a></td>
	  <td><a href="#" data-id1='.$donnees['id_chambre'].' class="home"><i class="fas fa-trash"></i></a></td>
	  </tr>';
	}
	
	echo' 
      </tbody>
     </table>';
	 $req->closeCursor();
	 
	 // on compte le nombre de ligne de la table
   if($_SESSION['code']==0){
   $reg=$bds->prepare('SELECT count(*) AS nbrs FROM chambre WHERE email_ocd= :email_ocd');
   $reg->execute(array(':email_ocd'=>$_SESSION['email_ocd']));
   }
   
   else{
	  $reg=$bds->prepare('SELECT count(*) AS nbrs FROM chambre WHERE email_ocd= :email_ocd AND codes= :code');
      $reg->execute(array(':code'=>$_SESSION['code'],
	                      ':email_ocd'=>$_SESSION['email_ocd'])); 
   }
   $dns=$reg->fetch();
   $totale_page=$dns['nbrs']/$record_peage;
   $totale_page = ceil($totale_page);
   
   if($totale_page == 0){
	  $page =1;
     // rédirection  
   }
   
   echo'<div class="pied_page">';
   if($page > 1){
	  $page =$page-1;
	  echo'<div class="p"><a href="inventaire_gestion_home.php?page='.$page.'"><i class="fa fa-angle-left" aria-hidden="true" style="font-size=33px;color:black"></i></a></div>'; 
   }
   for($i=1; $i<=$totale_page; $i++) {
	    if($page!=$i){
	   echo'<div><a class="bout" href="inventaire_gestion_home.php?page='.$i.'">'.$i.'</a></div>';
		}
		
		else{
			echo'<a class="bouts">'.$i.'</a>';
		}
	}
	
	if($i > $page){
		$page =$page+1;
		echo'<div class="p"><a href="inventaire_gestion_home.php?page='.($page+1).'"><i class="fa fa-angle-right" aria-hidden="true" style="font-size=33px;color:black"></i></a></div>'; 
	}
	
	echo'</div>';
	
	
             ?>       
					</div>
    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <!-- Modal -->
 <div id="html"></div><!--affichage retour ajax-->
 <div  id="examp" style="display:none">
 <div id="error"></div><!--affichage erreur-->

  <form method="post" id="forms"  enctype="multipart/form-data">
  <h1><i class='fas fa-house-user'></i> Formulaire d'enregistrements des locaux</h1>
   
   <div class="form-row">
    <div class="form-group col-md-6">
	<h2><i style="font-size:16px" class="fa">&#xf044;</i> Informations des locaux</h2>
      <label for="inputPassword4">Type de local *</label>
      <select name="type" class="forms form-select-sm" aria-label=".form-select-sm example" required>
                           <option value="">Type de logement</option>
						   <option value="1">chambre single</option><option value="2">chambre double</option>
                           <option value="3">chambre triple</option><option value="4">chambre twin</option><option value="5">chambre standard</option><option value="6">chambre deluxe</option>
                          <option value="7">studio double</option>
						  <option value="8">appartement meublé</option>
                          </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Autre type</label>
      <input type="text" class="form-control" name="typs" id="inputEmail4" placeholder="">
    </div>
  

   <div class="form-group col-md-6">
      <label for="inputEmail4">Identifier votre local *</label>
      <input type="text" class="form-control" name="ids" id="ids" required placeholder="Ex: chambre A-01, chambre 2...">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Occupants possible *</label>
      <input type="number" class="form-control" id="num" name="num" placeholder="Ex 3">
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre de lits*</label>
      <input type="number" class="form-control" id="nums" name="nums" placeholder="">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Cout nuitée *</label>
      <input type="number" class="form-control" id="count" name="cout" placeholder="" required>
    </div>
    
	<div class="form-group col-md-6">
      <label for="inputPassword4">Cout pass </label>
      <input type="number" class="form-control" id="counts" name="couts" placeholder="">
    </div>
	
	<div class="form-group col-md-6">
      <label for="inputPassword4">Choix des sites </label>
     <select id="site" name="site" class="form-control">
        <option value="0">choisir</option>
		<option value="1">Site 1 </option>
		<option value="2">Site 2 </option>
		<option value="3">Site 3 </option>
      </select>
    </div>
	
	<div class="form-group col-md-6">
      <label for="inputPassword4">Identification des sites </label>
      <?php
		  if(count($data)==2 OR count($data)==3){
		$number =count($data)+1;
	       echo'<label><br/></label>
		   <select id="societ" name="societ" class="form-control" required>
		   <option selected value="0">Choisir un site </option>';
			for($i=0; $i< $number; $i++){
			$r = $i+1;
             echo'<option value="'.$data[$i].'">'.$data[$i].'</option>';
			}
            echo'</select>';			
		  }
		?>
    </div>
    
     <div class="form-group col-md-12">
        <h2><i style="font-size:14px" class="fa">&#xf044;</i> Informations des équipements principaux du local</h2>

      <div class="custom-checkbox">
      <input type="checkbox" name="ch[]"  value="<i style='font-size:13px' class='fa'>&#xf2dc;</i> climatisation"> <i style='font-size:13px' class='fa'>&#xf2dc;</i> Climatisation
     <input type="checkbox" name="ch[]"  value="<i style='font-size:13px' class='fa'>&#xf2dc;</i> ventilateur"> <i style='font-size:13px' class='fa'>&#xf2dc;</i> Ventilateur
	 <input type="checkbox" name="ch[]"  value="<i style='font-size:13px' class='fa'>&#xf108;</i> télévision"> <i style="font-size:13px" class="fa">&#xf108;</i> Télévision<input type="checkbox" name="ch[]"  value="<i style='font-size:14px' class='fa'>&#xf1eb;</i> wiffi">  <i style="font-size:14px" class="fa">&#xf1eb;</i> wifi</td> <input type="checkbox" name="ch[]"  value="<i style='font-size:14px' class='fa'>&#xf2a2;</i> salle de baim"> <i style="font-size:14px" class="fa">&#xf2a2;</i> Salle de bains
     <input type="checkbox" name="ch[]" value="<i style='font-size:16px' class='fas'>&#xf0f4;</i> Déjeuner"> <i style='font-size:14px' class='fas'>&#xf0f4;</i> Déjeuner
	 <input type="checkbox" name="ch[]" value="<i style='font-size:16px' class='fas'>&#xf0f4;</i> Frigo/réfrigerateur"> <i style='font-size:14px' class='fas'>&#xf0f4;</i> Frigo/réfrigérateur 
	 <input type="checkbox" name="ch[]" value="<i style='font-size:16px' class='fas'>&#xf0f4;</i> Four/chauffage"> <i style='font-size:14px' class='fas'>&#xf0f4;</i> Four/chauffage
	 </div>
	 
	 <h2><i style="font-size:14px" class="fa">&#xf044;</i> Informations des équipements secondaires du local</h2>
    <input type="checkbox" name="choix[]"  value="toilletes"> Toillete
    <input type="checkbox" name="choix[]"  value="armoie ou penderie"> Armoire ou penderie  
   <input type="checkbox" name="choix[]" value="chaines satellite"> Chaines satellite
   <input type="checkbox" name="choix[]"  value="prise près de lit"> Prise  de lit <input type="checkbox" name="choix[]"  value="espace pour pc"> espace pour pc</td> 
    <input type="checkbox" name="choix[]"  value="baignoire ou douche"> Baignoire ou douche 
	<input type="checkbox" name="choix[]"  value="fer à repasser"> Article de toilletes 
	<input type="checkbox" name="choix[]"  value="radio"> Radio
   <input type="checkbox" name="choix[]"  value="télephone"> Télephone
   <input type="checkbox" name="choix[]"  value="microonde"> Microonde
   <input type="checkbox" name="choix[]"  value="réfrigérateur"> Réfrigerateur
    <input type="checkbox" name="choix[]"  value="machine à laver"> Machine à laver<br/>
     <input type="checkbox" name="choix[]"  value="papier toillete"> Papier toillete
    <input type="checkbox" name="choix[]"  value="séche cheveux"> Séche cheveux
   <input type="checkbox" name="choix[]"  value="petit café">  Petit café
   <input type="checkbox" name="choix[]" value="déjeuner"> Déjeuner
	</div>
      
    </div>
	
	<h2><i style="font-size:14px" class="fa">&#xf044;</i> Informations complémentaires (facultatives)</h2>
  <div class="form-group">
    <label for="exampleFormControlTextarea1"></label>
    <textarea class="form-control" name="infos" id="infos" rows="3"></textarea>
   </div>
	
  <h2><i class="fas fa-camera"></i>Photos des locaux (6 photos maximum)</h2>
  <div class="parent-div">
      <button class="btn-upload">Ajouter une image</button>
      <input type="file" name="fil[]" id="file1" />
    </div>
	<div class="parent-div">
      <button class="btn-upload">Ajouter une image</button>
      <input type="file" name="fil[]" id="file2" />
    </div>
	
	<div class="parent-div">
      <button class="btn-upload">Ajouter une image</button>
      <input type="file" name="fil[]" id="file3" />
    </div>
	
	<div class="parent-div">
      <button class="btn-upload">Ajouter une image</button>
      <input type="file" name="fil[]" id="file4" />
    </div>
	
	<div class="parent-div">
      <button class="btn-upload">Ajouter une image</button>
      <input type="file" name="fil[]" id="file5" />
    </div>
	
	<div class="parent-div">
      <button class="btn-upload">Ajouter une image</button>
      <input type="file" name="fil[]" id="file6" />
    </div>
  
  <div><input type="submit" value="enregistrer le local" id="his"/></div>
<input type="hidden" name="token" id="token" value="<?php
//Le champ caché a pour valeur le jeton
echo $_SESSION['token'];?>">
  </form><!--fin du form-->
  </div>

 </div>

<!-- div delete home-->
<div id="block_delete" style="display:none">
<h3>êtes-vous sûr de vouloir supprimer ce local ?</h3>
<form method="post" id="envoi" action="">

<input type="hidden" name="ids" id="ids">
<input type="hidden" name="token" id="token" value="<?php
//Le champ caché a pour valeur le jeton
echo $_SESSION['token'];?>">
</form>
<button type="button" id="button_delete">ok</button>

</div>

<div id="data_delete"></div><!--retour ajax-->

<!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; optimisation de comptabilité à distance 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->


<!--div black-->
<div id="pak" style="display:none"></div>
<div id="panier"></div><!--retour panier facturation-->
<?php include('inc_menu.php');?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <?php include('inc_foot_scriptjs.php');?>
  <script type="text/javascript">
   $(document).ready(function(){
   $('#navs').click(function(){
	$('.collapse').slideToggle();
	 });

    $('#sidebar').click(function(){
		$('#pak').css('display','block');
		$('.menu_mobile').css('display','block');
		$('.xs').css('display','block');
	 });
	 
	 $('.xs').click(function(){
	 $('.menu_mobile').css('display','none');
	 $('#pak').css('display','none');
	 $('.xs').css('display','none');
	 });
   
   
   $('#sidebar').click(function(){
		$('#pak').css('display','block');
		$('.menu_mobile').css('display','block');
	 });
	 
   $('#sms').click(function(){
	$('.drop').slideToggle();
	});

   $('#but').click(function(){
   $('#examp').css('display','block');
   $('#pak').css('display','block');
 });
 
 $('#pak').click(function(){
	$('#examp').css('display','none');
   $('#pak').css('display','none');
   $('#block_delete').hide(); 
   $('.menu_mobile').css('display','none');   
 });
 
 $('#button_annuler').click(function(){
	 $('#pak').css('display','none');
   $('#block_delete').hide(); 
 });
 
 $('#forms').on('submit', function(event) {
 event.preventDefault();
 var form_data =$(this).serialize();
  var regex = /^[a-zA-Z0-9]{2,15}(\s[a-zA-Z0-9]{2,20}){0,4}$/;
 var rege = /^[a-zA-Z0-9-]{2,15}(\s[a-zA-Z0-9-]{2,15}){0,3}$/;
 var number = /^[0-9]{1,2}$/;
 var inf = /^[a-zA-Z0-9éàèçé]{0,130}$/;
 var info = /^[a-zA-Z0-9éàèçé]{0,130}$/;
 var expres = /^[chambreAppartement]{1,25}(\s[0-9ABCDEA-B-C-]{1,4})$/;
// on ecrits les variable
var ids =$('#ids').val();
var num =$('#num').val();
var nums =$('#nums').val();
var infos = $('#infos').val();
var societ = $('#societ').val();

 if(ids.length> 50) {
	$('#error').html('<i class="material-icons" style="font-size:22px;color:red;padding-left:-2%;font-weight:bold;">help_outline</i>nombre max de caractère est de 50 nom du client');
	}
	
	else if(num.length > 4) {
	$('#error').html('<i class="material-icons" style="font-size:22px;color:red;padding-left:-2%;font-weight:bold;">help_outline</i>le nombre de d\'occupants possible ne dépasse pas 5');
	}
	
	else if(nums.length > 5) {
	$('#error').html('<i class="material-icons" style="font-size:22px;color:red;padding-left:-2%;font-weight:bold;">help_outline</i>le nombre de lits  possible ne dépasse pas 5');
	}
	
	else if(num < 0){
	}
	
	else if(nums < 0) {
	}
	
	else if (!number.test(num)){
      $('#error').html('<i style="font-size:15px;color:red;" class="fa">&#xf05e;</i> erreur de syntaxe sur le nombre compris en 1 et 9 ');
      $('#num').css('border-color','red');
	}
	
	else if (!number.test(nums)){
      $('#error').html('<i style="font-size:15px;color:red;" class="fa">&#xf05e;</i> erreur de syntax sur le nombre compris entre 1et 9');
      $('#nums').css('border-color','red');
	}
	
	else if (!expres.test(ids)){
      $('#error').html('<i style="font-size:15px;color:red;" class="fa">&#xf05e;</i>vos locaux est sous forme de chambre 1 ou appartement 1 ou chambre 10, appartement 10 , chambre B-01, appartement B-01');
      $('#ids').css('border-color','red');
	}
	
	else if (infos.length >200){
      $('#error').html('<i style="font-size:15px;color:red;" class="fa">&#xf05e;</i> nombre de caractères pour les informations ne peuvent pas dépasser 200');
      $('#infos').css('border-color','red');
	}
	
	else{

  $.ajax({
	type:'POST', // on envoi les donnes
	async: false,
	url:"enregistrer_liste.php",
    data:new FormData(this),
	contentType:false,
	processData:false,
	success:function(data) {
	$('#html').html(data);
	$('#forms').css('display','none');
	$('#examp').css('display','none');
	load();
	}
   });
   
   setInterval(function(){
		 $('#html').html('');
		 location.reload(true);
	 },3000);
	 
   }

}); 
	
 // delete home--
 $(document).on('click','.home', function(){
	 // recupere la variable
	 var id = $(this).data('id1');
	 var action = "deleted";
    // affiche les differentes
	$('#block_delete').css('display','block');
    $('#pak').css('display','block');
	$('#ids').val(id);
	
	$(document).on('click','#block_delete', function(){
	$.ajax({
	type:'POST', // on envoi les donnes
	url:'data_delete.php',// on traite par la fichier
	data:{id:id,action:action},
	success:function(data) { // on traite le fichier recherche apres le retour
     $('#data_delete').html(data);
     $('#block_delete').css('display','none');
     $('#pak').css('display','none');
	}
		
	});

 });
 
 });
 
 // pagintion
  $(document).on('click','.bout',function(){
	  var page =$(this).attr("id");
	  load(page);
   });
   
   
   
  // afficher le pannier
  function panier() {
				var action="panier";
				$.ajax({
					url: "session_panier.php",
					method: "POST",
					data:{action:action},
					success: function(data) {
						$('#panier').html(data);
					}
				});
			}

			panier();
 
			
			
	$(document).on('click','.bout',function(){
	   	var id = $(this).attr("id");
      // on affiche la div
       $('#1').css('color','blue');
       
	   for(id-1; id <5000; id++){
        $('#'+id).css('display','none');
        }

        for(5000; id > 0; id--){
        $('#'+id).css('display','none');
        }	
		 			
		 	
	 });
		
		
	});
	
</script>
</body>

</html>