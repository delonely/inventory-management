<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');

/*Start Routes authentication*/
// $routes->get('auth', 'Auth::index');
// $routes->get('auth/out', 'Auth::logout');
// $routes->post('auth', 'Auth::login'); // fungsi save and update
$routes->group("auth", function ($routes) {
    $routes->get("/", "Auth::index");
    $routes->get("out", "Auth::logout");
    $routes->post("/", "Auth::login"); // fungsi save dan update
});
/*End Routes authentication*/

/*Start Routes Kategori Supplier*/
// $routes->get('Kategorisupplier', 'Supplier\Kategorisupplier::kategori_supplier'); // fungsi view
// $routes->get('Kategorisupplier/(:num)', 'Supplier\Kategorisupplier::get_one/$1'); // fungsi get one data
// $routes->get('Kategorisupplier/select', 'Supplier\Kategorisupplier::getSelect'); // fungsi get all data for select2
// $routes->get('Kategorisupplier/getAll', 'Supplier\Kategorisupplier::getAll'); // fungsi get all data for datatables 
// $routes->post('Kategorisupplier', 'Supplier\Kategorisupplier::save'); // fungsi save and update
// $routes->post('Kategorisupplier/getAll', 'Supplier\Kategorisupplier::getAll'); // fungsi get all data for datatables 
// $routes->delete('Kategorisupplier/(:num)', 'Supplier\Kategorisupplier::remove/$1'); // fungsi inactive data 
$routes->group("KategoriSupplier", function ($routes) {
    $routes->get('/', 'Supplier\Kategorisupplier::kategori_supplier'); // fungsi view
    $routes->get('(:num)', 'Supplier\Kategorisupplier::get_one/$1'); // fungsi get one data
    $routes->get('select', 'Supplier\Kategorisupplier::getSelect'); // fungsi get all data for select2
    $routes->get('getAll', 'Supplier\Kategorisupplier::getAll'); // fungsi get all data for datatables 
    $routes->post('/', 'Supplier\Kategorisupplier::save'); // fungsi save and update
    $routes->post('getAll', 'Supplier\Kategorisupplier::getAll'); // fungsi get all data for datatables 
    $routes->delete('(:num)', 'Supplier\Kategorisupplier::remove/$1'); // fungsi inactive data 
});
/*End Routes Kategori Supplier*/

/*Start Routes Supplier*/
$routes->group("Supplier", function ($routes) {
    $routes->get('/', 'Supplier\Supplier::supplier'); // fungsi view
    $routes->get('addDataSupplier', 'Supplier\Supplier::add_supplier'); // fungsi view
    $routes->get('(:num)', 'Supplier\Supplier::get_one/$1'); // fungsi get one data
    $routes->get('select', 'Supplier\Supplier::getSelect'); // fungsi get all data for select2
    $routes->get('getAll', 'Supplier\Supplier::getAll'); // fungsi get all data for datatables 
    $routes->post('/', 'Supplier\Supplier::save'); // fungsi save and update
    $routes->post('getAll', 'Supplier\Supplier::getAll'); // fungsi get all data for datatables 
    $routes->delete('(:num)', 'Supplier\Supplier::remove/$1'); // fungsi inactive data 
});
/*End Routes Supplier*/

/*Start Routes Kategori Barang*/
$routes->group("Kategoribarang", function ($routes) {
    $routes->get('/', 'Barang\Kategoribarang::kategori_barang'); // fungsi view
    $routes->get('(:num)', 'Barang\Kategoribarang::get_one/$1'); // fungsi get one data
    $routes->get('select', 'Barang\Kategoribarang::getSelect'); // fungsi get all data for select2
    $routes->get('getAll', 'Barang\Kategoribarang::getAll'); // fungsi get all data for datatables 
    $routes->post('/', 'Barang\Kategoribarang::save'); // fungsi save and update
    $routes->post('getAll', 'Barang\Kategoribarang::getAll'); // fungsi get all data for datatables 
    $routes->delete('(:num)', 'Barang\Kategoribarang::remove_kategori/$1'); // fungsi inactive data
});
//$routes->get('Kategoribarang/add', 'Barang\Kategoribarang::add_kategori');
//$routes->put('Kategoribarang', 'Barang\Kategoribarang::edit_kategori');
// $routes->get('Kategoribarang/generate', 'Barang\Kategoribarang::generate_kategori');
/*End Routes Kategori Barang*/

