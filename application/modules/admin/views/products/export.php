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
        <th>S.No</th>
        <th>Product Type</th>
        <th>Make</th>        
        <th>Product Name</th>
        <th>Model</th>
        <th>Serial No</th>
        <th>Description</th>
        <th>Price</th>
        <th>Condition</th>
        <th>Warranty</th>
        <th>Added Date</th>
        <th>Is Sold</th>
        <th>Shipping</th>
        <th>Returns</th>
        <th>Delivery Estimation (In Days)</th>
        <th>Image 1</th>
        <th>Image 2</th>
        <th>Image 3</th>
        <th>Image 4</th>        
    </tr>
    </thead>
    <tbody>
        <?php if(!empty($results)){
            $count = count($results);
            $k=1;
            for($i=$count;$i>=1;$i--){
                $j = $i-1;
                $result = $results[$j];            
                ?>
                <tr>
                    <td><?php echo $k; ?></td>                    
                    <td><?php echo $result['category_name']; ?></td>            
                    <td><?php echo $result['company_name']; ?></td>
                    <td><?php echo $result['product_name']; ?></td>
                    <td><?php echo !empty($result['model_no']) ? $result['model_no'] : ''; ?></td>
                    <td><?php echo $result['serial_no']; ?></td>
                    <td><?php echo $result['description']; ?></td>
                    <td><?php echo $result['price']; ?></td>
                    <td><?php echo $result['product_condition']; ?></td>
                    <td><?php echo $result['warranty']; ?></td>                    
                    <td><?php echo dateNameDB2SHOW($result['created_on']); ?></td>
                    <td><?php echo $result['is_sold']; ?></td>
                    <td><?php echo $result['shipping']; ?></td>
                    <td><?php echo $result['returns']; ?></td>
                    <td><?php echo $result['delivery_estimation']; ?></td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                                                               
                </tr>
            <?php $k++; }
        }else{
            echo "<tr><td colspan='19'>No Data found for your search creteria</td></tr>";
        } ?>
    </tbody>
</table>
