<?



function session_timeout() {
  if (isset($_SESSION['last_activity'])) {
    
    if ((time() - $_SESSION['last_activity']) > 60*60) {
      unset($_SESSION['login']);
      session_unset();
      session_destroy()
      ?>
        <script>
          window.location.href="index.php";
        </script>
      <?
    }
  }
}




function zamestnanci($x,$db,$t){
?>
<!---menu--->
  <div class="menu">
    <ul>
      <li <?if($x==1){?>  class="selected"<?}?>><a href="?z=1">objedn�vky</a></li>
      <li <?if($x==2){?>  class="selected"<?}?>><a href="?z=2" >produkty</a></li>
      <li <?if($x==3){?>  class="selected"<?}?>><a href="?z=3" >oblasti rozvozu</a></li>
      <li <?if($x==4){?>  class="selected"<?}?>><a href="?z=4" >�idi�i</a></li>
      <?if($t==1){?>  <li <?if($x==5){?>  class="selected"<?}?>><a href="?z=5">zam�stnanci</a></li> <?}?>
      <li><a href="?z=20">odhl�sit</a></li>
    </ul>
  </div>
<!---content--->
  <div class="center_content">

<?
////////////////////////////
// obsah stranek
///////////////////////////
  switch($x){
    case 0:
?>

     <!---left content--->
       <div class="center_left">
         <div class="welcome_box">
           <?if($t==2){?> <p class="welcome">V�tejte v administraci! P�ihl�en� prob�hlo �sp�n�. Jste p�ihl�en jako zam�stnanec.<?}?>
           <?if($t==1){?> <p class="welcome">V�tejte v administraci! P�ihl�en� prob�hlo �sp�n�. Jste p�ihl�en jako administr�tor.<?}?>
           </p>
         </div>
       </div> 
       <!---right content--->
         <div class="center_right">
           <div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
         </div>

<?
    break;
    case 1:
?>


    <!---left content--->
      <div class="center_left">
        <table >
          <tr><th>ID</th><th>datum objedn�n�</th><th>zp�sob dod�n�</th><th>zp�sob platby</th><th>cena</th><th></th><th></th></tr>
<?
      $result_pecivo = @mysql_query("SELECT * FROM pecivo", $db);

      $pecivo = array();

      while ($data_pecivo = mysql_fetch_array($result_pecivo, MYSQL_ASSOC)) {
       $pecivo[$data_pecivo["id"]] = $data_pecivo["cena"];

      }

      $zpusob_dodani = array(
        "rozvoz",
        "osobne" 
	
      );
      $zpusob_platby = array(
        "hotovost",
        "kartou" 
      );


      /////SELECT/////////////////////////
      $query="SELECT * FROM objednavka ";
      $result = @mysql_query($query,$db);
      while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $result_obj_pecivo = @mysql_query("SELECT * FROM obj_pecivo where objednavka = '" . $data["id"] . "'", $db);
        $cena = 0;
        while ($data_obj_pecivo = mysql_fetch_array($result_obj_pecivo, MYSQL_ASSOC)) {
          $cena += $data_obj_pecivo["pocet"] * $pecivo[$data_obj_pecivo["pecivo"]];

        }
        
?>
        <tr><td><?echo ($data["id"])?></td><td><?echo ($data["datum"])?></td><td><?echo ($zpusob_dodani[$data["zpusob_dodani"]])?></td><td><?echo ($zpusob_platby[$data["zpusob_platby"]])?></td><td><?php echo$cena?></td></tr>
<?  
      }
?>			
         </table>
         <br /><br />
         <form method="POST" ><tr><td>Objedn�vka</td><td>
           <select name="id_upravit_objednavka">
<?
        //////////////////////////////
       $result = @mysql_query($query,$db);
       while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?> 
         <option value="<?echo($data["id"]);?>"><?echo($data["id"]); ?></option>

<?
       }
?>

           </select>
             <input type="submit" name="upravit_objednavka" value="upravit"> <input type="submit" name="smazat_objednavka" value="smazat">
         </form>


    </div> 
    <!---right content--->
    <div class="center_right">
      <div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
    </div>

<?
break;
case 2:?>

<!---left content--->
		<div class="center_left">
			<table >
				<tr><th>id</th><th>n�zev</th><th>cena (K�)</th><th></th><th></th></tr>
