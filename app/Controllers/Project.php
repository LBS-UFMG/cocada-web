<?php

namespace App\Controllers;

class Project extends BaseController
{
    public function index(): string
    {
        return view('home');
    }


    public function id($id = 'null'){
		$id = substr($id, 0, 6);

		# ********************* Search project *********************
		# Read directory
		chdir('data');
		$projects = glob("{*}", GLOB_BRACE);
		$project_exists = False;

		# Is the id unique? If not, create a new!
		for($i = 0; $i < (count($projects)); $i++){
			if($projects[$i] == $id){
				$project_exists = True;
			}
		}

		# Project does not exist
		if(!$project_exists){
			$view = 'project_fail';
			$data = array();
			return view('404', $data);
		}
		else{

            # ********************* Loading data *********************
            # Mutations
			$data_folder = getcwd(); // este código identifica a pasta local
			$raiz = str_replace("/public/data", "",$data_folder);

			$contacts_file = fopen($data_folder.'/'.$id.'/contacts.csv','r');
            $contacts = array();
            $total_results = 0;
            while (($line = fgets($contacts_file, 4096)) !== false) {
                array_push($contacts, $line);
                $total_results++;
            }
            fclose($contacts_file);
            
            $view = 'project';

            // Load template
            $data['contacts'] = $contacts;
            $data['id'] = $id;
            $data['total_results'] = $total_results-3;

            return view('entry', $data);
		}
	}



    public function create(){

		# ********************* Create new ID *********************
		$id = $this->generateRandomString(6);
		
		# Read directory
		chdir('../public/data');
		$arquivos = glob("{*}", GLOB_BRACE);

		# Is the id unique? If not, create a new!
		for($i = 0; $i < (count($arquivos)); $i++){
			if($arquivos[$i] == $id){
				$id = $this->generateRandomString(6);
				$i = 0;
			}
		}

		# Create project folder 
		mkdir("../../public/data/$id");
		mkdir("../../public/data/$id/tmp");
		chmod("../../public/data/$id", 0777);
		//chmod("../../public/data/$id/tmp", 0777);


		# ********************* Receiving post data *********************

		$pdb = $this->request->getPost("pdb");
		$data_folder = getcwd();
		$raiz = str_replace("/public/data", "",$data_folder);

		# Saving project data
		$project = fopen($data_folder.'/'.$id.'/data.pdb','w');
		fwrite($project,$pdb); 
		fclose($project);

		// $config['upload_path'] = "../../public/data/$id";
        // $config['allowed_types'] = '*';
        // $config['max_size'] = 2048;
        // if(!empty($residue)){
		// 	$config['file_name'] = 'raw.pdb';
		// }
		// else{
		// 	$config['file_name'] = 'origin.pdb';
		// // }

        // $this->load->library('upload', $config);

        // if (!$this->upload->do_upload('pdb')){
        // 	$error = array('error' => $this->upload->display_errors());
        // 	print_r($error);
        // }
        // else{
        // 	$data = array('upload_data' => $this->upload->data());
        // }

        # Security
        #chmod("../../public/data/$id", 0644);
				

		# START cocada PIPELINE *******************************************
		system("python $raiz/app/ThirdParty/COCaDA/main.py -f $data_folder/$id/data.pdb -o $data_folder/$id");
		system("/usr/bin/python3.6 $raiz/app/ThirdParty/COCaDA/main.py -f $data_folder/$id/data.pdb -o $data_folder/$id");
		
		# renomeia o arquivo com a lista de contatos
		system("mv $data_folder/$id/*.txt $data_folder/$id/contacts.csv");
		// dd("python3 $raiz/app/ThirdParty/COCaDA/main.py -f $data_folder/$id/data.pdb -o $data_folder/$id");

		$data = array();
		$data['id'] = $id;
		chmod("../../public/data/$id", 0755);

        return view('running', $data);

	}

    private function generateRandomString($size){

		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randomString = '';
		
		for($i = 0; $i < $size; $i = $i+1){
			$randomString .= $chars[mt_rand(0,35)];
		}

		return $randomString;

	}
    
}
