<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<link rel="stylesheet" href="<?php echo base_url('/css/dt.css'); ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<div style="background-color:#e4e4e4; height:180px; margin-bottom: 20px">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-xs-12">
                <br><br>
                <h2 class="title_h2">
                    <div class="dropdown" title="Export files">
                          
                        <div class="dropdown">
  <button class="btn btn-lg btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
  <?php echo $id; ?> 
  </button>
  <ul class="dropdown-menu">
    <li><b class="ms-3">Download<br></b></li>
    <li><a class="dropdown-item mt-2" href="<?php echo base_url(); ?>/data/<?php echo $id; ?>/2LZM_contacts.txt">Contacts</a></li>
    <li><a class="dropdown-item" href="<?php echo base_url(); ?>/data/<?php echo $id; ?>/data.pdb">PDB file</a></li>
</ul>
</div>

                    </div>
                </h2>
                <p><strong><a href='<?php echo base_url(); ?>result/id/<?php echo $id; ?>'><?php echo base_url(); ?>project/<?php echo $id; ?></a> </strong></p>
            </div>

            <div class="col-md-3 col-xs-12" style="height: 180px; background-color: #00bc9e; color:#fff">
                <p style="text-align: center; font-size: 90px; padding-top:10px">
                    <strong id="mutations_found_title"><?php echo $total_results; ?></strong>
                </p>

                <p style="font-size: 12px; text-align:center; margin-top: -20px">
                    contacts found
                    <a href="#" data-toggle="modal" data-target="#help" style="color:#fff"><span class="glyphicon glyphicon-info-sign"></span></a>
                </p>
            </div>
        </div> 
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-9" ng-if="cttlok">

            <div class="btn-group" role="group" aria-label="...">
              <span class="btn btn-dark" id="basic-addon1"><b>Filters: </b></span>
              <div class="btn-group" role="group">
                <button type="button" id="show_all" class="btn btn-primary">Show all</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" id="positive" class="btn btn-danger">Positive</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" id="negative" class="btn btn-info">Negative</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" id="hydrophobic" class="btn btn-success">Hydrophobic</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" id="aromatic" class="btn btn-warning">Aromatic</button>
              </div>
              <div class="btn-group" role="group">
                <button type="button" id="disulfide" class="btn btn-outline-dark">Disulfide</button>
              </div>
            </div>
            <br>
            
            <div class="table-responsive">
                <table class="display" id="mut">
                    <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Chain1</th>
                            <th>R1</th>
                            <th>Atom1</th>
                            <th>Chain2</th>
                            <th>R2</th>
                            <th>Atom2</th>
                            <th>Distance</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($contacts as $contact){ ?> 
                        <?php $m = explode(',',$contact); $len_mut = count($m); if(($len_mut <5)or($m[0]=='Chain1')){ continue; } ?>
                        <tr onmouseover="selectID(glviewer,this.children[0].innerHTML,1,'<?php echo 'A'; ?>')" id="<?php echo $m[2].$m[1].'/'.$m[6].$m[5]; ?>">
                            <td><?php echo $m[2].$m[1].'/'.$m[6].$m[5]; ?></td>
                            <td><?php echo $m[0]; ?></td>
                            <td><?php echo $m[2];echo $m[1]; ?></td>
                            <td><?php echo $m[3]; ?></td>
                            <td><?php echo $m[4]; ?></td>
                            <td><?php echo $m[6];echo $m[5]; ?></td>
                            <td><?php echo $m[7]; ?></td>
                            <td><?php echo $m[8]; ?></td>
                            <td><?php echo $m[9]; ?></td>
                       </tr>
                       <?php } ?>
                   </tbody>
               </table>
           </div>
       </div>


        <div class="col-md-3">

            <style>.affix{ top: 100px; z-index: 9999 !important; }</style>
            
            <style>#pdb canvas { position: relative !important; }</style>
            <div data-spy="affix" id="affix" data-offset-top="240" data-offset-bottom="250">
                <div id="pdb" style="height: 400px; width: 280px"></div>
                <p style="color:#ccc; text-align: right">Wild protein</p>
            </div>
        </div>
    </div>
</div>

<!-- Return to Top -->
<a href="#" title="Return to top" style="font-size:25px; position:fixed; right:10px; bottom:10px"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>



<script>

$(document).ready( function () {
    var table = $('#mut').DataTable( {
        "paging": false
    } );
    $('#negative').click(function(){
        table.columns(1).search("(D|E)[0-9]",true, false).draw();    
    });
    $('#positive').click(function(){
        table.columns(1).search("(R|H|K)[0-9]",true, false).draw();    
    });
    $('#aromatic').click(function(){
        table.columns(1).search("(F|W|Y)[0-9]",true, false).draw();    
    });
    $('#hydrophobic').click(function(){
        table.columns(1).search("(A|V|L|F|P|W|M|I)[0-9]",true, false).draw();    
    });
    $('#disulfide').click(function(){
        table.columns(1).search("C.*[0-9]",true, false).columns(4).search("C.*[0-9]",true, false).draw();   
    });
    $('#show_all').click(function(){
        table.columns(1).search(".*",true,false).draw();    
    });
       
    
} );


