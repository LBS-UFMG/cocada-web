<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<div class="container py-5 text-secondary">
<!-- Conteúdo personalizado -->

<h1 class="pb-2 text-dark"><strong>Documentation</strong></h1>
<hr>
<h3 class="pt-4 pb-1">What is COCαDA?</h3>
<p><strong>COCαDA</strong> (Contact Optimization by alpha-Carbon Distance Analysis) is a tool for calculating intra- and inter-molecular contacts in proteins. COCαDA optimizes the calculation of atomic interactions in proteins, by using a set of fine-tuned Cα distances between every pair of aminoacid residues. The code includes a customized parser for both PDB and CIF files, containing functionalities for handling large files, filtering out specific residues and interactions, and calculating geometric properties such as centroid and normal vectors for aromatic residues.</p>

<p>The contact types available are:</p>
<ul>
<li>Hydrophobic</li>
<li>Hydrogen Bond</li>
<li>Attractive</li>
<li>Repulsive</li>
<li>Disulfide Bond</li>
<li>Salt Bridge</li>
<li>Aromatic Stacking</li>
</ul>

<h4 class="pt-4 pb-1">What is COCαDA-web?</h4>
<p><strong>COCαDA-web</strong> is a user-friendly web interface for using the COCαDA command line tool. COCαDA-web contains a database of pre-calculated contacts for all structures available in the PDB (Protein Data Bank).</p>
<br>
<hr>

<h4 class="pt-4 pb-1" id="cutoff_values">Contact rules</h4>
<table class="table table-condensed table-hover table-striped">
  <caption><strong>Distance criteria for defining contacts:</strong> dist = Euclidean distance between the atom pair.</caption>
  <thead>
    <tr>
      <th>Contact Type</th>
      <th>Distance range (Å)</th>
      <th>Description</th>
      <th>Acronym</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Hydrogen Bond</td>
      <td>0 ≤ dist ≤ 3.9</td>
      <td>Acceptor and Donor atom pair</td>
      <td>HB</td>
    </tr>
    <tr>
      <td>Disulfide Bond</td>
      <td>0 ≤ dist ≤ 2.8</td>
      <td>Cys:SG atom pair</td>
      <td>DS</td>
    </tr>
    <tr>
      <td>Hydrophobic</td>
      <td>2.0 ≤ dist ≤ 4.5</td>
      <td>Hydrophobic atom pair</td>
      <td>HY</td>
    </tr>
    <tr>
      <td>Repulsive</td>
      <td>2.0 ≤ dist ≤ 6.0</td>
      <td>Equally charged atoms</td>
      <td>RE</td>
    </tr>
    <tr>
      <td>Attractive</td>
      <td>3.9 ≤ dist ≤ 6.0</td>
      <td>Differently charged atoms</td>
      <td>AT</td>
    </tr>
    <tr>
      <td>Salt Bridge</td>
      <td>0 ≤ dist ≤ 3.9</td>
      <td>Equally charged atoms AND hydrogen bonding</td>
      <td>SB</td>
    </tr>
    <tr>
      <td>Aromatic Stacking</td>
      <td>2.0 ≤ dist ≤ 5.0</td>
      <td>Centroids of two aromatic rings in <br>parallel or perpendicular orientation</td>
      <td>AS</td>
    </tr>
  </tbody>
</table>


<h3 class="pt-5 pb-1">How to use COCαDA-web</h3>

<h4 class="pt-2 pb-1" id="landing_page1">Landing Page</h4>

<p>On the upper part of landing page of COCαDA-web, the user can see the navigation bar (1) and the search bar (2). Below, a short description of the tool is given, with the options to run it or see examples (3). There are also database statistics (4), with the total number of contacts, intra- and inter-chain contacts, and the number of processed PDB structures. At the end of the upper part, the user can see the reference for the tool (5).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/landing1.png" class="w-50">
</p>


<p>Scrolling down the landing page, or clicking on the "try now" button on the navigation bar and the "run" button on the upper part, the user can see the bottom part of the landing page. There are two ways to use COCαDA-web: through the submission of local <code>.pdb</code> or <code>.cif</code> files (1), or through the PDB ID of the protein (2). Also, there are some examples for different groups of proteins (3), and the current version of the tool (4).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/landing2.png" class="w-50" id="landing_page2">
</p>

