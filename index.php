<?php
require 'config/config.php';

header('Content-Type: application/json');
if(isset($_GET['nominal']) && isset($_GET['domisili'])){
    try {
        $id_pengeluaran = $_GET['nominal'];
        $domisili = $_GET['domisili'];
        $stmt = $conn->prepare('select master_packages.name as paket, master_providers.name as provider,
            master_providers.gambar, paket_pengeluaran.nama as price,
            master_packages.speed
            FROM master_packages
            JOIN master_providers ON master_packages.master_provider_id = master_providers.id
            JOIN paket_pengeluaran ON paket_pengeluaran.id = master_packages.id_paket_pengeluaran
            JOIN data_survey ON master_providers.id = data_survey.id_provider
            AND paket_pengeluaran.id = '.$id_pengeluaran.'
            AND data_survey.domisili LIKE "%'.$domisili.'%"
            GROUP BY (master_packages.id)
        ');
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        echo json_encode($stmt->fetchAll());
        // echo json_encode([]);
    } catch(Exception $e){
        print_r($e->getMessage());
    }
} else {
    try {
        $stmt = $conn->prepare('select master_packages.name as paket, master_providers.name as provider,
            master_providers.gambar, paket_pengeluaran.nama as price,
            master_packages.speed
            FROM master_packages
            JOIN master_providers ON master_packages.master_provider_id = master_providers.id
            JOIN paket_pengeluaran ON paket_pengeluaran.id = master_packages.id_paket_pengeluaran
            GROUP BY (master_packages.id)
        ');
        $stmt->execute();
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        echo json_encode($stmt->fetchAll());
    } catch(Exception $e){
        print_r($e->getMessage());
    }
}