$('nav').css('position', 'relative');

function highlight(pos){
    $(pos).css("background-color","#f2dede");
}

// 3DMOL **********************************************************************
/* Select ID */
function selectID(glviewer,residues,type,chain){

    residues = residues.split("/");


    var res1 = residues[0].substr(1);
    var res2 = residues[1].substr(1);
    
    glviewer.setStyle({},{line:{color:'grey'},cartoon:{color:'white'}}); /* Cartoon multi-color */
    glviewer.setStyle({resi:res1},{stick:{colorscheme:'whiteCarbon'}}); 
    glviewer.setStyle({resi:res2},{stick:{colorscheme:'whiteCarbon'}}); 
    
    glviewer.zoomTo({resi: [res1,res2], chain:chain}); 
    
    glviewer.render();

}


function selectPDB(id){

    var ids = id.split("_");
    var mut = ids[1].replace("/","_");

    try {
        var pos = mut.split("_");
        var pos1 = pos[0].substr(1,pos[0].length-2);
        var pos2 = pos[1].substr(1,pos[1].length-2);
        var pos1a = Number(pos1) - 1;
        var pos1d = Number(pos1) + 1;
        var pos2a = Number(pos2) - 1;
        var pos2d = Number(pos2) + 1;
        pos1a = pos1a.toString();
        pos1d = pos1d.toString();
        pos2a = pos2a.toString();
        pos2d = pos2d.toString();
    }
    catch(err) {
        var erro = 1;
    }
    

    var atomcallback = function(atom, viewer) {
        if (atom.clickLabel === undefined
            || !atom.clickLabel instanceof $3Dmol.Label) {
            atom.clickLabel = viewer.addLabel(atom.resn + " " + atom.resi + " ("+ atom.elem + ")", {
                fontSize : 10,
                position : {
                    x : atom.x,
                    y : atom.y,
                    z : atom.z
                },
                backgroundColor: "black"
            });
            atom.clicked = true;
        }

        //toggle label style
        else {

            if (atom.clicked) {
                var newstyle = atom.clickLabel.getStyle();
                newstyle.backgroundColor = 0x66ccff;

                viewer.setLabelStyle(atom.clickLabel, newstyle);
                atom.clicked = !atom.clicked;
            }
            else {
                viewer.removeLabel(atom.clickLabel);
                delete atom.clickLabel;
                atom.clicked = false;
            }
        }
    };

}

$(document).ready(function(){

    //var title_pdb = $(".title_h2").text();
    //title_pdb = title_pdb.split(": ")

    //var txt = "https://files.rcsb.org/download/"+title_pdb[1]+".pdb";
    var txt = "<?php echo base_url(); ?>/data/<?php echo $id; ?>/data.pdb";
    
    $.post(txt, function(d) {

        moldata = data = d;

        /* Creating visualization */
        glviewer = $3Dmol.createViewer("pdb", {
            defaultcolors : $3Dmol.rasmolElementColors
        });

        /* Color background */
        glviewer.setBackgroundColor(0xffffff);

        receptorModel = m = glviewer.addModel(data, "pqr");

        /* Type of visualization */
        glviewer.setStyle({},{line:{color:'grey'},cartoon:{color:'white'}}); /* Cartoon multi-color */
        
        /*glviewer.addSurface($3Dmol.SurfaceType, {opacity:0.3});  Surface */

        /* Name of the atoms */
        atoms = m.selectedAtoms({});
        for ( var i in atoms) {
            var atom = atoms[i];
            atom.clickable = true;
            atom.callback = atomcallback;
        }

        glviewer.mapAtomProperties($3Dmol.applyPartialCharges);
        glviewer.zoomTo();
        glviewer.render();

    });

    var atomcallback = function(atom, viewer) {
        if (atom.clickLabel === undefined
            || !atom.clickLabel instanceof $3Dmol.Label) {
            atom.clickLabel = viewer.addLabel(atom.resn + " " + atom.resi + " ("+ atom.elem + ")", {
                fontSize : 10,
                position : {
                    x : atom.x,
                    y : atom.y,
                    z : atom.z
                },
                backgroundColor: "black"
            });
            atom.clicked = true;
        }

        //toggle label style
        else {

            if (atom.clicked) {
                var newstyle = atom.clickLabel.getStyle();
                newstyle.backgroundColor = 0x66ccff;

                viewer.setLabelStyle(atom.clickLabel, newstyle);
                atom.clicked = !atom.clicked;
            }
            else {
                viewer.removeLabel(atom.clickLabel);
                delete atom.clickLabel;
                atom.clicked = false;
            }
        }
    };
});

</script>

<?= $this->endSection() ?>