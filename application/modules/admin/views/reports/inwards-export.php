<?php
header("Content-type: application/vnd-ms-excel;charset=UTF-8");
header("Content-Disposition: attachment; filename=".$fileName.".xls");
?>
<style>
    .bgGreen{
        background:green;color:white;
    }
    </style>
<table border="1" class="table table-bordered">
    <thead>
    <tr>
        <th class='bgGreen'>S.No</th>
        <th class='bgGreen' colspan='2'>Inward Information</th>        
        <th class='bgGreen' colspan='4'>Customer Information</th>       
        <th class='bgGreen' colspan='4'>Product Information (@ added to Serial No Kindly Remove after downloading)</th>                
        <th class='bgGreen'>Outward Date</th>
        <th class='bgGreen' colspan='2'>Status Info</th>        
        <th class='bgGreen' colspan='3'>Amount Information</th>       
    </tr>
    <tr>
        <th>S.No</th>
        <th>Inward Date</th>
        <th>Job No</th>
        
        <th>Customer ID</th>
        <th>Customer Name</th>
        <th>Phone No</th>
        <th>City</th>
        <th>Product</th>
        <th>Model No</th>
        <th>Manfac. Name</th>
        <th>Serial No </th>
        <th>Outward Date</th>
        <th>Gate Pass No</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Amount Paid</th>
        <th>Amount Due</th>
    </tr>
    </thead>
    <tbody>
        <?php if(!empty($results)){
            $count = count($results);
            $k=1;
            for($i=$count;$i>=1;$i--){
                $j = $i-1;
                $result = $results[$j];
            //foreach($results as $k=>$result){ 
                ?>
                <tr>
                    <td><?php echo $k; ?></td>
                    <td><?php echo dateNameDB2SHOW($result['created_on']); ?></td>
                    <td><?php echo $result['job_id']; ?></td>            
                    <td><?php echo $result['customer_id']; ?></td>
                    <td><?php echo $result['customer_name']; ?></td>
                    <td><?php echo !empty($result['mobile']) ? $result['mobile'] : ''; ?></td>
                    <td><?php echo $result['city']; ?></td>
                    <td><?php echo $result['product']; ?></td>
                    <td><?php echo $result['model_no']; ?></td>
                    <td><?php echo $result['manufacturer_name']; ?></td>
                    <td><?php echo "@".$result['serial_no']; ?></td>
                    
                    <td><?php echo dateNameDB2SHOW($result['outward_date']); ?></td>
                    <td><?php echo $result['gatepass_no']; ?></td>
                    <td><?php echo $result['status']; ?></td>

                    <td><?php echo $result['estimation_amt']; ?></td>
                    <td><?php echo $result['paid_amt']; ?></td>
                    <td><?php 
                    $due = $result['estimation_amt']-$result['paid_amt'];
                    echo round($due,2); ?></td>
                </tr>
            <?php $k++; }
        }else{
            echo "<tr><td colspan='16'>No Data found for your search creteria</td></tr>";
        } ?>
    </tbody>
</table>
