<?php
	include("header.php");
	include("datamanagers/DatabaseLinker.php");
	include("data/fildediscussion.php");
	include("data/compte.php");
	include("data/message.php");
?>
<?php
	if (isset($_SESSION["idUser"])) 
	{
		include("BarreDeNavCo.php");
	}
	else
	{
		include("BarreDeNavNonCo.php");
	}
?>
<div class="page">
	<div class="partgauche">
		<img class = "pub" src="https://data.whicdn.com/images/177181124/original.jpg">
		<img class="pub" src="https://pbs.twimg.com/media/EAjs3ZEXoAEON26.jpg">
	</div>
	<div class="milieu">
        <?php
        	$typeTriFilDeDiscussion = "dateOuverture ASC";
			$tabFilDeDiscussion = FilDeDiscussion::getAllFilDeDiscussion($typeTriFilDeDiscussion);
			$taille = sizeof($tabFilDeDiscussion)/6;
			$reste = fmod(sizeof($tabFilDeDiscussion),6);
			if (empty($_GET["pages"])|| $_GET["pages"]=="1")
			{
				for ($i=1; $i < 12; $i++) 
	            { 
					$fildediscussion = new FilDeDiscussion();
					$fildediscussion->getIdFilDeDiscussionWithId($i);
					$createur = FilDeDiscussion::getCreateurWithId($i);
			        echo '<a class="lien" href="Forum.php?index='.$fildediscussion->getIdFilDeDiscussion().'">';
						echo '<div class="box">';
							echo '<div class="Content">';
								echo '<img class="imageTheme" src="image/Theme/'.$fildediscussion->getThemeFilDeDiscussion().'.png">';
								echo '<div>';
									echo'<div class="titre">'.$fildediscussion->getTitreFilDeDiscussion().'</div>';
									echo '<div class="sousTitre">'.'Createur : '.$createur->getNomCompte().' Theme : '.$fildediscussion->getThemeFilDeDiscussion().' date ouverture : '.$fildediscussion->getDateCreation().'</div>';
								echo '</div>
							</div>
						</div>
					</a>';
				}
			}
			$cpt=12;
			if (!empty($_GET["pages"])) 
			{
				if ($_GET["pages"]=="2") 
				{
					for ($i=$cpt; $i < $cpt+12; $i++) 
		            { 
						$fildediscussion = new FilDeDiscussion();
						$fildediscussion->getIdFilDeDiscussionWithId($i);
						$createur = FilDeDiscussion::getCreateurWithId($i);
						if (!empty($fildediscussion->getIdFilDeDiscussion())) 
						{
							echo '<a class="lien" href="Forum.php?index='.$fildediscussion->getIdFilDeDiscussion().'">';
								echo '<div class="box">';
									echo '<div class="Content">';
										echo '<img class="imageTheme" src="image/Theme/'.$fildediscussion->getThemeFilDeDiscussion().'.png">';
										echo '<div>';
											echo'<div class="titre">'.$fildediscussion->getTitreFilDeDiscussion().'</div>';
											echo '<div class="sousTitre">'.'Createur : '.$createur->getNomCompte().' Theme : '.$fildediscussion->getThemeFilDeDiscussion().' date ouverture : '.$fildediscussion->getDateCreation().'</div>';
										echo '</div>
									</div>
								</div>
							</a>';
						}
				        
					}
				}
			}
            
			$nbpages = $taille;
				
			?>
		
	</div>
	<div class="partdroite">
		<img class="pub" src="https://media.discordapp.net/attachments/535910358078980172/676726300110618645/DS8NwTEX0AAs8Kl.jpg?width=674&height=943">
		<img class="pub" src="https://kimhandysidesvoiceover.com/wp-content/uploads/2017/08/Colget-Funny-Commercial-Picture.jpg">
	</div>
</div>

<div class="bas">
	<?php  
  	for ($i=1; $i < $nbpages+1; $i++) 
  	{ 
  		echo '<a href="index.php?pages='.$i.'" class="nbPages">'.$i.'</a>';
  	}
	?>
</div>
<?php
	include("footer.php");
?>