<h4 class="pt-4 pb-1" id="explore_page">Explore Page</h4>

<p>The explore page can be accessed using the "explore" button on the navigation bar, and exhibits a dynamic list of all entries of the database. The user can search specific entries (1), and all columns of the list can be sorted by ascending and descending order. The columns are: PDB ID's (2), description of the proteins (3), their sizes in residues (4), and the number of contacts in their structures (5). The total number of contacts and the results pagination can be seen at the bottom (6).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/explore.png" class="w-50">
</p>

<h4 class="pt-4 pb-1" id="results_page">Results Page</h4>

<p>The results page for a given protein can be accessed either via clicking an entry on the explore page, or by submitting a local .pdb or .cif file. Using as example the PDB ID 101M, the user can download the results in .csv format (1), see the protein contact map (2), its description (3), the number of contacts of each type (4), and the total number of contacts (5). The results can filtered by contact type (6) or by a specific contact (7).</p>

<p>The list of contacts (8) showcases the full information for each individual contact in the protein, and each column can can be sorted by ascending and descending order. The columns are: contact name; protein chain of the first atom; residue of the first atom; name of the first atom; protein chain of the second atom; residue of the second atom; name of the second atom; distance between the atom pair, in angstroms; localization of the contact (intra-chain or inter-chain); and contact type.</p>

<p>A dynamic and interactive visualization of the protein can be seen on the right-hand side of the page (9), reflecting the selected contacts on the results list. On the bottom of the page (10), the user can see the total of contacts present in the current filter, as well as the pagination of the results.</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/results.png" class="w-50">
</p>

<h4 class="pt-4 pb-1" id="contact_map">Contact Map</h4>

<p>Next to the download button on the results page, the user can view the protein contact map in an interactive pop-up window. Since this is a two-dimensional representation of a protein's contacts, each axis of the map represents a polypeptide chain, both of which can be dynamically adjusted (1 for the X-axis and 2 for the Y-axis). In this way, inter-chain contacts can be visualized by selecting different chains in the menus, and the maps can also be saved in ".png" format (3).</p>

<p>In the interactive view of the selected pair of chains (4), the colors of each contact represent the predominant type for each pair of residues shown, according to the legend at the bottom (6). Additionally, each point on the map can be examined in detail using the cursor (5), where complete information about all contacts made by the selected pair of residues is displayed.</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/contactmap.png" class="w-50">
</p>

<br>
<hr>

<h2 class="pt-5 pb-1">Types of Bonds and Interactions used in COCαDA-web</h2>

<h4 class="pt-4 pb-1" id="disulfide_bond">Disulfide Bonds</h4>

<p>Disulfide bonds are one type of covalent bonds present in proteins, yet they are still weaker than peptide bonds. Formed exclusively by the sulfur atoms of the thiol (-SH) groups from a pair of cysteine residues, disulfide bonds are extremely important in the folding process and stability of certain proteins (Sevier2002).</p>

<p>Since the intracellular environments of living organisms are predominantly reducing, proteins containing disulfide bridges tend to be unstable in the cellular cytosol. As a result, the formation of these bonds typically occurs in specific regions and in the presence of catalysts, such as the endoplasmic reticulum in eukaryotes, the periplasm in prokaryotes, and the intermembrane space in mitochondria (Sevier2002, Hatahet2010).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/disulfide.png">
</p>

<h4 class="pt-4 pb-1" id="hydrogen_bond">Hydrogen Bonds</h4>

<p>Hydrogen bonds are a type of weak, short-range interaction that can occur between atoms of amino acid residues, playing an essential role in the folding process and functionality of proteins (Saenger1994, Agostini2019). With an electrostatic component, hydrogen bonds arise due to the difference in electronegativity between hydrogen atoms and other more electronegative atoms. In the case of amino acids, the only two atoms electronegative enough are oxygen (O) and nitrogen (N), both of which are key components of amino acids (Nelson2012).</p>

