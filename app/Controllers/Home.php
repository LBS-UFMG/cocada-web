<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        # BUSCAR DADOS ESTATÍSTICOS
		$data = array();

        $url = "./data/pdb/total_contacts.txt";

        $data['h1'] = "734,987,662";
        $data['h2'] = "675,321,637";
        $data['h3'] = "59,666,025";
        $data['h4'] = "223,860";

        $data['update'] = 'Fev 2025';

        if (file_exists($url)) {
            # se houver um arquivo de configuração, atualize os valores
            $file_handle = fopen($url, 'r');
            if($file_handle) {
                $current_line = 1;
                while (($line = fgets($file_handle)) !== false) {
                    switch($current_line){
                        case 1: $data['h2'] = number_format((int)$line, 0, '', ','); $current_line++; break;
                        case 2: $data['h3'] = number_format($line, 0, '', ','); $current_line++; break;
                        case 3: $data['h1'] = number_format($line, 0, '', ','); $current_line++; break;
                        case 4: $data['h4'] = number_format($line, 0, '', ','); $current_line++; break;
                        case 5: $data['update'] = $line; $current_line++; break;
                    }
                }
                fclose($file_handle);
            } else {
                echo "Error.";
            }
        }

        return view('home', $data);
    }

    public function documentation(): string
    {
        return view('documentation');
    }

    public function download(): string
    {
        return view('download');
    }

    public function blast(): string
    {
        return view('blast');
    }

    public function explore(): string
    {
        return view('explore');
    }

    private function getInfo($id): Array 
    {
        $first_letter = substr($id, 0, 1);
        $url = "./data/pdb/$first_letter/$id/$id"."_info.csv";

        if (!file_exists($url)) {
            return ["File not exist."];
        }

        $file_handle = fopen($url, 'r');
        $lines = "";
        if($file_handle) {
            while (($line = fgets($file_handle)) !== false) {
                $lines = $lines.$line;
            }
            fclose($file_handle);
        } else {
            echo "Error.";
        }
        
        $info = explode(",", $lines);
        return $info;
    }


    private function getContacts($id): Array 
    {
        $contacts = [];
        $first_letter = substr($id, 0, 1);

        # contacts
        $url = "./data/pdb/$first_letter/$id/$id"."_contacts.csv";
        if (!file_exists($url)) {
            return ["File not exist."];
        }
        $file_handle = fopen($url, 'r');
        if ($file_handle) {
            while (($line = fgets($file_handle)) !== false) {
                array_push($contacts,$line);
            }
            fclose($file_handle);
        } else {
            echo "Error.";
        }
        
        return $contacts;
    }

    public function entry($id): string
    {
        $data = [];
        $data['id'] = $id;

        // código inexistente
        if(strlen($id) != 4){
            return view('404', $data);
        }

        // pega informações básicas
        $data['info'] = $this->getInfo($id);
        if($data['info'][0] == "File not exist."){
            return view('404', $data);
        }
        $data['total_results'] = $data['info'][3];
        // pega informações de contatos
        $data['contacts'] = $this->getContacts($id);

        return view('entry', $data);
    }

}
