def remove_remark_lines(file_path):
    # Ler todas as linhas do arquivo original
    with open(file_path, 'r') as file:
        lines = file.readlines()

    # Filtrar as linhas que não começam com "REMARK"
    filtered_lines = [line for line in lines if not line.startswith('REMARK') and not line.startswith('SEQRES') and not line.startswith('HELIX') and not line.startswith('SHEET')]

    # Escrever as linhas filtradas de volta no mesmo arquivo
    with open(file_path, 'w') as file:
        file.writelines(filtered_lines)


import glob

entrada = "structures"
pastas = glob.glob(entrada+'/*')
tam = len(pastas)
cont = 0
for i in pastas:
    cont+=1
    print(cont, '/', tam)
    nome = i[-8:]
    remove_remark_lines(i+"/"+nome+'.pdb')