<h3 class="header smaller lighter">
    Required Components
    <span class="pull-right">
        <a href="#" onclick="return goBack();" class="btn btn-xs btn-warning"><i
                    class="fa fa-arrow-left"></i> Back</a>
    </span>
</h3>
<?php echo getMessage();?>
<div class="row">
    <div class="col-md-12">
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Component Name</th>
                    <th>Job Id</th>
                    <th>Added By</th>
                    <th>Created on</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(!empty($components)){
                    $i=1;
                    foreach($components as $component){
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo $component['component_name']?></td>
                        <td><?php echo $component['job_id']?></td>
                        <td><?php echo $component['user_name']?></td>
                        <td><?php echo dateDB2SHOW($component['created_on']);?></td>
                        <td><a href="<?php echo get_role_based_link();?>/components/required-components/?act=del&pk_id=<?php echo $component['pk_id']?>" onclick="return confirm('Do you want to remove ?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php
                    $i++;    
                    }
                 }else{
                     echo "<tr><td colspan='6' class='text-center text-danger'>No Requirement found !</td></tr>";
                 }
                ?>
            </tbody>
        </table>
    </div>
</div>