<?php

namespace App\Controllers;

class Project extends BaseController
{

    public function id($id = 'null'){
		# PÁGINA ENTRY

		$id = substr($id, 0, 6);

		# ********************* Search project *********************
		# Read directory
		chdir('data/projects');
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
			$raiz = str_replace("/public/data/projects", "",$data_folder);

			if (!file_exists($data_folder.'/'.$id.'/contacts.csv')) {
				dd("Failed to run the project. Please try again by submitting a file in PDB format or contact the system administrator.");
			}

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

			if (file_exists($data_folder.'/'.$id.'/data.pdb')){
				$data['extensao'] = 'pdb';
			}
			else{
				$data['extensao'] = 'cif';
			}

            return view($view, $data);
		}
	}



    public function create(){
		$filter_chains = $this->request->getPost('filter_chains');
		$chains = $this->request->getPost('chains');
		if(empty($chains)and($filter_chains!='chains')){
			$region = '';
		}
		else{
			$region = '-c '.$chains;
		}
		$ph = $this->request->getPost('ph');

		if($filter_chains == 'inter'){
			$inter = '-i ';
		}
		else{
			$inter = '';
		}

		// contact cutoffs
		$min_hb = $this->request->getPost('minhb'); $max_hb = $this->request->getPost('maxhb');
		$min_hy = $this->request->getPost('minhy'); $max_hy = $this->request->getPost('maxhy');
		$min_ds = $this->request->getPost('minds'); $max_ds = $this->request->getPost('maxds');
		$min_sb = $this->request->getPost('minsb'); $max_sb = $this->request->getPost('maxsb');
		$min_at = $this->request->getPost('minat'); $max_at = $this->request->getPost('maxat');
		$min_re = $this->request->getPost('minre'); $max_re = $this->request->getPost('maxre');
		$min_as = $this->request->getPost('minas'); $max_as = $this->request->getPost('maxas');
		$distances = "$min_sb,$max_sb,$min_hy,$max_hy,$min_hb,$max_hb,$min_re,$max_re,$min_at,$max_at,$min_ds,$max_ds,$min_as,$max_as";

		//dd($filter_chains,$chains,$ph,$min_hb,$max_hb,$min_hy,$max_hy, $min_ds, $max_ds, $min_sb, $max_sb, $min_at, $max_at, $min_re, $max_re, $min_as, $max_as);

		# ********************* Create new ID *********************
		$id = $this->generateRandomString(6);
		
		# Read directory
		if (file_exists('../public/data/projects')) {
			chdir('../public/data/projects');
		}
		else{
			chdir('../data/projects');
		}
		
		$arquivos = glob("{*}", GLOB_BRACE);

		# Is the id unique? If not, create a new!
		for($i = 0; $i < (count($arquivos)); $i++){
			if($arquivos[$i] == $id){
				$id = $this->generateRandomString(6);
				$i = 0;
			}
		}

		# Create project folder 
		mkdir("../../../public/data/projects/$id");
		chmod("../../../public/data/projects/$id", 0777);


		# ********************* Receiving post data *********************

		$pdb = $this->request->getPost("pdb");
		$data_folder = getcwd();
		$raiz = str_replace("/public/data/projects", "",$data_folder);

		# Saving project data
		// $project = fopen($data_folder.'/'.$id.'/data.pdb','w');
		// fwrite($project,$pdb); 
		// fclose($project);


        $file = $this->request->getFile('pdbfile');
		if(!empty($file)){
			$extensao = strtolower(substr($file->getName(), -3, 3));

			if(($extensao=='pdb')or($extensao=='cif')){

				$tamanho = $file->getSize();

				if($tamanho > 10485760){
					dd("Error! Max file size: 10MB.");
				}
				else{
					// Submit file
					if($extensao=='pdb'){
						$file->move("$data_folder/$id", 'data.pdb');
					}
					else{
						$file->move("$data_folder/$id", 'data.cif');
					}
				}
			}
			else{
				dd("Error! Format not allowed. Submit a PDB or a CIF file.");
			}
		}
		else{
			dd("Error: Empty file.");
		}
		

        # Security
        #chmod("../../public/data/$id", 0644);
				
		echo "<div class='bg-info small text-center'><div class='container-fluid px-5'><strong>COCaDA CLI status: </strong>"; // message style box
		# START cocada PIPELINE *******************************************
		$interpretador = "/home/liase/miniconda3/bin/python"; 
		#$interpretador = "python3.8";
		#$interpretador = "/usr/bin/python3.6"; 
		#$interpretador = "/bin/python3";
		#$versao = 'cocada_alfa'; # stable
		$versao = 'COCaDA_web';
		$versao = 'cocada_25.06';
		chmod("../../../public/data/projects/$id", 0777);

		#echo "$interpretador $raiz/app/ThirdParty/$versao/main.py -f $data_folder/$id/data.$extensao -o $data_folder/$id";
		$comando = "$interpretador $raiz/app/ThirdParty/$versao/cocada.py 
		-f $data_folder/$id/data.$extensao 
		-o $data_folder/$id  
		-ph $ph 
		-d $distances 
		$inter $region  
		2>&1";
		$comando = str_replace("\n","",$comando);
		system($comando, $error_log);
		// 	echo $error_log;

		# renomeia o arquivo com a lista de contatos
		#system("mv $data_folder/$id/*.txt $data_folder/$id/contacts.csv");
		// dd("python3 $raiz/app/ThirdParty/COCaDA/main.py -f $data_folder/$id/data.pdb -o $data_folder/$id");

		$data = array();
		$data['id'] = $id;
		echo '</div></div>'; // end message style box
		chmod("../../../public/data/projects/$id", 0755);

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
