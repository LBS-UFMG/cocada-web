<?php

namespace App\Controllers;

class Export extends BaseController
{
    public function pymol($id = 'null'){
        echo "Exporting $id to PyMOL...";

        # START cocada PIPELINE *******************************************
		$data_folder = getcwd();
        dd($data_folder);
		$raiz = str_replace("/public/data/projects", "",$data_folder);
		$interpretador = "/home/liase/miniconda3/bin/python"; 

		#chmod("../../../public/data/projects/$id", 0777); // quebra de segurança

		#echo "$interpretador $raiz/app/ThirdParty/$versao/main.py -f $data_folder/$id/data.$extensao -o $data_folder/$id";
		$comando = "$interpretador $raiz/app/ThirdParty/export_pymol/export_pymol.py
		$data_folder/$id/data.cif
		$data_folder/$id/contacts.csv
		2>&1";
		$comando = str_replace("\n","",$comando);
		system($comando, $error_log);

        #chmod("../../../public/data/projects/$id", 0755); // protege a pasta de acessos indevidos

        echo '<a href="'.base_url("/project/$id/data_visualization.pse").'">Download</a>';
	}
}
