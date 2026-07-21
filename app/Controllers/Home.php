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

    // Endpoint de dados do Explore (DataTables server-side). Lê data/pdb/list.csv
    // (5 colunas: ID, Description, Residues, Contacts, pH), aplica busca global,
    // ordenação e paginação, e devolve JSON. Sem banco de dados.
    public function exploreData()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(60);

        $req    = $this->request;
        $draw   = (int) $req->getGet('draw');
        $start  = (int) $req->getGet('start');
        $length = (int) $req->getGet('length');
        if ($length <= 0) {
            $length = 25;
        }

        $searchArr = $req->getGet('search');
        $search    = strtolower(trim($searchArr['value'] ?? ''));

        $orderArr = $req->getGet('order');
        $orderCol = (int) ($orderArr[0]['column'] ?? 0);
        $orderDir = (($orderArr[0]['dir'] ?? 'asc') === 'desc') ? 'desc' : 'asc';

        $numericCols = [2, 3, 4]; // Residues, Contacts, pH

        $file   = "./data/pdb/list.csv";
        $result = ['draw' => $draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []];

        if (!file_exists($file)) {
            return $this->response->setJSON($result);
        }

        $handle = fopen($file, 'r');
        if ($handle === false) {
            return $this->response->setJSON($result);
        }

        // O list.csv não está totalmente ordenado, então sempre ordenamos.
        $isNumericSort = in_array($orderCol, $numericCols, true);
        $total         = 0;
        $matched       = [];

        while (($line = fgets($handle)) !== false) {
            $line = rtrim($line, "\r\n");
            if ($line === '') {
                continue;
            }
            $total++;
            if ($search !== '' && strpos(strtolower($line), $search) === false) {
                continue;
            }
            $row = explode(',', $line);
            if (count($row) < 5) {
                continue;
            }
            $key       = $isNumericSort ? (float) $row[$orderCol] : strtolower($row[$orderCol]);
            $matched[] = [$key, $line];
        }
        fclose($handle);

        $recordsFiltered = count($matched);

        usort($matched, function ($a, $b) use ($isNumericSort, $orderDir) {
            $cmp = $isNumericSort ? ($a[0] <=> $b[0]) : strcmp($a[0], $b[0]);
            return $orderDir === 'asc' ? $cmp : -$cmp;
        });

        $data = [];
        foreach (array_slice($matched, $start, $length) as $item) {
            $data[] = explode(',', $item[1]);
        }

        $result['recordsTotal']    = $total;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data']            = $data;
        return $this->response->setJSON($result);
    }

    public function advancedSearch(): string
    {
        $data = [];
        $data['maxes'] = $this->advancedListMaxes();
        return view('advanced_search', $data);
    }

    // Máximo de cada coluna numérica do advanced_list.csv (para o max dos sliders).
    // Faz cache num JSON para não reprocessar o arquivo a cada abertura da página.
    private function advancedListMaxes(): array
    {
        $csv         = "./data/pdb/advanced_list.csv";
        $cache       = "./data/pdb/advanced_list_maxes.json";
        $numericCols = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

        if (file_exists($cache) && file_exists($csv) && filemtime($cache) >= filemtime($csv)) {
            $j = json_decode(file_get_contents($cache), true);
            if (is_array($j)) {
                return $j;
            }
        }

        $max = array_fill_keys($numericCols, 0);
        if (file_exists($csv)) {
            $h = fopen($csv, 'r');
            while (($line = fgets($h)) !== false) {
                $line = rtrim($line, "\r\n");
                if ($line === '') {
                    continue;
                }
                $row = explode(',', $line);
                if (count($row) < 16) {
                    continue;
                }
                foreach ($numericCols as $c) {
                    $v = (float) $row[$c];
                    if ($v > $max[$c]) {
                        $max[$c] = $v;
                    }
                }
            }
            fclose($h);
            @file_put_contents($cache, json_encode($max));
        }

        return $max;
    }

    // Verdadeiro se o ID (minúsculo) contém qualquer um dos tokens buscados.
    private function matchesIdTokens(string $idLower, array $tokens): bool
    {
        foreach ($tokens as $t) {
            if ($t !== '' && strpos($idLower, $t) !== false) {
                return true;
            }
        }
        return false;
    }

    // Exporta os resultados atuais da busca avançada (todos os que casam com os
    // filtros, não só a página) como um arquivo CSV para download.
    public function advancedSearchExport()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(120);

        $req    = $this->request;
        $search = strtolower(trim($req->getGet('search') ?? ''));
        $fId    = strtolower(trim($req->getGet('f_id') ?? ''));
        // PDB ID aceita lista separada por vírgula ou espaço (casa qualquer um)
        $idTokens = ($fId !== '') ? preg_split('/[\s,]+/', $fId, -1, PREG_SPLIT_NO_EMPTY) : [];
        $fDesc  = strtolower(trim($req->getGet('f_desc') ?? ''));
        $fBa    = trim($req->getGet('f_ba') ?? '');
        $ranges = $req->getGet('ranges') ?? [];

        $orderCol = (int) ($req->getGet('order_col') ?? 0);
        $orderDir = (($req->getGet('order_dir') ?? 'asc') === 'desc') ? 'desc' : 'asc';

        $numericCols  = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
        $activeRanges = [];
        foreach ((array) $ranges as $col => $mm) {
            $min = (isset($mm['min']) && $mm['min'] !== '') ? (float) $mm['min'] : null;
            $max = (isset($mm['max']) && $mm['max'] !== '') ? (float) $mm['max'] : null;
            if ($min !== null || $max !== null) {
                $activeRanges[(int) $col] = ['min' => $min, 'max' => $max];
            }
        }

        $file          = "./data/pdb/advanced_list.csv";
        $isNumericSort = in_array($orderCol, $numericCols, true);
        $matched       = [];

        if (file_exists($file) && ($h = fopen($file, 'r')) !== false) {
            while (($line = fgets($h)) !== false) {
                $line = rtrim($line, "\r\n");
                if ($line === '') {
                    continue;
                }
                $row = explode(',', $line);
                if (count($row) < 16) {
                    continue;
                }
                if (!empty($idTokens) && !$this->matchesIdTokens(strtolower($row[0]), $idTokens)) { continue; }
                if ($fDesc !== '' && strpos(strtolower($row[1]), $fDesc) === false) { continue; }
                if ($fBa !== '') {
                    $ba = (strtolower(trim($row[15])) === 'yes') ? 'Yes' : 'No';
                    if ($ba !== $fBa) { continue; }
                }
                if (!empty($activeRanges)) {
                    $skip = false;
                    foreach ($activeRanges as $col => $mm) {
                        $val = (float) ($row[$col] ?? 0);
                        if ($mm['min'] !== null && $val < $mm['min']) { $skip = true; break; }
                        if ($mm['max'] !== null && $val > $mm['max']) { $skip = true; break; }
                    }
                    if ($skip) { continue; }
                }
                if ($search !== '' && strpos(strtolower($line), $search) === false) { continue; }

                $key       = $isNumericSort ? (float) $row[$orderCol] : strtolower($row[$orderCol]);
                $matched[] = [$key, $row];
            }
            fclose($h);
        }

        if (!($orderCol === 0 && $orderDir === 'asc')) {
            usort($matched, function ($a, $b) use ($isNumericSort, $orderDir) {
                $cmp = $isNumericSort ? ($a[0] <=> $b[0]) : strcmp($a[0], $b[0]);
                return $orderDir === 'asc' ? $cmp : -$cmp;
            });
        }

        $header = ['ID', 'Description', 'Num_Residues', 'Num_Contacts', 'HB', 'HY', 'AT', 'RE', 'SB', 'DS', 'AS', 'uAT', 'uRE', 'uSB', 'pH', 'Biological_Assembly'];

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="cocada_advanced_search.csv"');
        $out = fopen('php://output', 'w');
        // parâmetros explícitos (separador, aspas, escape) evitam a deprecação do
        // $escape em PHP 8.4+ e mantêm o comportamento padrão no 8.1
        fputcsv($out, $header, ',', '"', '\\');
        foreach ($matched as $item) {
            fputcsv($out, $item[1], ',', '"', '\\');
        }
        fclose($out);
        exit;
    }

    // Endpoint de dados para a busca avançada (DataTables server-side processing).
    // Lê o CSV (sem banco), aplica busca/filtros/ordenação/paginação e devolve JSON.
    public function advancedSearchData()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(60);

        $req    = $this->request;
        $draw   = (int) $req->getGet('draw');
        $start  = (int) $req->getGet('start');
        $length = (int) $req->getGet('length');
        if ($length <= 0) {
            $length = 25;
        }

        // busca global (caixa padrão do DataTables)
        $searchArr = $req->getGet('search');
        $search    = strtolower(trim($searchArr['value'] ?? ''));

        // ordenação
        $orderArr = $req->getGet('order');
        $orderCol = (int) ($orderArr[0]['column'] ?? 0);
        $orderDir = (($orderArr[0]['dir'] ?? 'asc') === 'desc') ? 'desc' : 'asc';

        // filtros customizados (enviados via ajax.data)
        $fId    = strtolower(trim($req->getGet('f_id') ?? ''));
        // PDB ID aceita lista separada por vírgula ou espaço (casa qualquer um)
        $idTokens = ($fId !== '') ? preg_split('/[\s,]+/', $fId, -1, PREG_SPLIT_NO_EMPTY) : [];
        $fDesc  = strtolower(trim($req->getGet('f_desc') ?? ''));
        $fBa    = trim($req->getGet('f_ba') ?? '');
        $ranges = $req->getGet('ranges') ?? [];

        $numericCols = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

        // normaliza os ranges ativos: [colIndex => ['min'=>?, 'max'=>?]]
        $activeRanges = [];
        foreach ((array) $ranges as $col => $mm) {
            $min = (isset($mm['min']) && $mm['min'] !== '') ? (float) $mm['min'] : null;
            $max = (isset($mm['max']) && $mm['max'] !== '') ? (float) $mm['max'] : null;
            if ($min !== null || $max !== null) {
                $activeRanges[(int) $col] = ['min' => $min, 'max' => $max];
            }
        }

        $hasFilters = ($fId !== '' || $fDesc !== '' || $fBa !== '' || $search !== '' || !empty($activeRanges));

        $file   = "./data/pdb/advanced_list.csv";
        $result = ['draw' => $draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []];

        if (!file_exists($file)) {
            return $this->response->setJSON($result);
        }

        $handle = fopen($file, 'r');
        if ($handle === false) {
            return $this->response->setJSON($result);
        }

        // CAMINHO RÁPIDO: sem filtros e ordenação padrão (col 0 asc). O arquivo já
        // está ordenado por ID asc, então lemos apenas a janela pedida.
        if (!$hasFilters && $orderCol === 0 && $orderDir === 'asc') {
            $total     = 0;
            $windowEnd = $start + $length;
            $data      = [];
            while (($line = fgets($handle)) !== false) {
                $line = rtrim($line, "\r\n");
                if ($line === '') {
                    continue;
                }
                if ($total >= $start && $total < $windowEnd) {
                    $data[] = explode(',', $line);
                }
                $total++;
            }
            fclose($handle);

            $result['recordsTotal']    = $total;
            $result['recordsFiltered'] = $total;
            $result['data']            = $data;
            return $this->response->setJSON($result);
        }

        // CAMINHO GERAL: filtra em streaming e guarda [chaveDeOrdenacao, linha]
        $isNumericSort = in_array($orderCol, $numericCols, true);
        $total         = 0;
        $matched       = [];

        while (($line = fgets($handle)) !== false) {
            $line = rtrim($line, "\r\n");
            if ($line === '') {
                continue;
            }
            $total++;
            $row = explode(',', $line);
            if (count($row) < 16) {
                continue;
            }

            if (!empty($idTokens) && !$this->matchesIdTokens(strtolower($row[0]), $idTokens)) {
                continue;
            }
            if ($fDesc !== '' && strpos(strtolower($row[1]), $fDesc) === false) {
                continue;
            }
            if ($fBa !== '') {
                $ba = (strtolower(trim($row[15])) === 'yes') ? 'Yes' : 'No';
                if ($ba !== $fBa) {
                    continue;
                }
            }
            if (!empty($activeRanges)) {
                $skip = false;
                foreach ($activeRanges as $col => $mm) {
                    $val = (float) ($row[$col] ?? 0);
                    if ($mm['min'] !== null && $val < $mm['min']) { $skip = true; break; }
                    if ($mm['max'] !== null && $val > $mm['max']) { $skip = true; break; }
                }
                if ($skip) {
                    continue;
                }
            }
            if ($search !== '' && strpos(strtolower($line), $search) === false) {
                continue;
            }

            $key       = $isNumericSort ? (float) $row[$orderCol] : strtolower($row[$orderCol]);
            $matched[] = [$key, $line];
        }
        fclose($handle);

        $recordsFiltered = count($matched);

        // Ordena (o arquivo já vem ordenado por ID asc, então col 0 asc dispensa sort)
        if (!($orderCol === 0 && $orderDir === 'asc')) {
            usort($matched, function ($a, $b) use ($isNumericSort, $orderDir) {
                $cmp = $isNumericSort ? ($a[0] <=> $b[0]) : strcmp($a[0], $b[0]);
                return $orderDir === 'asc' ? $cmp : -$cmp;
            });
        }

        $data = [];
        foreach (array_slice($matched, $start, $length) as $item) {
            $data[] = explode(',', $item[1]);
        }

        $result['recordsTotal']    = $total;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data']            = $data;
        return $this->response->setJSON($result);
    }

    private function getInfo($id, $base = 'pdb'): Array
    {
        $first_letter = substr($id, 0, 1);
        $url = "./data/$base/$first_letter/$id/$id"."_info.csv";

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


    private function getContacts($id, $base = 'pdb'): Array
    {
        $contacts = [];
        $first_letter = substr($id, 0, 1);

        # contacts
        $url = "./data/$base/$first_letter/$id/$id"."_contacts.csv";
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

    // Baixa (se necessário) a estrutura do biological assembly do RCSB.
    // O RCSB serve um mmCIF compactado (.cif.gz); baixamos e descompactamos,
    // guardando localmente em data/pdb_biologicalassembly/.../{id}-assembly1.cif
    private function ensureAssemblyStructure(string $id): bool
    {
        $first_letter = substr($id, 0, 1);
        $folder = "./data/pdb_biologicalassembly/$first_letter/$id/";
        $cif = $folder . $id . "-assembly1.cif";

        if (file_exists($cif)) {
            return true; // já em cache
        }
        if (!is_dir($folder)) {
            return false; // sem pasta de assembly para este código
        }

        // Ex.: https://files.rcsb.org/download/2LZM-assembly1.cif.gz
        $url = "https://files.rcsb.org/download/" . strtoupper($id) . "-assembly1.cif.gz";

        $gz = false;
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $gz = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($code !== 200) {
                $gz = false;
            }
        } else {
            $gz = @file_get_contents($url);
        }

        if ($gz === false || $gz === '') {
            return false;
        }

        // Descompacta o gzip (equivalente ao "gunzip")
        $plain = @gzdecode($gz);
        if ($plain === false) {
            return false;
        }

        return file_put_contents($cif, $plain) !== false;
    }

    public function biologicalAssembly($id): string
    {
        $data = [];
        $data['id'] = $id;

        // código inexistente
        if (strlen($id) != 4) {
            return view('404', $data);
        }

        // Sem arquivos de biological assembly na pasta? Mostra página informativa.
        $first_letter = substr($id, 0, 1);
        $info_file = "./data/pdb_biologicalassembly/$first_letter/$id/$id" . "_info.csv";
        if (!file_exists($info_file)) {
            return view('biological_assembly_missing', $data);
        }

        // Garante a estrutura 3D (baixa/descompacta se ainda não estiver em cache).
        // Se falhar, a página ainda é exibida (tabela de contatos funciona; o 3D
        // apenas não carrega).
        $this->ensureAssemblyStructure($id);

        // pega informações básicas (da pasta do biological assembly)
        $data['info'] = $this->getInfo($id, 'pdb_biologicalassembly');
        if ($data['info'][0] == "File not exist.") {
            return view('biological_assembly_missing', $data);
        }
        $data['total_results'] = $data['info'][3];
        // pega informações de contatos (da pasta do biological assembly)
        $data['contacts'] = $this->getContacts($id, 'pdb_biologicalassembly');

        return view('biological_assembly', $data);
    }

}