<?
//////////////////////////////
$query="SELECT * FROM pecivo ";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>

<tr><td><?echo ($data["id"])?><td><?echo ($data["nazev"])?></td><td><?echo ($data["cena"])?></td><td></tr>



<?}//////?>



			</table>
<br /><br />
 <form method="POST" ><tr><td>Pecivo</td><td><select name="id_upravit_pecivo">
<?
//////////////////////////////

$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?> 
<option value="<?echo($data["id"]);?>"><?echo($data["id"]);   ?></option>

<?}//////////////////////////////////
?>

</select>

				<input type="submit" name="upravit_pecivo" value="upravit"> <input type="submit" name="smazat_pecivo" value="smazat">
</form>

		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?z=6">p�idat produkt</a></li>
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<?
break;
case 3:
?>

<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>
				<tr><td>N�zev oblasti:</td><td><input type="text" name="nazev_oblast"></td></tr>
				<tr><td><input type="submit" name="pridat_oblast" value="p�idat"></td><td></td></tr>
				</table>
			</form><br /><br />

			<form method="POST" >
				<select name="id_upravit_oblast">

<?
//////////////////////////////
$query="SELECT * FROM oblast ";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<option value="<?echo($data["id"])?>"><?echo($data["jmeno"])?></option>

<?}//////////////////////////////////
?>
                                 </select>
				<input type="submit" name="smazat_oblast" value="smazat">
			</form>

		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
<?
break;
case 4:
?>

<!---left content--->
		<div class="center_left">
			<form method="POST" >
				<table>
				<tr><td>�idi�:</td><td><select name="id_ridic">
<?
//////////////////////////////
$query="SELECT * FROM pracovnik WHERE typ_zam=3";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<option value="<?echo($data["id"])?>"><?echo$data["jmeno"]; echo" "; echo( $data["prijmeni"]);?></option>

<?}//////////////////////////////////
?>

<tr><td></td><td></td><td><input type="submit" name="vybrat_id_ridic" value="vybrat"></td></tr>
</form>
<form method="POST">

</select></td></tr>

<?
if (isset($_POST["id_ridic"])){
$_SESSION["id"]=$_POST["id_ridic"];
$query="SELECT * FROM pracovnik WHERE id='".$_POST["id_ridic"]."'";
$result = @mysql_query($query,$db);
$data = mysql_fetch_array($result, MYSQL_ASSOC);
?>
<tr><td /><td>Je vybr�n �idi� <?echo ($data["jmeno"] ); echo (" "); echo ($data["prijmeni"]);?></td></tr>

				<tr><td>Oblast</td><td><select name="oblast_id">
<?
//////////////////////////////

$query="SELECT * FROM oblast WHERE id_pracovnik IS NULL";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<option value="<?echo $data["id"]; ?>"><?echo$data["jmeno"]; ?></option>

<?}//////////////////////////////////
?>



</select></td></tr>
				<tr><td></td><td></td><td><input type="submit" name="priradit_oblast_id"value="p�i�adit"></td></tr>
<?}?>

				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
			<li><span></span><a  href="?z=7">odebrat oblast</a></li>
                        
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<?
break;
case 5:
$pozice = array(
        "admin",
        "zam�stnanec",
        "�idi�" );
      

?>
<!---left content--->
		<div class="center_left">
			<table>
				<tr><th>id</th><th>jm�no</th><th>p��jmen�</th><th>bydli�t�</th><th>��slo ��tu</th><th>pozice</th><th></th><th></th></tr>
<?
//////////////////////////////

$query="SELECT * FROM pracovnik ";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<tr><td><?echo($data["id"]);?><td><?echo($data["jmeno"]);?></td><td><?echo($data["prijmeni"]);?></td><td><?echo($data["bydliste"]);?></td><td><?echo($data["cislo_bu"]);?></td><td><?echo($pozice[$data["typ_zam"]-1]);?></td></tr>

<?
}//////////////////////////////////
?>


				
			</table>

<br /><br />
 <form method="POST" ><tr><td>Pecivo</td><td><select name="id_upravit_pracovnik">
<?
//////////////////////////////

$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?> 
<option value="<?echo($data["id"]);?>"><?echo($data["id"]);   ?></option>

<?}//////////////////////////////////
?>

</select>

				<input type="submit" name="upravit_pracovnik" value="upravit"> <input type="submit" name="smazat_pracovnik" value="smazat">
