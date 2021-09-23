<script>
    $(document).ready(function()
    {        
        <?php if($dataTableElement): ?>
            if($('#<?=$dataTableElement?>').length)
            {
                $('#<?=$dataTableElement?>').DataTable({
                    "processing": true,        
                    "serverSide": true,
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthMenu": [ 10, 25, 50,100 ],
                    "pageLength":10,        
                    "order": [],        
                    "ajax": {
                        "url": '<?=$dataTableURL?>',
                        "type": "POST"
                    },
                    <?php if($dataTableElement == "usersList"): ?>
                    "columns": [                        
                            null,
                            null,
                            null,
                            null,
                            { "width": "100px" },
                            null,
                            null,
                            null,                        
                    ],        
                    <?php endif; ?>                    
                    "columnDefs": [{ 
                        "targets": [0],
                        "orderable": true
                    }]
                });
            }
        <?php endif; ?>
        <?php if($dataTableElement2): ?>
            if($('#<?=$dataTableElement2?>').length)
            {
                $('#<?=$dataTableElement2?>').DataTable({
                    "processing": true,        
                    "serverSide": true,
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthMenu": [ 10, 25, 50,100 ],
                    "pageLength":10,        
                    "order": [],        
                    "ajax": {
                        "url": '<?=$dataTableURL2?>',
                        "type": "POST"
                    },                                        
                    "columnDefs": [{ 
                        "targets": [0],
                        "orderable": true
                    }]
                });
            }
        <?php endif; ?>
        <?php if($dataTableElement3): ?>
            if($('#<?=$dataTableElement3?>').length)
            {
                $('#<?=$dataTableElement3?>').DataTable({
                    "processing": true,        
                    "serverSide": true,
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthMenu": [ 10, 25, 50,100 ],
                    "pageLength":10,        
                    "order": [],        
                    "ajax": {
                        "url": '<?=$dataTableURL3?>',
                        "type": "POST"
                    },                                        
                    "columnDefs": [{ 
                        "targets": [0],
                        "orderable": true
                    }]
                });
            }
        <?php endif; ?>
    })
</script>