<?php

$pdo = new PDO('mysql:host=localhost;dbname=first;charset=utf8', 'root', '');
$func = $_POST['func'];
if($func){
	$func();
}

function getBook(){
	global $pdo;
	$pricefrom = $_POST['pricefrom'];
	//$pricefrom = 20;
	$pz = $pdo->prepare('SELECT * FROM books WHERE price >= ?');
	$pz->execute([$pricefrom]);
	$books = $pz->fetchALL(PDO::FETCH_OBJ);
	header ('Content-Type: text/xml');
	?>

	<books>
		<?php foreach ($books as $book): ?>
		<book id="<?= $book->id ?>">
		  <name> <?= htmlspecialchars($book->name) ?> </name>
		  <price> <?= $book->price ?> </price>
		</book>
	    <?php endforeach; ?>
	</books>

<?php } 

function deleteBook(){
	global $pdo;
	$id = $_POST['id'];
	$pz = $pdo->prepare('DELETE FROM books WHERE id=?');
	return $pz->execute([$id]);
}

function corPrice(){
	global $pdo;
	$price = $_POST['price'];
	$id = $_POST['id'];
	$pz = $pdo->prepare('UPDATE books SET price = ? WHERE id=?');
	return $pz->execute([$price, $id]);
}


?>