</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?z=8">p�idat zam�stnance</a></li>
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>
<?
break;
case 6:
?>
<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>
				
				<tr><td>N�zev produktu:</td><td><input type="text" name="nazev" value="<?php if(isset($_SESSION["nazev"])){echo $_SESSION["nazev"];}?>"></td><td></td></tr>
				<tr><td>Cena produktu:</td><td><input type="text" name="cena"></td><td>K�</td></tr>
				<tr><td></td><td></td><td><input type="submit" name="pridat_produkt" value="odeslat"></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?z=2">vypsat produkty</a></li>
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<?
break;
case 7:?>
<!---left content--->
		<div class="center_left">
			<form method="POST" >
				<table>
				<tr><td>�idi�:</td><td><select name="id_ridic">
<?
//////////////////////////////
$query="SELECT * FROM pracovnik WHERE typ_zam=3";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<option value="<?echo($data["id"])?>"><?echo$data["jmeno"]; echo" "; echo( $data["prijmeni"]);?></option>

<?}//////////////////////////////////
?>

<tr><td></td><td></td><td><input type="submit" name="vybrat_smaz_id_ridic" value="vybrat"></td></tr>
</form>
<form method="POST">

</select></td></tr>

<?
if (isset($_POST["id_ridic"])){
$_SESSION["id"]=$_POST["id_ridic"];
$query="SELECT * FROM pracovnik WHERE id='".$_POST["id_ridic"]."'";
$result = @mysql_query($query,$db);
$data = mysql_fetch_array($result, MYSQL_ASSOC);
?>
<tr><td /><td>Je vybr�n �idi� <?echo ($data["jmeno"] ); echo (" "); echo ($data["prijmeni"]);?></td></tr>

				<tr><td>Oblast</td><td><select name="oblast_id">
<?
//////////////////////////////

$query="SELECT * FROM oblast WHERE id_pracovnik='".$_SESSION["id"]."'";
$result = @mysql_query($query,$db);
while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
?>
<option value="<?echo $data["id"]; ?>"><?echo$data["jmeno"]; ?></option>

<?}//////////////////////////////////
?>



</select></td></tr>
				<tr><td></td><td></td><td><input type="submit" name="odebrat_oblast_id"value="odebrat"></td></tr>
<?}?>

				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
			<li><span></span><a  href="?z=4">p�i�adit oblast</a></li>
                        
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<?
break;
case 8:
$pozice = array(
        "admin",
        "zam�stnanec",
        "�idic" );
      

?>
<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>

				<tr><td>Jm�no:</td><td><input type="text" name="jmeno"></td><td></td></tr>
				<tr><td>P��jmen�:</td><td><input type="text" name="prijmeni"></td><td></td></tr>
				<tr><td>Bydli�t�:</td><td><input type="text" name="bydliste"></td><td></td></tr>
				<tr><td>��slo B�:</td><td><input type="text" name="cbu"></td><td></td></tr>
<tr><td>Pozice:</td><td>   
<?   
echo "  <select name='pozice'>\n";
foreach ($pozice as $key => $druh) { 
	echo "<option value='$key'>$druh</option>\n";
}
echo "</select>\n";
?>
</td><td></td></tr>

				
				<tr><td>Login(�idi�i ne):</td><td><input type="text" name="login"></td><td></td></tr>
				<tr><td>Heslo(�idi�i ne):</td><td><input type="text" name="heslo"></td><td></td></tr>
				<tr><td></td><td></td><td><input type="submit" name="pridat_zamestnance" value="odeslat"></td><td></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?z=5">vypsat zam�stnance</a></li>
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>


<?
break;
case 9:

