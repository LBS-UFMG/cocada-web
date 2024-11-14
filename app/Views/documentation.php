<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<div class="container py-5 text-secondary">
<!-- Conteúdo personalizado -->

<h1 class="pb-5 text-dark">Documentation</h1>



<h3>COCαDA - Large Scale Protein Interatomic Contact Optimization by Cα Distance Matrices
</h3>

<p>COCαDA (Contact Optimization by alpha-Carbon Distance Analysis) optimizes the calculation of atomic interactions in proteins, by using a set of fine-tuned Cα distances between every pair of aminoacid residues. The code includes a customized parser for both PDB and CIF files, containing functionalities for handling large files, filtering out specific residues and interactions, and calculating geometric properties such as centroid and normal vectors for aromatic residues.</p>

<p>Additionaly, as comparison for demonstrating the efficiency of our method, a Biopython-dependent script is also included (in the folder Biopython), containing the same restrictions and contact definitions.</p>

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
</p>



<!-- / FIM Conteúdo personalizado -->
</div>
<?= $this->endSection() ?>
