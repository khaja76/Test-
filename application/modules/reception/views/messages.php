<h3 class="header smaller lighter">
    Messages
</h3>
<div class="col-sm-12">
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#inbox">
                    <i class="blue ace-icon fa fa-inbox bigger-120"></i>
                    Inbox Messages
                    <span class="badge badge-warning">4</span>
                </a>
            </li>
            <li class="hide">
                <a data-toggle="tab" href="#compose">
                    <i class="blue ace-icon fa fa-commenting bigger-120"></i>
                    Compose Message
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#sent">
                    <i class="blue ace-icon fa fa-paper-plane-o bigger-120"></i>
                    Sent Messages
                    <span class="badge badge-success">14</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="inbox" class="tab-pane fade in active">
                <table class="table table-bordered table-hover datatable-custom">
                    <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Text Message</th>
                        <th>Job Id</th>
                        <th>Message From</th>
                        <th>Received Date</th>
                        <th> Time</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php for($i=1;$i<=5;$i++){ ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>Repairing for the item of Job-Id:HFT/2017/07/006 need to start, as customer approves for this.</td>
                            <td>HFT/2017/07/006</td>
                            <td>Reception</td>
                            <td>9/7/2017</td>
                            <td>20:13 PM</td>

                        </tr>
                    <?php } ?>


                    </tbody>
                </table>
            </div>
            <div id="compose" class="tab-pane fade hide">
                <div class="col-sm-offset-2 col-sm-8">
                    <form class="form-horizontal" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="compose-text">Text Message :</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="compose-text" rows="5" placeholder="Enter Your Text Message ..."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="compose-job-id">Job Id :</label>
                            <div class="col-sm-4">
                                <input id="compose-job-id" type="text" class="form-control" placeholder="Enter Job Id ..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="compose-send-to">Send To :</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="compose-send-to">
                                    <option>----- Message To -----</option>
                                    <option>Admin</option>
                                    <option>All Engineers</option>
                                    <option>All Receptionist</option>
                                    <option>Receptionist</option>
                                    <option>Engineers</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-paper-plane-o"></i> Send</button>
                                <button type="button" class="btn btn-xs btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="sent" class="tab-pane fade">
                <table class="table table-bordered table-hover datatable-custom">
                    <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Text Message</th>
                        <th>Job Id</th>
                        <th>Message To</th>
                        <th>Sent Date</th>
                        <th>Sent Time</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Repairing for the item of Job-Id:HFT/2017/07/004 need to start, as customer approves for this.</td>
                        <td>HFT/2017/07/004</td>
                        <td>Reception</td>
                        <td>20/7/2017</td>
                        <td>12:1:45 AM</td>

                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Repairing for the item of Job-Id:HFT/2017/07/006 need to start, as customer approves for this.</td>
                        <td>HFT/2017/07/006</td>
                        <td>Reception</td>
                        <td>9/7/2017</td>
                        <td>20:13:48 PM</td>

                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Repairing for the item of Job-Id:HFT/2017/07/004 need to start, as customer approves for this.</td>
                        <td>HFT/2017/07/004</td>
                        <td>Reception</td>
                        <td>8/7/2017</td>
                        <td>17:38:43 PM</td>

                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Repairing for the item of Job-Id:HFT/2017/07/003 need to start, as customer approves for this.</td>
                        <td>HFT/2017/07/003</td>
                        <td>Reception</td>
                        <td>4/7/2017</td>
                        <td>14:34:2 PM</td>

                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Repairing for the item of Job-Id:HFT/2017/07/002 need to stop, as customer is not willing to move forward.</td>
                        <td>HFT/2017/07/002</td>
                        <td>Reception</td>
                        <td>4/7/2017</td>
                        <td>14:0:18 PM</td>

                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Repairing for the item of Job-Id:HFT/2017/07/001 need to start, as customer approves for this.</td>
                        <td>HFT/2017/07/001</td>
                        <td>Reception</td>
                        <td>4/7/2017</td>
                        <td>11:46:49 AM</td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