/*Start Routes Satuan Barang*/
$routes->group("Satuanbarang", function ($routes) {
    $routes->get('/', 'Barang\Satuanbarang::satuan_barang'); // fungsi view
    $routes->get('(:num)', 'Barang\Satuanbarang::get_one/$1'); // fungsi get one data
    $routes->get('terkecil/(:num)', 'Barang\Satuanbarang::get_satuan/$1'); // fungsi get satuan konversi barang tertentu
    $routes->get('select', 'Barang\Satuanbarang::getSelect'); // fungsi get all data for select2
    $routes->post('/', 'Barang\Satuanbarang::save'); // fungsi save and update
    $routes->post('getAll', 'Barang\Satuanbarang::getAll'); // fungsi get all data for datatable
    $routes->delete('(:num)', 'Barang\Satuanbarang::remove_satuan/$1'); // fungsi inactive data
});
// $routes->get('Satuanbarang/add', 'Barang\Satuanbarang::add_satuan');
// $routes->put('Satuanbarang', 'Barang\Satuanbarang::edit_satuan');
/*End Routes Satuan Barang*/

/*Start Routes Data Barang*/
$routes->group("Databarang", function ($routes) {
    $routes->get('/', 'Barang\Databarang::data_barang'); // fungsi view
    $routes->get('(:num)', 'Barang\Databarang::get_one/$1'); // fungsi get one data
    $routes->get('select', 'Barang\Databarang::getSelect'); // fungsi get all data for select2
    $routes->get('add', 'Barang\Databarang::add_databarang'); // fungsi view add data page
    $routes->get('edit/(:num)', 'Barang\Databarang::add_databarang/$1'); // fungsi view edit data page with data
    //$routes->get('Databarang/print/(:num)', 'Barang\Databarang::stokBarang');//fungsi dompdf stokbarang
    $routes->post('/', 'Barang\Databarang::save'); // fungsi save and update
    $routes->post('getAll', 'Barang\Databarang::getAll'); // fungsi get all data for datatable
    $routes->post('getMine', 'Barang\Databarang::getAll/1'); // fungsi get all data for datatable
    $routes->post('jumlah', 'Barang\Databarang::hitungBarang'); // fungsi jumlah permintaan
    $routes->delete('(:num)', 'Barang\Databarang::remove_databarang/$1'); // fungsi inactive data barang
    $routes->delete('satuan/(:num)', 'Barang\Databarang::remove_konversiSatuan/$1'); // fungsi inactive data konversi barang
    $routes->delete('gudang/(:num)/(:num)', 'Barang\Databarang::remove_gudang/$1/$2'); // fungsi inactive data konversi barang
});
/*End Routes Data Barang*/

/*Start Routes Data Barang*/
$routes->group("Pajak", function ($routes) {
    $routes->get('/', 'Pajak::data_pajak'); // fungsi view
    $routes->get('(:num)', 'Pajak::get_one/$1'); // fungsi get one data
    $routes->post('getAll', 'Pajak::getAll'); // fungsi get all data for datatable
    $routes->post('select', 'Pajak::getSelect'); // fungsi get all data for select 2
    $routes->post('/', 'Pajak::save'); // fungsi save and update 
    $routes->delete('(:num)', 'Pajak::remove/$1'); // fungsi inactive data
});
/*End Routes Data Barang*/

/*Start Routes Pembelian Barang*/
/**Rute untuk view */
$routes->group("Purchase", function ($routes) {
    $routes->get('/', 'Purchasing\Purchase::index'); // fungsi view
    $routes->get('addPurchase', 'Purchasing\Purchase::add_purchase');
    $routes->post('cariSupplier', 'Purchasing\Purchase::cari_supplier');
    $routes->post('cariBarang', 'Purchasing\Purchase::cari_barang');
    $routes->post('cariPajak', 'Purchasing\Purchase::cari_pajak');
    /**Rute permintaan data */
    $routes->get('(:num)', 'Purchasing\Purchase::get_one/$1'); // fungsi get one data
    $routes->get('getAll', 'Purchasing\Purchase::getAll');
    $routes->get('edit/(:num)', 'Purchasing\Purchase::add_purchase/$1'); // fungsi view edit data page with data
    $routes->post('getAll', 'Purchasing\Purchase::getAll');
    $routes->post('/', 'Purchasing\Purchase::save'); // fungsi save and update
    $routes->delete('(:num)', 'Purchasing\Purchase::remove/$1'); // fungsi inactive data barang
});
/*End Routes Pembelian Barang*/

