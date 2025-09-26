import pymol
from pymol import cmd
import csv
import os
import argparse

# Define colors for interaction types
contact_colors = {
    'HY': 'red',    # Hydrophobic
    'HB': 'blue',   # Hydrogen bond
    'AT': 'green',  # Attraction
    'uAT': 'green',  # Possible Attraction
    'RE': 'orange',  # Repulsion
    'uRE': 'orange',   # Possible Repulsion
    'SB': 'pink',    # Salt bridge
    'uSB': 'pink', # Possible Salt bridge
    'DS': 'purple',  # Disulfide bond
    'AS': 'yellow'   # Aromatic stacking
}

# Thickness of lines between interacting atoms
line_thickness = {
    'HY': 1.0,
    'HB': 2.0,
    'AT': 3.0,
    'uAT': 3.0,
    'RE': 3.0,
    'uRE': 3.0,
    'SB': 3.0,
    'uSB': 3.0,
    'DS': 4.0,
    'AS': 4.0
}


def load_contacts(protein_input, csv_file):
    cmd.reinitialize()
    
    # Check if the input is a file or a protein ID
    protein_id, type = os.path.splitext(os.path.basename(protein_input))
    if type == ".cif" or type == ".pdb":
        protein_id = os.path.splitext(os.path.basename(protein_input))[0]
        cmd.load(protein_input, protein_id) # Load the PDB file
    else:
        cmd.fetch(protein_id, protein_id, type="cif") # Fetch the protein structure from the PDB

    cmd.show("cartoon", protein_id) 
    cmd.remove("resn HOH") 
    cmd.util.color_chains("all") 

    # Store interactions and residues
    interactions = {key: [] for key in contact_colors.keys()}
    interacting_residues = {key: [] for key in contact_colors.keys()}

    chain_list = set() # List to store unique chains

    with open(csv_file, 'r') as f:
        reader = csv.reader(f)
        next(reader)
        for row in reader:
            chain1, res1, resname1, atom1, chain2, res2, resname2, atom2, distance, interaction_type = row
            if interaction_type not in contact_colors:
                continue
            
            chain_list.add(chain1)
            chain_list.add(chain2)

            atom_selection1 = f"(polymer.protein and chain {chain1} and resi {res1} and name {atom1})"
            atom_selection2 = f"(polymer.protein and chain {chain2} and resi {res2} and name {atom2})"
            resi_selection1 = f"polymer.protein and chain {chain1} and resi {res1}"
            resi_selection2 = f"polymer.protein and chain {chain2} and resi {res2}"

            if cmd.count_atoms(atom_selection1) == 0:
                print(f"Warning: No atoms found for {atom_selection1}")
                continue
            if cmd.count_atoms(atom_selection2) == 0:
                print(f"Warning: No atoms found for {atom_selection2}")
                continue

            interactions[interaction_type].append((atom_selection1, atom_selection2, float(distance)))
            interacting_residues[interaction_type].append(resi_selection1)
            interacting_residues[interaction_type].append(resi_selection2)
    
    # Map each chain to a fixed “pale” color
    chain_list = sorted(chain_list)
    pale_colors = ["palegreen", "palecyan", "lightpink", "paleyellow",
                   "wheat", "bluewhite", "lightblue", "lightorange"]
    chain_to_pale = {chain: pale_colors[i % len(pale_colors)] for i, chain in enumerate(chain_list)}

    # Visualize interactions
    for interaction_type, contacts in interactions.items():
        if not contacts:
            print(f"No contacts for {interaction_type}")
            continue

        print(f"Interaction {interaction_type}: {len(contacts)} contacts found")

        obj_name = f"contacts_{interaction_type}"
        cmd.distance(obj_name, "none", "none")

        for sel1, sel2, distance in contacts:
            thickness = line_thickness.get(interaction_type, 1.0)
            color = contact_colors.get(interaction_type, "yellow")
            cmd.distance(obj_name, sel1, sel2)

        cmd.set("dash_color", color, obj_name)
        cmd.set("dash_width", thickness, obj_name)

        group_name = f"group_{interaction_type}"
        cmd.group(group_name, obj_name, "add")
        cmd.group(group_name, "close")

    # Highlight involved residues with the corresponding pale color for each chain
    for interaction_type, residues in interacting_residues.items():
        residues = list(set(residues))
        if residues:
            obj_name = f"residues_{interaction_type}"
            cmd.select("temp", " or ".join(residues))
            cmd.create(obj_name, "temp")
            cmd.delete("temp")
            # Apply pale color based on chain
            for chain, pale_color in chain_to_pale.items():
                cmd.color(pale_color, f"{obj_name} and chain {chain}")
            cmd.show("sticks", obj_name) 
            cmd.hide("cartoon", obj_name)
            cmd.group(f"group_{interaction_type}", obj_name, "add")
            cmd.disable(f"group_{interaction_type}")

    cmd.orient()
    cmd.save(f"{protein_id}_visualization.pse")

# ======================== Main ========================
parser = argparse.ArgumentParser(description="Visualize protein-protein interactions in PyMOL.")
parser.add_argument("protein", help="Protein ID (e.g., 1AON) or path to PDB/CIF file")
parser.add_argument("csv_file", help="Path to the CSV file with interaction data")

args = parser.parse_args()

if not os.path.exists(args.csv_file):
    raise FileNotFoundError(f"Error: CSV file '{args.csv_file}' not found.")

load_contacts(args.protein, args.csv_file)
