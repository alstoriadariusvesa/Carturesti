<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Carturesti</title>
    <link rel="stylesheet" type="text/css" href="stil.css">
</head>
<body>
    <div id="afisari">
    <?php
        include("conectare.php");
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM carti ORDER BY id LIMIT $limit OFFSET $offset";
        $c = 0;
        if ($r = mysqli_query($id_con, $sql)) {
            echo "<table id='afisari'><tr><td>id</td><td>Titlu carte</td><td>Data aparitiei</td><td>Numar bucati</td></tr>";
            if (mysqli_num_rows($r) > 0) {
                while ($linie = mysqli_fetch_array($r)) {
                    echo "<tr id='albe' style='color:white' onclick='myFunction(this)'><td><font color='black'>$linie[0]</font></td> <td><font color='black'>$linie[1]</font></td> <td>$linie[3]</td> <td id='numar'>$linie[2]</td></tr>";
                    $c++;
                }
            } else {
                echo "Nu exista produse in tabela!";
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($id_con);
        }
        $total_pages_sql = "SELECT COUNT(*) FROM carti";
        $result = mysqli_query($id_con, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $limit);
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "Pagina <a href='?page=" . $i . "'>" . $i . "</a> ";
        }
        echo "</div>";

        mysqli_close($id_con);
    ?>
        <script>
function myFunction(x) {
    x.style.color='black';
}
</script>
    </div>
    <div id="adaugare">
<form action="" method="post" enctype="multipart/form-data"><br>
    <table id="talbel">
        <tr><td>dati denumirea cartii</td><td><input type="text" name="num"></td></tr>
        <tr><td>dati numarul de carti</td><td><input type="text" name="nr"></td></tr>
        <tr><td>dati data aparitiei</td><td><input type="text" name="data"></td></tr>
        <tr><td><input type="submit" value="Upload carte" name="submit"></td></tr>
    </table>
        </form>   
    <?php
if (isset($_POST['submit']))
{	
		$nume=$_POST['num'];
		$nr=$_POST['nr'];
        $data=$_POST['data'];
        include "conectare.php";
        $interogare = "INSERT INTO carti(nume,numar,data) VALUES('$nume','$nr','$data')";
			if( $error = mysqli_query($id_con,$interogare))
			{
				?>	<script type="text/javascript">
								alert("Carte adaugata!");
 				</script>
             <?php 
			}
			else
			{
					?>	<script type="text/javascript">
								alert("Eroare la INSERT!");
 				</script>
             <?php 
			}
			mysqli_close($id_con);	
			
	echo "<meta http-equiv='refresh' content='0'>";
}
 ?>
        </div>
    <div id="modifica">
        <form action="" method="post" enctype="multipart/form-data"><br>
    <table id="talbel">
        <tr><td>dati id-ul pentru modificare</td><td><input type="text" name="id"></td></tr>
        <tr><td>dati numele cartii</td><td><input type="text" name="nume"></td></tr>
        <tr><td>dati numarul de carti carti</td><td><input type="text" name="nr"></td></tr>
        <tr><td>dati data aparitiei</td><td><input type="text" name="data"></td></tr>
        <tr><td><input type="submit" value="Modifica carte" name="modif"></td></tr>
    </table>
        </form>
        <?php
if (isset($_POST['modif']))
{	
        include "conectare.php";
        $sql = "Update carti set nume='$_POST[nume]', numar='$_POST[nr]', data='$_POST[data]' WHERE id='$_POST[id]'"; 
        
			if( $error = mysqli_query($id_con,$sql))
			{
				?>	<script type="text/javascript">
								alert("Carte Modificata!");
 				</script>
             <?php 
			}
			else
			{
					?>	<script type="text/javascript">
								alert("Eroare la MODIFICARE!");
 				</script>
             <?php 
			}
			mysqli_close($id_con);	
			
	echo "<meta http-equiv='refresh' content='0'>";
}
 ?>
    </div>
</body>
</html>