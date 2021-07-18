<style>
    .req_cursor {
        cursor: pointer;
    }
</style>
<?php
if (!empty($_SESSION['ROLE'])) {

    ?>
    <h3 class="header smaller lighter">
        <?php echo !empty($alertCnt) ? 'Alert Components' : ' Components' ?>
        <span class="pull-right">
            <?php if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ADMIN') { ?>
                <a href="<?php echo get_role_based_link(); ?>/components/import/" class="btn btn-xs btn-info"><i class="fa fa-file-excel-o"></i>  Import</a>
                <a href="<?php echo get_role_based_link(); ?>/components/add/" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i>  Add</a>
            <?php } ?>

    </span>
    </h3>
    <?php echo getMessage(); ?>
    <div class="clearfix"></div>
    <div>
        <?php if (!empty($alertCnt)) { ?>
            <div onclick="javascript:location.href='<?php echo get_role_based_link(); ?>/components/alert-components/'" class="infobox infobox-md infobox-red req_cursor">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-bell-o"></i>
                </div>
                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $alertCnt; ?> </span>
                    <div class="infobox-content">Alert Quantity</div>
                </div>
            </div>
        <?php }
        if (!empty($required)) { ?>
            <div onclick="javascript:location.href='<?php echo get_role_based_link(); ?>/components/required-components/'" class="infobox infobox-md infobox-orange req_cursor">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-circle-o-notch"></i>
                </div>
                <div class="infobox-data">
                    <span class="infobox-data-number"><?php echo $required ?></span>
                    <div class="infobox-content">Required Components</div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <div class="space-4"></div>
    <table class="table table-bordered table-hover" id="<?php echo !empty($components) ? 'dtable' : ''; ?>">
        <thead>
        <tr>
            <th>S. No.</th>
            <th>Component Name</th>
            <th>Location</th>
            <th>Component Type</th>
            <th> Model No</th>
            <th>Description</th>
            <th> Quantity</th>
            <th> Alert Quantity</th>
            <?php if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ADMIN') { ?>
                <th>Actions</th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($components)) {
            $i = 1;
            foreach ($components as $component) {
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo !empty($component['company_name']) ? $component['company_name'] : ''; ?></td>
                    <td><?php echo !empty($component['location']) ? $component['location'] : ''; ?></td>
                    <td><?php echo !empty($component['component_name']) ? $component['component_name'] : ''; ?></td>
                    <td><?php echo !empty($component['model_no']) ? $component['model_no'] : ''; ?></td>
                    <td><?php echo !empty($component['description']) ? $component['description'] : ''; ?></td>
                    <td><?php echo !empty($component['quantity']) ? $component['quantity'] : 0; ?></td>
                    <td><?php echo !empty($component['alert_quantity']) ? $component['alert_quantity'] : 0; ?> </td>
                    <?php if (!empty($_SESSION['ROLE']) && $_SESSION['ROLE'] == 'ADMIN') { ?>
                        <td>
                            <a href="<?php echo get_role_based_link(); ?>/components/edit/<?php echo $component['pk_id']; ?>"
                               title='Edit' class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom"><i
                                        class="ace-icon fa fa-pencil bigger-120"></i></a></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php $i++;
            }
        } else {
            echo "<tr><td class='text-center text-danger' colspan='9'>No data found !</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
} ?>
