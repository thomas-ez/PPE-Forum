<?php
	include_once("HeaderForum.php");
	include("datamanagers/compteManager.php");
	include("datamanagers/messageManager.php");
	include("datamanagers/DatabaseLinker.php");
	include("datamanagers/fildediscussionManager.php");
	if (!empty($_GET["index"])) 
	{
		session_start();  
		if(isset($_SESSION["idUser"]))  
		{
			if (!empty($_POST["delete"])) 
			{
				messageManager::deleteMessage($_POST["delete"]);
			}
			if (!empty($_POST["bandef"])) 
			{
				compteManager::banCompteDef($_POST["bandef"]);
			}
			$utilisateur = new Compte();
			$utilisateur->initCompte($_SESSION["idUser"]);
			$nom = $utilisateur->getNomCompte();
			include("BarreDeNavCo.php");
			?>
			<?php
					/*<div class="gauche">
					<div class="profilCard">
				        <div class="Container">
					        <h4 class="TitreProfil">Mon profile</h4>
					        <p class="Avatar"><img src="https://www.shareicon.net/data/2016/09/01/822739_user_512x512.png" class="imageCercle" alt="pp"></p>
					        <hr>
					        <p><i class="description"></i><i class="fas fa-address-card"></i><?php echo ' '.$utilisateur->getNomCompte(); ?></i></p>
					        <p><i class="description"><i class="far fa-calendar-alt"></i><?php echo ' '.$utilisateur->getDateCreation(); ?></i></p>
					        <p><i class="description"><i class="fas fa-comments"></i><?php echo ' '.$utilisateur->getIdMessage().' messages'; //mettre un count(methode)?></i>
					        </p> 
				        </div>
			        </div>
				</div>*/
			$id = $_GET["index"];
			$fildediscussion = new FilDeDiscussion();
			$fildediscussion->getIdFilDeDiscussionWithId($id);
			$createur = FilDeDiscussion::getCreateurWithId($id);
			if (!empty($_POST["message"]))
			{
				$msg = new Message();
				$msg->setLibelle($_POST["message"]);
				$msg->setIdAuteur($_SESSION["idUser"]);
				$msg->setIdFilDeDiscussion($id);
				messageManager::insertMessage($msg);
			} 
			if ($_GET["index"])
			{ 
				echo '<h1>';
				if ($fildediscussion->getIsFilDeDiscussionClos())
				{
					echo "[Résolu] ";
				} 
				echo $fildediscussion->getTitreFilDeDiscussion().'</h1>';
				$msg = fildediscussionManager::findAllMessage($id);
				echo '<p>Crée par : <a style="color: white; text-decoration: none;" href="profil.php?idProfil='.$fildediscussion->getIdCreateur().'">'.$createur->getNomCompte().'</a></p>';
				echo '<p>le : '.$fildediscussion->getDateCreation().'</p>';
				echo '<p>'.sizeof($msg)." message(s)".'</p>';
				echo '<hr>';
				echo "<br>";
				$user = new Compte();
				
				foreach ($msg as $linemsg) 
				{
			        if (compteManager::isCompteBan($linemsg->getIdAuteur())) 
			        {
			        	messageManager::deleteMessage($linemsg->getIdMessage());
			        	header('location: Forum.php?index='.$_GET["index"]);
			        	exit();
			        }
			        else
			        {
			    	?>
			    	
			    	<div class="messages"><br>
			  			<div class="topMsg">
					        <?php
					        $user->initCompte($linemsg->getIdAuteur());
			  				if ($user->getCheminPhoto()==NULL)
			  				{
			  					echo '<img src="image/pp/user.png" alt="Avatar" class="avatar">';
			  				}
					        else
					        {
					        	echo '<img src="'.$user->getCheminPhoto().'"alt="Avatar" class="avatar">';
					        }
					        ?>
					        <div class="titreNomCompte"><a style="color: black; text-decoration: none;"<?php echo 'href="profil.php?idProfil='.$linemsg->getIdAuteur().'"'?><h4><?php echo ' '.$user->getNomCompte(); ?></h4></a></div><br>
					        
					    </div>
				        <hr>
				        <div = class="contentMsg">
				        	<p><?php echo $linemsg->getLibelle(); ?></p>
				        	<div class="leftBouton">
					        	<div class="bouton">
					        		<?php
						        if ($utilisateur->getIsCompteAdmin())
						        {

									echo '
									<form method="POST">
										<div>
											<button name = "delete" value = "'.$linemsg->getIdMessage().'"><i class="fas fa-minus"></i> Supprimer</button>';
											if ($utilisateur->getIdCompte()!=$user->getIdCompte()&&!$user->getIsCompteAdmin()) 
											{
												echo '<button><a style = "text-decoration:none; color : white;" href="bantemp.php?idCompte='.$linemsg->getIdAuteur().'"><i class="fas fa-user-times"></i> bannir temporairement</a></button>';
												echo '<button name ="bandef" value = "'.$linemsg->getIdAuteur().'"><i class="fas fa-user-slash"></i> bannir def</button>';
											}
											else if($utilisateur->getIdCompte()==$user->getIdCompte()&&!$fildediscussion->getIsFilDeDiscussionClos())
											{
												echo
												'<button><a style = "text-decoration:none; color : white;"href = "modifMessage.php?id='.$linemsg->getIdMessage().'" > Modifier</a></button>';
											}
										echo '</div>
									</form>';
								}
								elseif ($utilisateur->getIdCompte()==$user->getIdCompte()) 
								{

									echo '<form method="POST">
											<div>
												<button name = "delete" value = "'.$linemsg->getIdMessage().'"><i class="fas fa-minus"></i> Supprimer</button>
												<button><a style = "text-decoration:none; color : white;"href = "modifMessage.php?id='.$linemsg->getIdMessage().'" > Modifier</a></button>
											</div>
										</form>';
								}
							}
					        ?>
				        		</div>
				        	</div>
				        </div>
			    	</div>
			    	<?php
				}
				?>
				<?php 
				if ($fildediscussion->getIsFilDeDiscussionClos()) 
				{
					?>
					<img src="image/resolu.png">
					<?php
				}
				else
				{
					?>
					<h2>Ajouter un commmentaire</h2>
					<form method="POST">
						<div class="postCom">
							<textarea name="message"></textarea>
							<br>
							<button>Commenter</button>
							<br>
						</div>
					</form>
				<?php
				}
				?>
				

			<?php
			}
		}
		elseif(!isset($_SESSION["idUser"]))
		{
			include("BarreDeNavNonCo.php");
			$id = $_GET["index"];
			$fildediscussion = new FilDeDiscussion();
			$fildediscussion->getIdFilDeDiscussionWithId($id);
			$createur = FilDeDiscussion::getCreateurWithId($id);
			if ($_GET["index"])
			{ 
				echo '<h1>';
				if ($fildediscussion->getIsFilDeDiscussionClos())
				{
					echo "[Résolu] ";
				} 
				echo $fildediscussion->getTitreFilDeDiscussion().'</h1>';
				$msg = fildediscussionManager::findAllMessage($id);
				echo '<p>Crée par : <a style="color: white; text-decoration: none;" href="profil.php?idProfil='.$fildediscussion->getIdCreateur().'">'.$createur->getNomCompte().'</a></p>';
				echo '<p>le : '.$fildediscussion->getDateCreation().'</p>';
				echo '<p>'.sizeof($msg)." message(s)".'</p>';
				echo '<hr>';
				echo "<br>";
				$utilisateur = new Compte();
				
				foreach ($msg as $linemsg) 
				{
			    	?>
			    	<div class="messages"><br>
			  			<div class="topMsg">
					        <?php 
					        $utilisateur->initCompte($linemsg->getIdAuteur());
			  				if ($utilisateur->getCheminPhoto()==NULL)
			  				{
			  					echo '<img src="image/pp/user.png" alt="Avatar" class="avatar">';
			  				}
					        else
					        {
					        	echo '<img src="'.$utilisateur->getCheminPhoto().'"alt="Avatar" class="avatar">';
					        }
					        ?>
					        <div class="titreNomCompte"><a style="color: black; text-decoration: none;"<?php echo 'href="profil.php?idProfil='.$linemsg->getIdAuteur().'"'?><h4><?php echo ' '.$utilisateur->getNomCompte(); ?></h4></a></div><br>
					    </div>
				        <hr>
				        <div = class="contentMsg">
				        	<p><?php echo $linemsg->getLibelle(); ?></p>
				        	<div class="leftBouton">
					        	<div class="bouton">
					        		<?php //echo $linemsg->get ?>
				        			<br>
				        		</div>
				        	</div>
				        </div>
			    	</div>
			    	<?php
				}
				
			}
			?>
			<p class="messageCo"><a href="indexLogin.php">Inscrivez-vous </a>ou <a href="indexLogin.php">connectez-vous </a>pour commenter</p>
			<?php
		}
?>
<?php
	}
	include("footer.php");
	?>
