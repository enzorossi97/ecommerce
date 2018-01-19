<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class Products extends Model {

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
	}

	public function save()

	{

		$sql = new Sql();

		/* Ordem dos itens no MySql 
		pdesperson VARCHAR(64), 
		pdeslogin VARCHAR(64), 
		pdespassword VARCHAR(256), 
		pdesemail VARCHAR(128), 
		pnrphone BIGINT, 
		pinadmin TINYINT
		*/

		$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", 
			array(
			":idproduct"=>$this->getidproduct(),
			":desproduct"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth().
			":vlheight"=>$this->getvlheight(),
			":vllength"=>$this->getvllength(),
			":vlweight"=>$this->getvlweight(),
			":desurl"=>$this->getdesurl()

		));

		$this->setData($results[0]); //primeiro registro $results[0]

		category::updateFile();

	}

	public function get($idcategory)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct",[
			':idproduct'=>$idproduct
		]);

		$this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_categories WHERE idproduct = :idproduct", [
			':idproduct'=>$this->getidproduct()
		]);

		category::updateFile();
	}
	
	

}


 ?>