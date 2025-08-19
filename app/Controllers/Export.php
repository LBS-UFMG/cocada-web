<?php

namespace App\Controllers;

class Export extends BaseController
{
    public function pymol($id = 'null'){
        # usada pelo controller project -> id tem 6 dígitos
        echo "<div class='bg-info w-100 p-2 m-0 small'><strong>Exporting $id to PyMOL...</strong><br>";

        # START cocada PIPELINE *******************************************
		$data_folder = getcwd();
		$raiz = str_replace("/public", "",$data_folder);
		$interpretador = "/home/liase/miniconda3/bin/python"; 

		chmod("$raiz/public/data/projects/$id", 0777); // quebra de segurança

		#echo "$interpretador $raiz/app/ThirdParty/$versao/main.py -f $data_folder/$id/data.$extensao -o $data_folder/$id";
		$comando = "$interpretador $raiz/app/ThirdParty/export_pymol/export_pymol.py
		$data_folder/data/projects/$id/data.cif
		$data_folder/data/projects/$id/contacts.csv
		2>&1";
		$comando = str_replace("\n","",$comando);
		system($comando, $error_log);
        //echo $comando;

        chmod("$raiz/public/data/projects/$id", 0755); // protege a pasta de acessos indevidos

        echo '<br><a href="'.base_url("/data/projects/$id/contacts.pse").'">Download</a></div>';
        $data = [];
        $data['id'] = $id;
        return view('exporting', $data);
	}

    public function pdb_to_pymol($id = 'null'){
        # Esta função é usada pelo controller entry -> id tem 4 dígitos
        echo "<div class='bg-info w-100 p-2 m-0 small'><strong>Exporting contacts of $id to PyMOL...</strong><br>";

        # START cocada PIPELINE *******************************************
		$data_folder = getcwd();
		$raiz = str_replace("/public", "",$data_folder);
		$interpretador = "/home/liase/miniconda3/bin/python"; 

        chmod("$raiz/public/data/pdb/$id[0]/$id", 0777); // quebra de segurança

        // BAIXAR O PDB
        $destino = "$data_folder/data/pdb/$id[0]/$id/data.cif";
        $url = "https://files.rcsb.org/download/$id.cif";
        $conteudo = file_get_contents($url);

        if ($conteudo !== false) {
            // Salva o arquivo no destino especificado
            file_put_contents($destino, $conteudo);
        } else {
            echo "Fail.";
        }

		#echo "$interpretador $raiz/app/ThirdParty/$versao/main.py -f $data_folder/$id/data.$extensao -o $data_folder/$id";
		$comando = "$interpretador $raiz/app/ThirdParty/export_pymol/export_pymol.py
		$data_folder/data/pdb/$id[0]/$id/data.cif
		$data_folder/data/pdb/$id[0]/$id/$id"."_contacts.csv
		2>&1";
		$comando = str_replace("\n","",$comando);
		system($comando, $error_log);
        //echo $comando;

        chmod("$raiz/public/data/pdb/$id[0]/$id", 0755); // protege a pasta de acessos indevidos

        echo '</div>';
        $data = [];
        $data['id'] = $id;
        return view('exporting', $data);
	}
}