$result_pecivo = @mysql_query("SELECT * FROM pecivo", $db);

      $pecivo = array();
      while ($data_pecivo = mysql_fetch_array($result_pecivo, MYSQL_ASSOC)) {
       $pecivo[$data_pecivo["id"]] = $data_pecivo["cena"];
      }

      $zpusob_dodani = array(
        "rozvoz",
        "osobne" );
      $zpusob_platby = array(
        "hotovost",
        "kartou" 
      );


      /////SELECT/////////////////////////
      $query="SELECT * FROM objednavka WHERE id='".mysql_real_escape_string($_POST["id_upravit_objednavka"])."';";
      $result = @mysql_query($query,$db);
      if ($data = mysql_fetch_array($result, MYSQL_ASSOC)){
        $result_obj_pecivo = @mysql_query("SELECT * FROM obj_pecivo where objednavka = '" . $data["id"] . "'", $db);
        $cena = 0;
        while ($data_obj_pecivo = mysql_fetch_array($result_obj_pecivo, MYSQL_ASSOC)) {
          $cena += $data_obj_pecivo["pocet"] * $pecivo[$data_obj_pecivo["pecivo"]];

        }
      $_SESSION["id"]=$data["id"];
}


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
        if ($druh == $zpusob_platby[$data["zpusob_platby"]]) echo ("selected='selected'");
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
        if ($druh == $zpusob_dodani[$data["zpusob_dodani"]]) echo ("selected='selected'");
        echo">$druh</option>\n";

}
echo "</select>\n";
?>
</td></tr>

				
				<tr><td><input type="submit" name="ulozit_objednavku" value="odeslat"></td><td></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>

<?
break;
case 10:


 $query="SELECT * FROM pecivo WHERE id='".mysql_real_escape_string($_SESSION["id"])."';";
      $result = @mysql_query($query,$db);
      $data = mysql_fetch_array($result, MYSQL_ASSOC);


?>
<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>
				
				<tr><td>N�zev produktu:</td><td><input type="text" name="nazev" value="<?php if(isset($_SESSION["nazev"])){echo $_SESSION["nazev"];}else {echo $data["nazev"];}?>"></td><td></td></tr>
				<tr><td>Cena produktu:</td><td><input type="text" name="cena" value="<?php echo $data["cena"];?>"></td><td>K�</td></tr>
				<tr><td></td><td></td><td><input type="submit" name="upravit_produkt" value="upravit"></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?z=2">vypsat produkty</a></li>
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>



<?
break;
case 11:
$pozice = array(
        "admin",
        "zam�stnanec",
        "�idic" );
   
$query="SELECT * FROM pracovnik WHERE id='".mysql_real_escape_string($_SESSION["id"])."';";
$result = @mysql_query($query,$db);
$data = mysql_fetch_array($result, MYSQL_ASSOC);
   

?>
<!---left content--->
		<div class="center_left">
			<form method="POST">
				<table>

				<tr><td>Jm�no:</td><td><input type="text" name="jmeno" value="<?php echo $data["jmeno"];?>"></td><td></td></tr>
				<tr><td>P��jmen�:</td><td><input type="text" name="prijmeni" value="<?php echo $data["prijmeni"];?>"></td><td></td></tr>
				<tr><td>Bydli�t�:</td><td><input type="text" name="bydliste" value="<?php echo $data["bydliste"];?>"></td><td></td></tr>
				<tr><td>��slo B�:</td><td><input type="text" name="cbu" value="<?php echo $data["cislo_bu"];?>"></td><td></td></tr>
<tr><td>Pozice:</td><td>   
<?   
echo "  <select name='pozice'>\n";
foreach ($pozice as $key => $druh) {
	echo "<option value='$key'";
        if ($druh == $pozice[$data["typ_zam"]-1]) echo ("selected='selected'");
        echo">$druh</option>\n";

}
echo "</select>\n";
?>
</td><td></td></tr>

				
				<tr><td>Login(�idi�i ne):</td><td><input type="text" name="login" value="<?php echo $data["login"];?>"></td><td></td></tr>
				<tr><td>Heslo(�idi�i ne):</td><td><input type="text" name="heslo" value="<?php echo $data["heslo"];?>"></td><td></td></tr>
				<tr><td></td><td></td><td><input type="submit" name="pridat_zamestnance" value="odeslat"></td><td></td></tr>
				</table>
			</form>
		</div> 
<!---right content--->
		<div class="center_right">
			<ul class="list">
				<li><span></span><a href="?z=5">vypsat zam�stnance</a></li>
			</ul> 
			<div class="image_box"><img src="images/chleba.jpg" alt="" title="" width="220px"/></div>
		</div>





<?

}
////////////////////////////////////
///////zapati
///////////////////////////////////////
?>
<!---wait for content--->
		<div class="clear"></div> 
	</div>
<!---footer--->
	<div id="footer">
		<div class="left_footer">P�ihl�en:<?if ($t==1){?> admin <?}else{?> zam�stnanec <?}?>| <a href="?z=20">odhl�en�</a></div>
<?
}
?>