/*Start Routes Permintaan Barang*/
/**Rute untuk view */
$routes->group("Permintaanbarang", function ($routes) {
    $routes->get('/', 'Inventory\Permintaanbarang::permintaan_barang');
    $routes->get('addPermintaanBarang', 'Inventory\Permintaanbarang::add_permintaanbarang');
    $routes->get('addPermintaanBarang/(:num)', 'Inventory\Permintaanbarang::add_permintaanbarang/$1');
    $routes->get('permintaanViewReq/(:num)', 'Inventory\Permintaanbarang::permintaan_viewreq/$1');
    $routes->post('cariBarang', 'Inventory\Permintaanbarang::cari_barang');

    /**Rute permintaan data */
    $routes->get('(:num)', 'Inventory\Permintaanbarang::get_one/$1'); // fungsi get one data
    $routes->post('getAll', 'Inventory\Permintaanbarang::getAll'); // fungsi get all data for datatable
    $routes->post('getUnapproved', 'Inventory\Permintaanbarang::getUnapproved'); // fungsi get all unapproved for datatable
    $routes->post('/', 'Inventory\Permintaanbarang::save'); // fungsi save and update
    $routes->post('jumlah', 'Inventory\Permintaanbarang::hitungPermintaan'); // fungsi jumlah permintaan
    $routes->delete('(:num)', 'Inventory\Permintaanbarang::remove/$1'); // fungsi inactive data barang
});
/*End Routes Permintaan Barang*/

/*Start Unit Routes*/
$routes->group("Unit", function ($routes) {
    $routes->get('/', 'User\Unit::data_unit');
    $routes->get('assign/(:num)', 'User\Unit::add_assign/$1'); // fungsi view add assign
    $routes->get('(:num)', 'User\Unit::get_one/$1');
    $routes->get('select', 'User\Unit::getSelect'); // fungsi get all data for select2
    $routes->get('client', 'User\Unit::getClient'); // fungsi get client yg boleh minta ke gudang saya
    $routes->post('addUnit', 'User\Unit::add_unit');
    $routes->post('getAll', 'User\Unit::getAll');
    $routes->post('getUnits/(:num)', 'User\Unit::getUnits/$1');
    $routes->post('/', 'User\Unit::save'); // fungsi save and update
    $routes->post('client', 'User\Unit::hitungClient'); // fungsi hitung user client yg boleh minta ke gudang saya

    $routes->delete('(:num)', 'User\Unit::remove/$1'); // fungsi inactive data
});
$routes->post('UnitGudang', 'User\Unit::assignUnit'); // fungsi save and update
//$routes->post('Unit/editUnit', 'User/Unit::edit_unit');
/*End Unit Routes*/

/** Start Role Routes */
$routes->get('Role/select', 'User\Role::getSelect'); // fungsi get all data for select2
/**End Role Routes */

/*Start User Routes*/
$routes->group("User", function ($routes) {
    $routes->get('/', 'User\User::data_pengguna');
    $routes->get('addUser', 'User\User::add_user');
    $routes->get('editUser/(:num)', 'User\User::edit_user/$1');
    $routes->get('mutasi/(:num)', 'User\User::mutasi_user/$1'); // fungsi view mutasi
    $routes->get('(:num)', 'User\User::get_one/$1');
    $routes->get('select', 'User\User::getSelect'); // fungsi get all data for select2
    $routes->post('getAll', 'User\User::getAll');
    $routes->post('/', 'User\User::save'); // fungsi save and update
    $routes->post('(:num)', 'User\User::mutasi/$1'); // fungsi mutasi user
    $routes->delete('(:num)', 'User\User::remove/$1'); // fungsi inactive data
});
//$routes->post('User/editUser', 'User/User::edit_user');
/*End User Routes*/

/**
 * start laporan routes
 */
$routes->get('LapPersediaan', 'Laporan\Laporanpersediaan::index'); //fungsi view laporan persediaan
$routes->get('LapPersediaan/(:any)', 'Laporan\Laporanpersediaan::generate/$1'); //fungsi view laporan persediaan

$routes->get('LapPosisiPersediaan', 'Laporan\Laporanposisi::index'); //fungsi view laporan posisi
$routes->get('LapRincianPersediaan', 'Laporan\Laporanrincian::index'); //fungsi view laporan persediaan
/*end laporan routes

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