<p>When covalently bonded to one of these atoms, the hydrogen atom's electron cloud shifts toward the bond, creating two poles of opposite charges between them. Due to the partial charge generated on the hydrogen atom by this shift, it can then interact with another electronegative atom that has a partial negative charge. This third atom is called a hydrogen acceptor and forms a weak, attractive bond with the hydrogen atom (Nelson2012, Kessel2018). In addition to occurring between amino acid atoms themselves, hydrogen bonds can also be mediated by water molecules, which make up nearly the entire volume of intra- and extracellular environments in vivo (Saenger1994).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/hb.png">
</p>

<h4 class="pt-4 pb-1">Hydrophobic Interactions</h4>

<p>Due to their side chains (-R), amino acids can exhibit polarity properties, making them either polar or nonpolar. In a protein, the combination of these characteristics generates hydrophobic (nonpolar) and hydrophilic (polar) regions within its structure (Camilloni2016). A chemical environment composed solely of water molecules features numerous hydrogen bonds between them, forming a stable structure (Levy2006). However, when any solute (such as a protein) is introduced into this environment, the resulting disturbance breaks hydrogen bonds among nearby water molecules, which then reestablish bonds directly with the solute (Dunn2010, Kessel2018).</p>

<p>Since these interactions can only occur between polar molecules, the nonpolar regions of a protein tend to aggregate within its structure to interact with each other, thereby avoiding contact with water molecules. These interactions between nonpolar molecules are known as hydrophobic interactions and are critically important for protein folding (Kauzmann1959, Pace2011).


<h4 class="pt-4 pb-1" id="electrostatic_interaction">Electrostatic Interactions and Salt Bridges</h4>

<p>Just like polar and nonpolar side chains, amino acids can also have charged chemical groups in their side chains. This is the case for lysine (K), arginine (R), and histidine (H), which carry positive charges, as well as aspartic acid (D) and glutamic acid (E), which also carry positive charges. Thus, amino acids with the same charge on their side chains form a repulsive electrostatic interaction, whereas those with opposite charges form an attractive electrostatic interaction (Nelson2012).</p>

<p>The charges on the side chains of these five ionizable amino acids play various structural and functional roles, such as pH-mediated protein denaturation, ion transport across membranes, and metal binding (Zhou2018). Additionally, other neutral amino acids can be ionized through the addition of charged chemical groups, as seen in the phosphorylation and dephosphorylation of serine (S), threonine (T), and tyrosine (Y) residues (Hunter2012).</p>

<p>Since electrostatic interactions are a broad category that includes even hydrogen bonds, the term "salt bridge" is commonly used to describe a specific type of attractive electrostatic interaction (Kumar1999, Sinha2002). In salt bridges, the interaction occurs exclusively between fully ionized side chain groups and is further defined as an attractive electrostatic interaction in which at least one of the heavy atoms is within hydrogen bond distance (Donald2011).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/electrostatic.png">
</p>

<h4 class="pt-4 pb-1" alt="aromatic_stacking">Aromatic Stackings</h4>

<p>Aromatic stacking occurs exclusively between molecules that contain aromatic groups, also known as aromatic rings. In proteins, these groups are present in three amino acids: phenylalanine (F), tyrosine (Y), and tryptophan (W). The aromatic rings of these amino acids are composed of conjugated double bond systems, in which the electrons of the π orbital are delocalized, providing resonance and stability to the system (Kessel2018).</p>

<p>When two aromatic rings interact directly, this is known as π–π stacking, which can be further classified based on the geometry of the interaction (Smith2007). The simplest form is called "face-to-face" (or parallel), where the rings align in a parallel fashion. However, due to the repulsive nature of π-orbital overlap, the parallel geometry is relatively rare (McGaughey1998). The most common interaction patterns are "perpendicular" (T-shaped) and "parallel-displaced", both of which have attractive character (Martinez2012).</p>

<p align="center">
  <img src="<?=base_url('/img')?>/docs/stacking.png">
</p>

<br>
<hr>

<h3 class="pt-4 pb-1">References</h3>

