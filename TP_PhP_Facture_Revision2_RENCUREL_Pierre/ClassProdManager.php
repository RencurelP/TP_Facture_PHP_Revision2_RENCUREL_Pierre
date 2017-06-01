<?php
class ProdManager
{
	private $_db;


	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function add(Produit $prod)
	{
		$q = $this->_db->prepare('INSERT INTO produits(NumProduit, Des, PUHT) VALUES (:NumProduit, :Des, :PUHT)');

		$q->bindValue(':NumProduit', $prod->getNumProduit(), PDO::PARAM_INT);
		$q->bindValue(':Des', $prod->getDes());
		$q->bindValue(':PUHT', $prod->getPrixHt(), PDO::PARAM_INT);

		$q->execute();
	}

	public function delete(Produit $prod)
	{
		$this->_db->exec('DELETE FROM produits WHERE id = '.$prod->id());
	}

	public function get($id)
	{
		$id = (int) $id;

		$q = $this->_db->query('SELECT id, NumProduit, Des, PUHT FROM produits WHERE id = '.$id);
		$donnees = $q->fetch(PDO::FETCH_ASSOC);

		return new Produit($donnees);
	}

	public function getList()
	{
		$prod = [];

		$q = $this->_db->query('SELECT id, NumProduit, Des, PUHT FROM produits ORDER BY NumProduit');

		while ($donnees = $q->fecth(PDO::FETCH_ASSOC))
		{
			$prod[] = new produits($donnees);
		}

		return $prod;
	}

	public function update(Produit $prod)
	{
		$q = $this->_db->prepare('UPDATE produits SET Des = :Des, PUHT = :PUHT WHERE id = :id');

		$q->bindValue(':Des', $prod->Des());
		$q->bindValue(':PUHT', $prod->PUHT(), PDO::PARAM_INT);

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}



?>