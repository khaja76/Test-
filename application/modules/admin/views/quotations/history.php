<div class="header smaller lighter">
    <h4><i class="fa fa-user"></i> Quotations History Information
    <span class="pull-right">
        <a class="btn btn-xs btn-warning"  href="#" onclick="goBack();" >Back</a>
    </span>
    </h4>
</div>
<?php echo getMessage(); ?>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>Quotation No </th>
        <th>Proforma No</th>
        <th>Customer Name</th>
        <th>Quotation Date</th>
        <th>Amount ( <i class="fa fa-inr"></i> )</th>
        <th>Created On</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($quotations)){
        $i = 1;
        foreach($quotations as $quotation){ ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo !empty($quotation['quotation']) ? $quotation['quotation'] : ''; ?></td>
                <td><?php echo !empty($quotation['pro_invoice']) ? $quotation['pro_invoice'] : '-'; ?></td>
                <td><?php echo !empty($quotation['customer_name']) ? $quotation['customer_name'] : ''; ?></td>
                <td><?php echo !empty($quotation['quotation_date']) ? dateDB2SHOW($quotation['quotation_date']) : ''; ?></td>
                <td><?php echo !empty($quotation['final_amount']) ? $quotation['final_amount'] : ''; ?></td>
                <td><?php echo !empty($quotation['created_on']) ? dateTimeDB2SHOW($quotation['created_on']) : ''; ?></td>
                <td>
                    <a href="<?php echo base_url() ?>admin/quotations/view-history/<?php echo $quotation['pk_id'] ?>" data-toggle="tooltip" title="View" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> </a>
                </td>
            </tr>
            <?php $i++;
        }
    }else{
        echo "<tr><td colspan='8'>No data Found</td></tr>";
    }
    ?>
    </tbody>
</table>