<?

function xxx($db){
?>
<!---menu--->
	<div class="menu">
		<ul>
			<li><a href="?menu=0">odhl�sit</a></li>
			
		</ul>
	</div>
<!---content--->
	<div class="center_content">


<?
$query="SELECT * FROM pecivo";
$result = @mysql_query($query,$db);

?>

<!---left content--->
		<div class="center_left">
			
<? while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<form method="POST" >
<input type="hidden" name="pridat_info" value="<?php echo $data["id"]?>">
<div class="shop">
<div class="shop_title"><?php echo $data["nazev"]?></div>
				<div class="shop_body"><?php echo $data["cena"]?>K�<br><input type="text" value="1" name="pocet" class="shop_ks">ks<input type="submit" value="do ko��ku"></div>
			</div>
</form>

<?}?>

	
			<input type="submit" value="objednat" class="cudlik">
			</form>
				
				
		</div> 



<!---right content--->
		<div class="center_right">
			
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
<!---wait for content--->
		<div class="clear"></div> 
	</div>
<!---footer--->
	<div id="footer">
		<div class="left_footer"></div>

<?

}?>



<?

function zakaznik($db){
?>
<!---menu--->
	<div class="menu">
		<ul>
			<li><a href="?menu=0">odhl�sit</a></li>
			
		</ul>
	</div>
<!---content--->
	<div class="center_content">




<?
  
$zpusob_dodani = array(
        "rozvoz",
        "osobne" );
      $zpusob_platby = array(
        "hotovost",
        "kartou" 
      );


?>
<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>
				
				<tr><td>Zp�sob platby:</td><td>   
<?   
echo "  <select name='platba'>\n";
foreach ($zpusob_platby as $key => $druh) {
	echo "<option value='$key'";
        echo">$druh</option>\n";

}
echo "</select>\n";
?>
</td></tr>				
				
<tr><td>Zp�sob dod�n�:</td><td>   
<?   
echo "  <select name='dodani'>\n";
foreach ($zpusob_dodani as $key => $druh) {
	echo "<option value='$key'";
        echo">$druh</option>\n";

}
echo "</select>\n";
?>
</td></tr>


				<tr><td><input type="submit" name="zacit_nakupovat" value="za��t nakupovat"></td><td></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<!---wait for content--->
		<div class="clear"></div> 
	</div>
<!---footer--->
	<div id="footer">
		<div class="left_footer"></div>

<?

}?>

<?
function www($num,$db){
/// menu
?>

<!---menu--->
	<div class="menu">
		<ul>
			<li <?if($num==0){?>class="selected"<?}?>><a href="?menu=0">home</a></li>
			<li <?if($num==1){?>class="selected"<?}?>><a href="?menu=1">o n�s</a></li>
			<li <?if($num==2){?>class="selected"<?}?>><a href="?menu=2">produkty</a></li>
			<li <?if($num==3){?>class="selected"<?}?>><a href="?menu=3">dovoz</a></li>
			<li <?if($num==4){?>class="selected"<?}?>><a href="?menu=4">kontakt</a></li>
		</ul>
	</div>
<!---content--->
	<div class="center_content">

<?
////////////////////////////////////////////////
//// obsah stranek
///////////////////////////////////////////
switch($num){
case 0:
?>
<!---left content--->
		<div class="center_left">
			<div class="welcome_box">
				<p class="welcome"><span class="orange">V�tejte v pek�rn� U Dvou vol�,</span><br />
					jsme rodinn� podnik s dlouholetou tradic�. Nab�z�me velkou �k�lu produkt� od rohl�k� p�es chleby a� po buchty. Produkty je mo�n� odeb�rat na na�em v�dejn�m m�st� v Brn� nebo je zde mo�nost dovozu do Va�� destinace.
				</p>
			</div>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
<? break;
case 1:
?>

<!---left content--->
		<div class="center_left">
			<div class="welcome_box">
				<p class="welcome">
					Jsme firma s dlouholetou tradic�. Nab�z�me rohl�ky, chleba, koblihy, buchty a v�no�ky. Produkty je mo�n� odeb�rat p��mo na v�dejn�m m�st� nebo je zde mo�nost pravideln�ch rozvoz� a� do Va�� provozovny. Tady by je�t� mohla b�t spousta textu o n�s, ale u� nev�m, co tu m�m vym��let, tak�e to asi bude v�echno. :-)
				</p>
			</div>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
<?break;
case 2:

$query="SELECT * FROM pecivo";
$result = @mysql_query($query,$db);

?>

<!---left content--->
		<div class="center_left">
			
<? while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<form method="POST" >
<input type="hidden" name="pridat_info" value="<?php echo $data["id"]?>">
<div class="shop">
<div class="shop_title"><?php echo $data["nazev"]?></div>
				<div class="shop_body"><?php echo $data["cena"]?>K�<br></div>
			</div>
</form>

<?}?>



				
				
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?menu=7">p�ihl�sit</a></li>
                                <li><span></span><a href="?menu=6">registrovat</a></li>
				
			</ul>
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
   <?break;
