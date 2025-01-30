<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
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