<div class="text-muted small">
<p>Agostini, A., Meneghin, E., Gewehr, L., Pedron, D., Palm, D. M., Carbo- nera, D., Paulsen, H., Jaenicke, E., and Collini, E. (2019). <strong>How water-mediated hydrogen bonds affect chlorophyll a/b selectivity in Water-Soluble chlorophyll protein.</strong> Sci. Rep., 9(1):18255.</p>
<p>Camilloni, C., Bonetti, D., Morrone, A., Giri, R., Dobson, C. M., Brunori, M., Gianni, S., e Vendruscolo, M. (2016). <strong>Towards a structural biology of the hydrophobic effect in protein folding.</strong> Sci. Rep., 6(1).</p>
<p> Donald, J. E., Kulp, D. W., e DeGrado, W. F. (2011). <strong>Salt bridges: geometrically specific, designable interactions.</strong> Proteins, 79(3):898–915.</p>
<p> Dunn, M. F. (2010). <strong>Protein-Ligand Interactions: General Description.</strong> John Wiley & Sons, Ltd, Chichester, UK.</p>
<p> Hatahet, F., Nguyen, V. D., Salo, K. E. H., and Ruddock, L. W. (2010). <strong>Disruption of reducing pathways is not essential for efficient disulfide bond formation in the cytoplasm of e. coli.</strong> Microb. Cell Fact., 9(1):67.</p>
<p> Hunter, T. (2012). <strong>Why nature chose phosphate to modify proteins.</strong> Philos. Trans. R. Soc. Lond. B Biol. Sci., 367(1602):2513–2516.</p>
<p> Kauzmann, W. (1959). <strong>Some factors in the interpretation of protein denaturation.</strong> In Advances in Protein Chemistry, Advances in protein chemistry, pages 1–63. Elsevier.</p>
<p> Kessel, A. and Ben-Tal, N. (2018). <strong>Introduction to proteins: Structure, function, and motion.</strong> Chapman & Hall/CRC, Philadelphia, PA.</p>
<p> Kumar, S. e Nussinov, R. (1999). <strong>Salt bridge stability in monomeric proteins.</strong> J. Mol. Biol., 293(5):1241–1255.</p>
<p> Levy, Y. and Onuchic, J. N. (2006). <strong>Water mediation in protein folding and molecular recognition.</strong> Annu. Rev. Biophys. Biomol. Struct., 35(1):389–415.</p>
<p>Martinez, C. R. and Iverson, B. L. (2012). <strong>Rethinking the term “pi-stacking”.</strong> Chem. Sci., 3(7):2191.</p>
<p>McGaughey, G. B., Gagn´e, M., and Rapp´e, A. K. (1998). <strong>Π-stacking interactions.</strong> J. Biol. Chem., 273(25):15458–15463</p>
<p> Nelson, D. L. and Cox, M. M. (2012). <strong>Lehninger principles of biochemistry.</strong> W.H. Freeman, New York, NY, 6 edition.</p>
<p> Pace, C. N., Fu, H., Fryar, K. L., Landua, J., Trevino, S. R., Shirley, B. A., Hendricks, M. M., Iimura, S., Gajiwala, K., Scholtz, J. M., and Grimsley, G. R. (2011). <strong>Contribution of hydrophobic interactions to protein stability.</strong> J. Mol. Biol., 408(3):514–528.</p>
<p> Saenger, W. and Jeffrey, G. A. (1994). <strong>Hydrogen bonding in biological structures.</strong> Springer, Berlin, Germany.</p>
<p> Sevier, C. S. and Kaiser, C. A. (2002). <strong>Formation and transfer of disulphide bonds in living cells.</strong> Nat. Rev. Mol. Cell Biol., 3(11):836–847.</p>
<p> Sinha, N. and Smith-Gill, S. (2002). <strong>Electrostatics in protein binding and function.</strong> Curr. Protein Pept. Sci., 3(6):601–614.</p>
<p> Smith, M. B. e March, J. (2007). <strong>March’s advanced organic chemistry.</strong> John Wiley & Sons, 6 edition.</p>
<p> Zhou, H.-X. and Pang, X. (2018). <strong>Electrostatic interactions in protein structure, folding, binding, and condensation.</strong> Chem. Rev., 118(4):1691–1741.</p>
</div>



<!-- / FIM Conteúdo personalizado -->
</div>
<?= $this->endSection() ?>