<?= showMsg(); ?>
<?= getBredcrum(SUBADMIN, array('#' => 'Manage code')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>code</strong></h2>
    </div>
</div>

<table class="table table-bordered" id="portal-table-codes">
    <thead>
        <tr>
            <th width="5%" class="text-center">Sr#</th>
            <th>Code</th>
            <th>Price</th>
            <th>Tier Margin</th>
            <th>Status</th>
        </tr>
    </thead>

</table>


<script>
    $j(document).ready(function() {
        $j('#portal-table-codes').DataTable({
            "processing": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
            },
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": base_url + 'portal/code/portal_fetch_codes',
                "type": "POST"
            },
            "stateSave": true,
            "columnDefs": [{
                // "targets": [0,2,3],
                "orderable": false
            }]
        });
    });
</script>