<?php include('head.php') ?>
<body class="main-body app sidebar-mini ltr light-theme open">

<?php include('header.php') ?>

<?php include('sidebar.php') ?>
<div class="jumps-prevent" style="padding-top: 20px;"></div>


<div class="main-content app-content">

<div class="main-container container-fluid">

<div class="main-content-body">
<div class="row row-sm">


<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">
<div class="col-md-12">

<div class="card">
<div class="card-header">
<div class="card-title">View Request</div>
</div>
<div class="card-body" style="overflow:auto;">

<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
<thead>
<tr align="center">
<td align="center"><strong>Sl_No</strong></td>
<td align="center"><strong>User_ID</strong></td>
<td align="center"><strong>Name</strong></td>
<td align="center"><strong>UTR No.</strong></td>
<td align="center"><strong>Screenshot</strong></td>
<td align="center"><strong>Amount</strong></td>
<td align="center"><strong>Verify Status</strong></td>
<td align="center"><strong>Status</strong></td>
<td align="center"><strong>Date</strong></td>
<td align="center"><strong>Action</strong></td>
</tr>
</thead>
<tbody>
<?php
$where = "ORDER BY `id` DESC";
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'search' && !empty($_POST['search'])) {
    $search = trim(mysqli_real_escape_string($conn, $_POST['search']));
    $where = "WHERE `userid` LIKE '%$search%' ORDER BY `id` DESC";
}
$sql = "SELECT * FROM `mi_member_payment` $where LIMIT 100";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
$i = 1;
?>
<tbody>
<?php if ($num > 0): while ($fetch = mysqli_fetch_assoc($result)): $i++; ?>
    <tr>
        <td align="center"><?= $i-1 ?></td>
        <td align="center"><?= htmlspecialchars($fetch['userid']) ?></td>
        <td align="center"><?= htmlspecialchars(getMemberUserid($conn, $fetch['userid'], 'name') ?? '') ?></td>
        <td align="center"><?= htmlspecialchars($fetch['tranid']) ?></td>
        <td align="center"><?php if(!empty($fetch['slip'])): ?>
            <a href="../mem/uploads/screenshots/<?= htmlspecialchars($fetch['slip']) ?>" target="_blank">
                <img src="../mem/uploads/screenshots/<?= htmlspecialchars($fetch['slip']) ?>" style="width:50px;height:50px;object-fit:cover;">
            </a>
        <?php else: ?>-<?php endif; ?></td>
        <td align="center">$ <?= htmlspecialchars($fetch['amount']) ?></td>
        <td align="center" style="padding:5px;">
            <?php
            $note = $fetch['verify_note'] ?? '';
            if($fetch['status'] == 'C' && strpos($note,'Auto Verified') !== false) {
                echo '<span style="color:#fff;background:#009900;padding:2px 8px;border-radius:5px;">✅ ' . htmlspecialchars($note) . '</span>';
            } elseif($fetch['status'] == 'C') {
                echo '<span style="color:#fff;background:#009900;padding:2px 8px;border-radius:5px;">✅ Admin Approved</span>';
            } else {
                echo '<span style="color:#fff;background:#cc6600;padding:2px 8px;border-radius:5px;">⏳ ' . htmlspecialchars($note) . '</span>';
            }
            ?>
        </td>
        <td align="center" style="padding:5px;">
            <?php if ($fetch['status'] == 'P'): ?>
                <a href="payment-request-process?case=status&amp;id=<?= $fetch['id'] ?>&amp;st=P" style="text-decoration:none;" onclick="return confirm('Approve this deposit?');">
                    <span style="color:#fff;background:#FF0000;padding:2px 10px;border-radius:5px;">Pending</span>
                </a>
            <?php else: ?>
                <span style="color:#fff;background:#009900;padding:2px 10px;border-radius:5px;">Approved</span>
            <?php endif; ?>
        </td>
        <td align="center"><?= htmlspecialchars($fetch['date']) ?></td>
        <td align="center">
            <?php if ($fetch['status'] == 'P'): ?>
                <a href="payment-request-process?case=delete&amp;id=<?= $fetch['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this request?');">
                    <i class="fa fa-times"></i>
                </a>
            <?php else: ?>---<?php endif; ?>
        </td>
    </tr>
<?php endwhile; else: ?>
    <tr><td colspan="10" align="center" style="color:#FF0000;">No Record Found!</td></tr>
<?php endif; ?>
</tbody>
</table>

</div>
</div>
</div>
</div>

</div>
</div>
</div>


</div>
</div>
<script type="text/javascript">
//<![CDATA[

theForm.oldSubmit = theForm.submit;
theForm.submit = WebForm_SaveScrollPositionSubmit;

theForm.oldOnSubmit = theForm.onsubmit;
theForm.onsubmit = WebForm_SaveScrollPositionOnSubmit;
//]]>
</script>
</form>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
<script src="assets/plugins/bootstrap/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/ionicons/ionicons.js"></script>
<script src="assets/plugins/chart.js/Chart.bundle.min.js"></script>
<script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="assets/js/chart.flot.sampledata.js"></script>
<script src="assets/js/eva-icons.min.js"></script>
<script src="assets/plugins/moment/moment.js"></script>
<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/p-scroll.js"></script>
<script src="assets/plugins/side-menu/sidemenu.js"></script>
<script src="assets/js/sticky.js"></script>
<script src="assets/plugins/sidebar/sidebar.js"></script>
<script src="assets/plugins/sidebar/sidebar-custom.js"></script>
<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/morris.js/morris.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/index.js"></script>
<script src="assets/js/themecolor.js"></script>
<script src="assets/js/swither-styles.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/switcher/js/switcher.js"></script>
<script>
        $(document).ready(function () {
            $("#copy").text($("#ref_link").val());
            $('.clipboard').on('click', function () {
                var $temp = $("<input>");
                var $url = $("#ref_link").val();//$(location).attr('href');
                //$("#linkModal").modal();
                $("body").append($temp);
                $temp.val($url).select();
                document.execCommand("copy");
                //$("#lblCopyLink").text($temp[0].value);
                alert("link copied");
                $temp.remove();
            });
        });
    </script>
</body>
</html>
