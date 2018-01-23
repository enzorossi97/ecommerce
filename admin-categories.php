<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product;

///// CATEGORIES - INÍCIO DA ROTA LIST /////

$app->get("/admin/categories", function(){

	user::verifyLogin(); 

	$categories = Category::listAll();
	
	$page = new PageAdmin();

	$page->setTpl("categories", [
		'categories'=>$categories
	]);

});

///// FIM DA ROTA LIST /////

///// CATEGORIES - INÍCIO DA ROTA CREATE /////

$app->get("/admin/categories/create", function(){

	user::verifyLogin(); 
	
	$page = new PageAdmin();

	$page->setTpl("categories-create");

});

$app->post("/admin/categories/create", function(){

	user::verifyLogin(); 

	$category = new Category();
	
	$category->setData($_POST);

	$category->save();

	header('Location: \admin\categories');
	exit;

});

///// FIM DA ROTA CREATE /////


///// CATEGORIES - ROTA DELETE //////

$app->get("/admin/categories/:idcategory/delete", function($idcategory){

	user::verifyLogin(); 
	
	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: \admin\categories');
	exit;

});


///// FIM DA ROTA DELETAR /////



////// INÍCIO DA ROTA UPDATE /////
				  

$app->get("/admin/categories/:idcategory", function($idcategory){

	user::verifyLogin(); 
	
	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);

});

$app->post("/admin/categories/:idcategory", function($idcategory){

	user::verifyLogin(); 
	
	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: \admin\categories');
	exit;
});

///// FIM DA ROTA UPDATE /////


/////INICIO DA ROTA DE LISTAGEM DOS PRODUTOS/////

$app->get("/admin/categories/:idcategory/products", function($idcategory){

	user::verifyLogin(); 
	
	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-products", [
		'category'=>$category->getValues(),
		'productsRelated'=>$category->getProducts(),
		'productsNotRelated'=>$category->getProducts(false)
	]);

});

/////FIM DA ROTA DE LISTAGEM DOS PRODUTOS/////


/////INICIO DA ROTA DE ADICIONAR PRODUTOS/////

$app->get("/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){

	user::verifyLogin(); 
	
	$category = new Category();

	$category->get((int)$idcategory);

	$product = new Product();

	$product->get((int)$idproduct);

	$category->addProduct($product);

	header("Location: /admin/categories/".$idcategory."/products");
	exit;
});

/////FIM DA ROTA DE ADICIONAR PRODUTOS/////


/////INÍCIO DA ROTA DE REMOVER PRODUTOS/////

$app->get("/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){

	user::verifyLogin(); 
	
	$category = new Category();

	$category->get((int)$idcategory);

	$product = new Product();

	$product->get((int)$idproduct);

	$category->removeProduct($product);

	header("Location: /admin/categories/".$idcategory."/products");
	exit;

/////FIM DA ROTA DE REMOVER PRODUTOS/////
});
 ?>