case 3:

?>

<!---left content--->
		<div class="center_left">
			<div class="welcome_box">
				<p class="welcome"><span class="orange">Nab�z�me pravideln� rozvoz do n�kolika r�zn�ch oblast�:</span><br />
				<ul>


<?
//////////////////////////////

$query="SELECT * FROM oblast";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<li><?echo$data["jmeno"]; ?>

<?}
?>
				</ul>
				</p>
			</div>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
<?break;
case 4:

?>

<!---left content--->
		<div class="center_left">
			<div class="welcome_box">
				<p class="welcome">
					Bo�et�chova 2 <br>
					Brno, Kr�lovo pole <br><br>
					telefon: 777 123 456 <br>
					email: <a href="mailto:xzaklo00@stud.fit.vutbr.cz">xzaklo00@stud.fit.vutbr.cz</a>
				</p>
			</div>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<?break;
case 5:
?>

<!---left content--->
		<div class="center_left">
			<form method="POST"><div class="text_box">
				<div class="title">P�ihl�en�</div>
				<div class="login_form_row"><label class="login_label">Jm�no:</label><input type="text" name="name" class="login_input" /></div>
				<div class="login_form_row"><label class="login_label">Heslo:</label><input type="password" name="pass" class="login_input" /></div>
				<input type="submit" value="login" class="cudlik" />
			</div></form>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>




<?break;
case 6:
  

?>
<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>
				<tr><td>Jm�no:</td><td><input type="text" name="jmeno" ></td></tr>
				<tr><td>P��jmen�:</td><td><input type="text" name="prijmeni"></td></tr>
				<tr><td>Adresa:</td><td><input type="text" name="adresa"></td></tr>
                                <tr><td>Login:</td><td><input type="text" name="login"></td></tr>
                                <tr><td>Heslo:</td><td><input type="text" name="heslo"></td></tr>
				
			


				<tr><td><input type="submit" name="ulozit_zakaznik" value="ulo�it"></td><td></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>


<?break;
case 7:
?>

<!---left content--->
		<div class="center_left">
			<form method="POST"><div class="text_box">
				<div class="title">P�ihl�en�</div>
				<div class="login_form_row"><label class="login_label">login:</label><input type="text" name="zname" class="login_input" /></div>
				<div class="login_form_row"><label class="login_label">Heslo:</label><input type="password" name="zpass" class="login_input" /></div>
				<input type="submit" value="login" class="cudlik" />
			</div></form>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>



<?
}//////////////////////
/////zapati
/////////////////////
?>
<!---wait for content--->
		<div class="clear"></div> 
	</div>
<!---footer--->
	<div id="footer">
		<div class="left_footer"><a href="?menu=0">home</a> <a href="?menu=5">zam�stnanec</a><a href="?menu=4">kontakt</a></div>
<?

}?>
