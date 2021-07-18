<?php
    function isNotEmpty($data){
        return !empty($data) ? $data :'';
    }
?>
<h3 class="header smaller lighter">
    Companies List
    <span class="pull-right">
        <a  href="#" onclick="goBack();" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back </a>
    </span>
</h3>
<?php echo getMessage(); ?>
<div class="clearfix"></div>
<table id="dtable" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Customer Name</th> 
        <th>Company Name</th>
        <th>Company Email</th>
        <th>Contact Person</th>
        <th>Mobile</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php if(!empty($customer_companies)){
                $i=1;
                foreach($customer_companies as $company){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo isNotEmpty($company['customer_name']);?></td>
                        <td><?php echo isNotEmpty($company['company_name']);?></td>
                        <td><?php echo isNotEmpty($company['company_mail']);?></td>
                        <td><?php echo isNotEmpty($company['contact_name']);?></td>
                        <td><?php echo isNotEmpty($company['phone']);?></td>
                        <td><a href="<?php echo get_role_based_link()?>/customers/view/<?php echo isNotEmpty($company['customer_pk_id'])?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    <?php
                    $i++;
                }
             }else
                    echo "<tr><td colspan='5' class='text-danger text-center'>No data found !</td></tr>";
        ?>
    </tbody>
</table>